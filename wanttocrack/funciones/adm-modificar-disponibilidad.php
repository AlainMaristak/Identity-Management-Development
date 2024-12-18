<?php
session_start(); // Iniciar la sesión

// Verificar si la sesión está activa
if (!isset($_SESSION['access_token']) || $_SESSION['tipo'] != "admin") {
    header("Location: ../404.html");
    exit();
}

// Incluir el archivo de configuración
require_once('../keycloack2/config_tarjetas.php');

// Comprobar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Obtener los valores del formulario
    $userId = $_GET['id'];
    $enabled = filter_var($_GET['enabled'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

    // Validar que el ID del usuario y el estado 'enabled' estén presentes
    if (!$userId || is_null($enabled)) {
        echo json_encode(['status' => 'error', 'message' => 'El ID y el estado del usuario son obligatorios']);
        exit;
    }

    // Obtener el token de administración de Keycloak
    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'grant_type' => 'client_credentials',
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200) {
        echo json_encode(['status' => 'error', 'message' => 'Error al obtener el token de administración']);
        exit;
    }

    $tokenData = json_decode($response, true);
    $adminToken = $tokenData['access_token'];

    // Actualizar el estado del usuario (habilitar/deshabilitar)
    $userUpdateData = [
        'enabled' => $enabled,
    ];

    $ch = curl_init($users_url . '/' . $userId);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: ' . 'Bearer ' . $adminToken,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userUpdateData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 204) {
        $action = $enabled ? 'habilitado' : 'deshabilitado';
        echo json_encode(['status' => 'success', 'message' => "Usuario {$action} con éxito"]);
    } else {
        $error = json_decode($response, true);
        echo json_encode(['status' => 'error', 'message' => $error['errorMessage'] ?? 'Error al actualizar el usuario']);
    }
}
