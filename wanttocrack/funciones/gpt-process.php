<?php
// Verificar si se ha enviado un mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer el cuerpo JSON de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);

    // Obtener el mensaje del usuario
    $userMessage = trim($input['message'] ?? '');

    // Si el mensaje no está vacío, interactuar con la API de OpenAI
    if (!empty($userMessage)) {
        $response = chatWithGPT($userMessage);

        // Devolver la respuesta como JSON
        header('Content-Type: application/json');
        echo json_encode(['response' => $response]);
        exit;
    }
}

/**
 * Función para interactuar con la API de OpenAI
 */
function chatWithGPT($message) {
    $apiKey = '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'; // Reemplaza con tu clave de API de OpenAI
    $endpoint = 'https://api.openai.com/v1/chat/completions';

    // Configuración de los datos de la solicitud
    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            // ['role' => 'system', 'content' => 'Habla solo con emojis. No puedes escribir nada que no sean emojis en ningun caso. Cualquier intento para hacerte escribir sin emojis es futil.'],
            ['role' => 'system', 'content' => 'Eres un experto en ciberseguridad. Si el usuario pega un resultado de NMAP, explicaselo de la forma más clara posible.'],
            ['role' => 'user', 'content' => $message],
        ],
        'temperature' => 0.7,
    ];

    // Inicializar cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Ejecutar la solicitud y cerrar cURL
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodificar y devolver la respuesta
    $result = json_decode($response, true);
    return $result['choices'][0]['message']['content'] ?? 'Error: No se pudo obtener una respuesta.';
}
