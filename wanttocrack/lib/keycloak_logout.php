<?php
session_start();

// URL del endpoint de cierre de sesión de Keycloak
$logoutUrl = 'http://192.168.214.136:8080/realms/wanttocrack/protocol/openid-connect/logout';

// Recuperar el token ID de la sesión (asegúrate de haberlo almacenado previamente)
$idToken = isset($_SESSION['access_token']) ? $_SESSION['access_token'] : null;

// URL a la que redirigir después del logout
$postLogoutRedirectUri = 'http://192.168.214.1/Identity-Management-Development/WEB/';

// Construir la URL de logout
$logoutUrl .= '?post_logout_redirect_uri=' . urlencode($postLogoutRedirectUri);
if ($idToken) {
    $logoutUrl .= '&id_token_hint=' . urlencode($idToken);
}

// Destruir la sesión local
session_destroy();

// Redirigir al usuario al endpoint de logout de Keycloak
header('Location: ' . $logoutUrl);
exit;
