<?php
if (isset($_GET['app'])) {
    $app = $_GET['app'];
    if ($app != 'tarjetas' && $app != 'otro') {
        header('Location: ../index.php');
        die();
    }
} else {
    header('Location: ../index.php');
    die();
}

// Incluir el archivo de configuración
require_once($_SERVER['DOCUMENT_ROOT'] . '/Identity-Management-Development/WEB/test/config.php');
// Generar una URL de autenticación
$auth_url = $keycloak_url . '?response_type=code&client_id=' . $client_id . '&redirect_uri=' . urlencode($redirect_uri);
 
// Verificar si no hay un token de acceso en la sesión
if (!isset($_SESSION['access_token'])) {
    header('Location: ' . $auth_url);
    exit;
}
 
// Si ya existe el token, puedes redirigir al dashboard u otra página
header('Location: ../emp-panel.php');
exit;
 