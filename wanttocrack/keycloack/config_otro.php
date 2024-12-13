<?php

// Configuración de Keycloak para la aplicación de tarjetas
$realm = 'Wanttocrack';  // Nombre del realm
$client_id = 'wanttocrack';  // ID del cliente registrado en Keycloak
$client_secret = 'Rt5bfraQA7G0yd0QVYgBZAAwGU1CL8GR';  // Secreto del cliente
$redirect_uri = 'https://10.11.0.21/keycloack/callback_test.php';  // URL de callback
$redirect_uriLogOut = 'https://10.11.0.21/index.php'; // URL del logout

// Dirección IP de Keycloak
$ip = '10.11.0.22:8443'; // Dirección IP y puerto del servidor Keycloak

// URLs de Keycloak
$keycloak_url = 'https://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/auth';
$token_url = 'https://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/token';
$keycloak_logout_url = 'https://' . $ip . '/realms/' . $realm . '/protocol/openid-connect/logout?redirect_uri=' . urlencode($redirect_uriLogOut);
$users_url = 'https://' . $ip . '/admin/realms/' . $realm . '/users';
