<?php
session_start();

include_once('./config_tarjetas.php');
 
// Verificar si el código de autenticación está presente en la URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];
 
    // Preparar los datos para el POST
    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,   // Debe coincidir con la URL registrada en Keycloak
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];
 
    // Iniciar la solicitud cURL para obtener el token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
    // TEMPORALMENTE (no usar en producción si el certificado no es válido)
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    // Opcional: activar el modo verbose para depurar
    // curl_setopt($ch, CURLOPT_VERBOSE, true);
   
    $response = curl_exec($ch);
 
    if ($response === false) {
        echo 'Error cURL: ' . curl_error($ch);
        curl_close($ch);
        exit;
    }
 
    curl_close($ch);
 
    // Convertir la respuesta a JSON
    $response_data = json_decode($response, true);
 
    // Verificar si se obtuvo un token
    if (isset($response_data['access_token'])) {
        $_SESSION['access_token'] = $response_data['access_token'];
        $_SESSION['refresh_token'] = $response_data['refresh_token'];
 
        // Obtener el token de acceso
        $access_token = $_SESSION['access_token'];
 
        // Dividir el JWT en sus partes
        $token_parts = explode('.', $access_token);
        if (count($token_parts) === 3) {
            list($header, $payload, $signature) = $token_parts;
 
            // Decodificar las partes Base64
            $decoded_header = json_decode(base64_decode($header), true);
            $decoded_payload = json_decode(base64_decode($payload), true);
 
            // Obtener campos del payload
            echo $username = isset($decoded_payload['preferred_username']) ? $decoded_payload['preferred_username'] : 'No disponible';
            echo $roles = isset($decoded_payload['realm_access']['roles']) ? $decoded_payload['realm_access']['roles'] : [];
            echo $givenName = isset($decoded_payload['given_name']) ? $decoded_payload['given_name'] : 'No disponible';
            echo $familyName = isset($decoded_payload['family_name']) ? $decoded_payload['family_name'] : 'No disponible';
            echo $email = isset($decoded_payload['email']) ? $decoded_payload['email'] : 'No disponible';
            echo $auth_time = isset($decoded_payload['auth_time']) ? $decoded_payload['auth_time'] : null;
 
            echo $posicion = isset($decoded_payload['LDAP-posicion']) ? $decoded_payload['LDAP-posicion'] : 'Posicion no disponible3';


            $inicioSesionHora = 'No disponible';
            if ($auth_time !== null) {
                $fecha = new DateTime('@' . $auth_time);
                $fecha->setTimezone(new DateTimeZone('Europe/Madrid'));
                $inicioSesionHora = $fecha->format('Y-m-d H:i:s');
            }
 
            // Determinar el rol
            $role = 'Empresa';
            if (in_array('Admin', $roles)) {
                $role = 'Admin';
            }
 
            // Guardamos en sesión
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            $_SESSION["email"] = $email;
            $_SESSION["given_name"] = $givenName;
            $_SESSION["family_name"] = $familyName;
            $_SESSION["auth_time"] = $inicioSesionHora;

	        $_SESSION['id'] = '1';
	        $_SESSION['tipo'] = 'empresa';
	        $_SESSION['usuario'] = $username;
	        $_SESSION['nombre_empresa'] = 'Wanna Crack';
            
            // Redirigir a la página de login
            die();
            header('Location: ../emp-panel.php');
            exit;
        } else {
            echo '<h3>Error:</h3>';
            echo 'El token JWT no tiene el formato esperado.';
        }
    } else {
        echo '<h3>Error al obtener el token:</h3>';
        echo '<pre>' . htmlspecialchars($response) . '</pre>';
    }
} else {
    echo '<h3>Error:</h3>';
    echo 'No se recibió el código de autenticación.';
}
