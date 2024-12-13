<?php
function sanitize_input($data, $type = "string") {
    $data = trim($data); // Eliminar espacios en blanco al inicio y final
    switch ($type) {
        case "email":
            return filter_var($data, FILTER_SANITIZE_EMAIL);
        case "int":
            return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        case "string":
        default:
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}

// // Clave y método de cifrado
// $key = 'g8976234ft58923t49rskibidi8t238974toseghrjfksjdhg'; // Clave secreta (
// $cipherMethod = 'AES-256-CBC'; // Método de cifrado
// $ivLength = openssl_cipher_iv_length($cipherMethod);
// $iv = openssl_random_pseudo_bytes($ivLength);

// /* Función para encriptar un texto */
// function encrypt($plainText, $key, $cipherMethod, $iv) {
//     $encryptedText = openssl_encrypt($plainText, $cipherMethod, $key, 0, $iv);
//     // Guardar el IV junto con el texto cifrado (separados por `::`)
//     return base64_encode($encryptedText . '::' . base64_encode($iv));
// }

// /* Función para desencriptar un texto */
// function decrypt($encryptedText, $key, $cipherMethod) {
//     // Separar el texto cifrado del IV
//     list($cipherText, $iv) = explode('::', base64_decode($encryptedText), 2);
//     $iv = base64_decode($iv);
//     return openssl_decrypt($cipherText, $cipherMethod, $key, 0, $iv);
// }

// // Ejemplo de uso
// $textoOriginal = "Este es un mensaje secreto";
// echo "Texto original: " . $textoOriginal . "\n";

// // Encriptar
// $textoCifrado = encrypt($textoOriginal, $key, $cipherMethod, $iv);
// echo "Texto cifrado: " . $textoCifrado . "\n";

// // Desencriptar
// $textoDescifrado = decrypt($textoCifrado, $key, $cipherMethod);
// echo "Texto descifrado: " . $textoDescifrado . "\n";
?>
