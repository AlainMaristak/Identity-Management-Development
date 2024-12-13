<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }$app = $_SESSION['app'];

if ($app == 'tarjetas') {
    // Configuración de Keycloak para la aplicación de tarjetas
    $realm = 'wanttocrack';  // Nombre del realm
    $client_id = 'xampp-web';  // ID del cliente registrado en Keycloak
    $client_secret = 'F5MaQVnAyUaIOilteFJZw3Tnyn7TFYf5';  // Secreto del cliente
    $redirect_uri = 'http://192.168.214.1/Identity-Management-Development/WEB/keycloack/callback.php';  // URL de callback
    $redirect_uriLogOut = 'http://192.168.214.1/Identity-Management-Development/WEB/index.php'; // URL del logout
} else if ($app == 'otro') {
    $realm = 'wanttocrack';  // Nombre del realm
    $client_id = 'xampp-web';  // ID del cliente registrado en Keycloak
    $client_secret = 'ContrasenaParaElClientDeKeyCloack';  // Secreto del cliente
    $redirect_uri = 'http://localhost/Identity-Management-Development/WEB/test/callback.php';  // URL de callback
    $redirect_uriLogOut = 'http://localhost/Identity-Management-Development/WEB/test/loginsso.php'; // URL del logout
} else {
    header('Location: ../index.php?errorconfig=-' . $app . '-');
    die();
}
// Dirección IP de Keycloak
$ip = '192.168.214.136:8080'; // Dirección IP y puerto del servidor Keycloak

// URLs de Keycloak
$keycloak_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/auth';
$token_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/token';
$keycloak_logout_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/logout?redirect_uri=' . urlencode($redirect_uriLogOut);
$users_url = 'http://' . $ip . '/admin/realms/' . $realm . '/users';
