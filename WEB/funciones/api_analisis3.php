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
        // Si la solicitud es exitosa, procesa el resultado
        $data = json_decode($result, true);

        // Formatea los datos clave para la respuesta
        if (isset($data['data'][$ip])) {
            $deviceData = $data['data'][$ip];
            $response = [
                'ip' => $ip,
                'mac' => $deviceData['addresses']['mac'] ?? 'No disponible',
                'status' => $deviceData['status']['state'] ?? 'No disponible',
                'os_matches' => array_map(function($os) {
                    return [
                        'name' => $os['name'],
                        'accuracy' => $os['accuracy'] . '%',
                    ];
                }, $deviceData['osmatch'] ?? []),
                'open_ports' => array_map(function($port, $details) {
                    return [
                        'port' => $port,
                        'protocol' => $details['name'],
                        'product' => $details['product'] ?? 'No especificado',
                        'version' => $details['version'] ?? 'No especificada',
                    ];
                }, array_keys($deviceData['tcp'] ?? []), $deviceData['tcp'] ?? []),
                'uptime' => $deviceData['uptime']['seconds'] ?? 'No disponible',
            ];
        } else {
            $response = [
                'message' => 'Datos del dispositivo no encontrados.',
            ];
        }
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
