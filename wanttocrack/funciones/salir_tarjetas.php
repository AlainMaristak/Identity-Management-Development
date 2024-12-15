<?php
session_start();
require_once '../keycloack2/config_tarjetas.php';
// session_unset();
// session_destroy();
header('Location: ' . $keycloak_logout_url);
die();
?>
