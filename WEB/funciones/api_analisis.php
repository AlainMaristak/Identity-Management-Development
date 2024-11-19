<?php

// Lee los datos JSON del cuerpo de la solicitud
$inputData = json_decode(file_get_contents('php://input'), true);

// Verifica si se ha recibido la IP
if (isset($inputData['ip'])) {
    // Obtiene la IP desde el JSON recibido
    $ip = $inputData['ip'];

    // Valida que la IP sea válida
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        // Si la IP no es válida, devuelve un error
        $response = [
            'message' => 'Dirección IP no válida.',
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Construye la URL de la solicitud externa
    $url = "http://10.11.0.161:8080/scan_completo?ip=" . urlencode($ip);

    // Realiza la solicitud HTTP
    $result = file_get_contents($url);

    if ($result === FALSE) {
        // Si la solicitud falla, muestra un error
        $response = [
            'message' => 'Error al hacer la solicitud de análisis.',
        ];
    } else {
        // Si la solicitud es exitosa, devuelve el resultado
        $response = [
            // 'message' => 'Esta es la respuesta de la API: ' . $result,
            'message' => $result,
        ];
    }
} else {
    // Si no se recibe la IP, muestra un mensaje de error
    $response = [
        'message' => 'IP no proporcionada.',
    ];
}

// Establece el encabezado para indicar que la respuesta es JSON
header('Content-Type: application/json');

// Envía la respuesta como JSON
echo json_encode($response);
?>
