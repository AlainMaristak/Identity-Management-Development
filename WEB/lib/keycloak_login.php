<?php
require __DIR__ . '/vendor/autoload.php';
use Jumbojett\OpenIDConnectClient;

// Configuración de Keycloak
$oidc = new OpenIDConnectClient(
    'http://192.168.52.132:8080/realms/WannaCrack', // URL del Realm de Keycloak
    'WannaCrackWEB', // Client ID de Keycloak
    'PId2ArAPRk8dbd2DhrluH2FfUXzGtsVd' // Client Secret de Keycloak
);

// Establecer la URL de redirección (debe coincidir con la configurada en Keycloak)
$oidc->setRedirectURL('http://10.11.0.124/Identity-Management-Development/WEB/lib/keycloak_login.php');

// Si no hay un código (parámetro `code`), redirige al flujo de autenticación de Keycloak
if (!isset($_GET['code'])) {
    // Si no se ha completado la autenticación, redirige al flujo de inicio de sesión de Keycloak
    $oidc->authenticate();
    exit;
}

// Obtener el token de acceso después de la autenticación
try {
    // Esto solicita el token de acceso usando el código de autorización
    print_r($oidc->getAccessToken());

    // Verificar si el token fue obtenido correctamente
    echo $access_token = $oidc->getAccessToken();
    if (!$access_token) {
        echo "No se pudo obtener el token de acceso.";
        exit;
    }

    // Ahora podemos solicitar los datos del usuario con el token de acceso
    $userInfo = $oidc->requestUserInfo();
    echo "<h1>Información del usuario obtenida de Keycloak:</h1>";
    echo "<pre>";
    print_r($userInfo); // Imprime todos los datos disponibles
    echo "</pre>";
} catch (Exception $e) {
    echo "Error al obtener los datos del usuario: " . $e->getMessage();
}
?>
