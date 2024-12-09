<?php
// Configuración de Keycloak
$realm = 'WannaCrack';  // Nombre del realm
$client_id = 'WannaCrackWEB';  // ID del cliente registrado en Keycloak
$client_secret = 'PId2ArAPRk8dbd2DhrluH2FfUXzGtsVd';  // Secreto del cliente
$redirect_uri = 'http://localhost/Identity-Management-Development/WEB/test/callback.php';  // URL de callback
$redirect_uriLogOut = 'http://localhost/Identity-Management-Development/WEB/test/loginsso.php'; // URL del logout
 
// Dirección IP de Keycloak
$ip = '192.168.52.132:8080'; // Dirección IP y puerto del servidor Keycloak
 
// URLs de Keycloak
$keycloak_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/auth';
$token_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/token';
$keycloak_logout_url = 'http://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/logout?redirect_uri=' . urlencode($redirect_uriLogOut);
$users_url = 'http://' . $ip . '/admin/realms/' . $realm . '/users';