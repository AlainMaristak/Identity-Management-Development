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
    $url = "http://10.11.0.161:9000/scan_simple?ip=" . urlencode($ip);

    // Realiza la solicitud HTTP
    $result = file_get_contents($url);

    // Decodifica la cadena JSON para trabajar con ella en PHP
    $data = json_decode($result, true); // `true` lo convierte a un array asociativo

    // Verifica si la decodificación fue exitosa
    if ($data === null) {
        http_response_code(500); // Código de error interno del servidor
        echo json_encode(['error' => 'Error al procesar la respuesta de la API']);
        exit;
    }

    // Codifica nuevamente el JSON en un formato limpio y devuelve la respuesta
    header('Content-Type: application/json');

    echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    die();

    if ($result === FALSE) {
        // Si la solicitud falla, muestra un error
        $response = [
            'message' => 'Error al hacer la solicitud de análisis.',
        ];
    } else {
        // Decodifica el resultado JSON
        $data = json_decode($result, true);

        // Verifica si la respuesta tiene datos
        if (isset($data['data']) && is_array($data['data'])) {
            // Obtiene la información de la IP
            $ipData = $data['data'][$ip] ?? null;

            if ($ipData) {
                // Formatea los datos para hacerlos legibles
                $formattedResponse = [
                    'IP' => $ip,
                    'Estado' => $ipData['status']['state'] ?? 'Desconocido',
                    'Razón' => $ipData['status']['reason'] ?? 'Desconocido',
                    'Dirección IPv4' => $ipData['addresses']['ipv4'] ?? 'No disponible',
                    'MAC Address' => $ipData['addresses']['mac'] ?? 'No disponible',
                    'Nombres de Host' => !empty($ipData['hostnames']) ? implode(", ", array_column($ipData['hostnames'], 'name')) : 'No disponible',
                    'Puertos' => []
                ];

                // Procesa los puertos disponibles
                if (isset($ipData['tcp'])) {
                    foreach ($ipData['tcp'] as $port => $portData) {
                        $formattedResponse['Puertos'][] = [
                            'Puerto' => $port,
                            'Nombre' => $portData['name'] ?? 'Desconocido',
                            'Estado' => $portData['state'] ?? 'Desconocido',
                            'Razón' => $portData['reason'] ?? 'Desconocido'
                        ];
                    }
                }

                // Agrega la respuesta final
                $response = [
                    'message' => 'Análisis completado',
                    'data' => $formattedResponse
                ];
            } else {
                $response = [
                    'message' => 'No se encontraron datos para la IP proporcionada.',
                ];
            }
        } else {
            $response = [
                'message' => 'Respuesta de la API no válida o sin datos.',
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
