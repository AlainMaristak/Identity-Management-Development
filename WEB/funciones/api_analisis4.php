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
    $url = "http://10.11.0.161:8080/scan_vulns?ip=" . urlencode($ip);

    // Realiza la solicitud HTTP
    $result = file_get_contents($url);

    if ($result === FALSE) {
        // Si la solicitud falla, muestra un error
        $response = [
            'message' => 'Error al hacer la solicitud de análisis.',
        ];
    } else {
        // Decodifica el resultado JSON
        $data = json_decode($result, true);

        // Si hay datos para la IP, procesa y organiza la información
        if (isset($data['data'][$ip])) {
            $ipData = $data['data'][$ip];
            $response = [
                'message' => 'Análisis completado',
                'data' => [
                    'IP' => $ip,
                    'Estado' => $ipData['status']['state'],
                    'Razón' => $ipData['status']['reason'],
                    'Dirección IPv4' => $ipData['addresses']['ipv4'],
                    'MAC Address' => $ipData['addresses']['mac'],
                    'Sistemas Operativos' => array_map(function ($os) {
                        return $os['name'] . ' (' . $os['accuracy'] . '% de precisión)';
                    }, $ipData['osmatch']),
                    'Puertos' => array_map(function ($port) {
                        return [
                            'Puerto' => $port['portid'],
                            'Protocolo' => $port['proto'],
                            'Estado' => $port['state'],
                            'CPE' => $port['cpe'],
                            'Producto' => $port['product'],
                            'Versión' => $port['version'],
                        ];
                    }, $ipData['tcp']),
                    'Uptime' => $ipData['uptime']['lastboot'] . ' (' . $ipData['uptime']['seconds'] . ' segundos)',
                ],
            ];
        } else {
            $response = [
                'message' => 'No se encontraron datos para la IP proporcionada.',
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
