<?php
session_start();

if (!isset($_SESSION['access_token']) || $_SESSION['tipo'] != "admin") {
    header("Location: ./404.html");
    exit();
}

require_once('./keycloack2/config_tarjetas.php');

// Función para obtener el token de acceso
function obtenerTokenDeAcceso($token_url, $client_id, $client_secret)
{
    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'grant_type' => 'client_credentials',
        'client_id' => $client_id,
        'client_secret' => $client_secret,
    ]));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
    ]);

    // Deshabilitar validación del certificado
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        throw new Exception('Error al obtener el token de acceso: ' . curl_error($ch));
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if (isset($data['access_token'])) {
        return $data['access_token'];
    } else {
        throw new Exception('No se pudo obtener el token de acceso.');
    }
}

// Función para obtener la lista de usuarios
function obtenerUsuarios($users_url, $access_token)
{
    $ch = curl_init($users_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json',
    ]);

    // Deshabilitar validación del certificado
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Error al obtener la lista de usuarios: ' . curl_error($ch));
    }
    curl_close($ch);

    $data = json_decode($response, true);
    if (is_array($data)) {
        return $data;
    } else {
        throw new Exception('No se pudo obtener la lista de usuarios.');
    }
}

try {
    // Obtener el token de acceso
    $access_token = obtenerTokenDeAcceso($token_url, $client_id, $client_secret);

    // Obtener la lista de usuarios
    $usuarios = obtenerUsuarios($users_url, $access_token);

} catch (Exception $e) {
    $usuarios = [];
    $error = $e->getMessage();
}
