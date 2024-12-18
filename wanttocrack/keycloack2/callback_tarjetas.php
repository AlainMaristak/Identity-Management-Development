<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once('./config_tarjetas.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $data = [
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $redirect_uri,
        'client_id' => $client_id,
        'client_secret' => $client_secret
    ];

    // Iniciar la solicitud cURL para obtener el token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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
            $usernameweb = isset($decoded_payload['preferred_username']) ? $decoded_payload['preferred_username'] : 'No disponible';
            $roles = isset($decoded_payload['realm_access']['roles']) ? $decoded_payload['realm_access']['roles'] : [];
            $givenName = isset($decoded_payload['given_name']) ? $decoded_payload['given_name'] : 'No disponible';
            $familyName = isset($decoded_payload['family_name']) ? $decoded_payload['family_name'] : 'No disponible';
            $email = isset($decoded_payload['email']) ? $decoded_payload['email'] : 'No disponible';
            $auth_time = isset($decoded_payload['auth_time']) ? $decoded_payload['auth_time'] : null;

            $userId = isset($decoded_payload['sub']) ? $decoded_payload['sub'] : 'ID no disponible';

            include_once('../includes/bbdd.php');
            // Consulta para verificar si el usuario existe
            $sql = "SELECT * FROM usuarios WHERE id_ldap = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $userId); // Vincula el parámetro de forma segura
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Si se encuentra el usuario, obtener su ID
                $user = $result->fetch_assoc();
                $userIdDb = $user['id']; // ID del usuario en la base de datos

                // Actualizar la fecha y hora de la última conexión
                $update_sql = "UPDATE usuarios SET ultima_conexion = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);

                // Fecha y hora actuales
                $ultimaConexion = date('Y-m-d H:i:s');
                $update_stmt->bind_param("si", $ultimaConexion, $userIdDb); // `si` indica que se envían una cadena y un entero

                if ($update_stmt->execute()) {
                    echo "Última conexión actualizada correctamente.";
                } else {
                    echo "Error al actualizar última conexión: " . $update_stmt->error;
                }

                $update_stmt->close();
            } else {
                // Datos del nuevo usuario obtenidos previamente
                $ultimaConexion = date('Y-m-d H:i:s');

                // Consulta para insertar el nuevo usuario
                $insert_sql = "INSERT INTO usuarios (id_ldap, usuario, correo, tipo, nombre_empresa, CIF, ultima_conexion, fecha_registro) VALUES (?, ?, ?, 2, 'WannaCrack', '0', '$ultimaConexion', '$ultimaConexion')";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("sss", $userId, $usernameweb, $email);

                if ($insert_stmt->execute()) {
                    // Obtener el ID generado automáticamente
                    $userIdDb = $conn->insert_id;
                    echo "Usuario insertado correctamente. ID asignado: " . $userIdDb;
                } else {
                    echo "Error al insertar usuario: " . $insert_stmt->error;
                }

                $insert_stmt->close();
            }

            // Cierra los recursos
            $stmt->close();
            $conn->close();

            $inicioSesionHora = 'No disponible';
            if ($auth_time !== null) {
                $fecha = new DateTime('@' . $auth_time);
                $fecha->setTimezone(new DateTimeZone('Europe/Madrid'));
                $inicioSesionHora = $fecha->format('Y-m-d H:i:s');
            }

            // Determinar el rol
            $role = 'empresa';
            if (in_array('Admin', $roles)) {
                $role = 'admin';
            }

            // Guardamos en sesión
            $_SESSION["username"] = $usernameweb;
            $_SESSION["email"] = $email;
            $_SESSION["auth_time"] = $inicioSesionHora;
            $_SESSION['usuario'] = $usernameweb;
            // $_SESSION['nombre_empresa'] = 'Wanna Crack';

            $_SESSION['id'] = $userIdDb;
            $_SESSION["tipo"] = $role;

            if ($role == 'admin') {
                header('Location: ../adm-panel.php');
                exit;
            } else if ($role == 'empresa') {
                header('Location: ../emp-panel.php');
                exit;
            }
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
