<?php
session_start();
$aplicacion = "logginSSO";
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

require_once 'config_tarjetas.php';

$auth_url = $keycloak_url . '?response_type=code&client_id=' . $client_id . '&redirect_uri=' . urlencode($redirect_uri);

if (!isset($_SESSION['access_token'])) {
    header('Location: ' . $auth_url);
    exit;
}

// Si ya existe el token, puedes redirigir al dashboard u otra página
header('Location: ../emp-panel.php');
exit;
 
