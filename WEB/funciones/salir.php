<?php
session_start();
require_once '../test/config.php';
session_unset();
session_destroy();
header('Location: ' . $keycloak_logout_url);
die();
?>
