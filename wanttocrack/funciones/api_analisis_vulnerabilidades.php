<?php
$inputData = json_decode(file_get_contents('php://input'), true);

if (isset($inputData['ip'])) {
    $ip = $inputData['ip'];

    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        $response = ['message' => 'Dirección IP no válida.'];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    // Crea un contexto para la solicitud con un tiempo de espera de 300 segundos (5 minutos)
    $context = stream_context_create([
        'http' => [
            'timeout' => 600  // 600 segundos (10 minutos)
        ]
    ]);

    // Realiza la solicitud con el contexto personalizado
    $url = "http://10.11.0.161:9000/scan_vulns?ip=" . urlencode($ip);
    $result = @file_get_contents($url, false, $context);

    // Verifica si la solicitud fue exitosa
    if ($result === FALSE) {
        http_response_code(500); // Código de error interno del servidor
        echo json_encode(['error' => 'Error al realizar la solicitud a la API']);
        exit;
    }

    // Decodifica la cadena JSON para trabajar con ella en PHP
    $data = json_decode($result, true); // `true` lo convierte a un array asociativo

    // Verifica si la decodificación fue exitosa
    if ($data === null) {
        http_response_code(500); // Código de error interno del servidor
        echo json_encode(['error' => 'Error al procesar la respuesta de la API']);
        exit;
    }

    // Responde con los datos de la API
    header('Content-Type: application/json');
    echo json_encode($data);
}
die();
?>


<!-- 

if ($result === FALSE) {
$response = ['message' => 'Error al hacer la solicitud de análisis.'];
} else {
$data = json_decode($result, true);
header('Content-Type: application/json');
echo json_encode($data);
die();

if (isset($data['data'][$ip])) {
$ipData = $data['data'][$ip];
$formattedResponse = [
'IP' => $ip,
'Estado' => $ipData['status']['state'] ?? 'Desconocido',
'Razón' => $ipData['status']['reason'] ?? 'Desconocido',
'Dirección IPv4' => $ipData['addresses']['ipv4'] ?? 'No disponible',
'MAC Address' => $ipData['addresses']['mac'] ?? 'No disponible',
'Nombres de Host' => !empty($ipData['hostnames']) ? implode(", ", array_column($ipData['hostnames'], 'name')) : 'No disponible',
'Puertos' => [],
];

if (isset($ipData['tcp'])) {
foreach ($ipData['tcp'] as $port => $portData) {
$portInfo = [
'Puerto' => $port,
'Nombre' => $portData['name'] ?? 'Desconocido',
'Estado' => $portData['state'] ?? 'Desconocido',
'Razón' => $portData['reason'] ?? 'Desconocido',
'Vulnerabilidades' => []
];

// Extraer las vulnerabilidades de los scripts
if (isset($portData['script']) && is_array($portData['script'])) {
foreach ($portData['script'] as $scriptName => $scriptResult) {
$portInfo['Vulnerabilidades'][] = [
'Script' => $scriptName,
'Resultado' => $scriptResult
];
}
}

$formattedResponse['Puertos'][] = $portInfo;
}
}

$response = ['message' => 'Análisis completado', 'data' => $formattedResponse];
} else {
$response = ['message' => 'No se encontraron datos para la IP proporcionada.'];
}
}
} else {
$response = ['message' => 'IP no proporcionada.'];
}

header('Content-Type: application/json');
echo json_encode($response);
?> -->