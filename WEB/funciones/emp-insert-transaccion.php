<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') { header("Location: index.php"); die(); }

$nombre_empresa = $_SESSION['nombre_empresa'];

$uploadDir = '../tickets/' . $nombre_empresa; // Directorio para guardar los archivos
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf']; // Tipos de archivos permitidos

// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $tipoTarjeta = $_POST['tipo_tarjeta'] ?? null;
    $importe = $_POST['importe'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $archivo = $_FILES['archivo'] ?? null;

    // Validar campos obligatorios
    if (!$tipoTarjeta || !$importe || !$descripcion) {
        die('Error: Todos los campos son obligatorios.'); //////////////////////////////////////
    }

    // Validar tipo de archivo si se subió uno
    if ($archivo && $archivo['error'] === 0) {
        $fileType = mime_content_type($archivo['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            die('Error: Tipo de archivo no permitido.'); //////////////////////////////////////
        }

        // Generar un nombre único para el archivo y moverlo al directorio de subida
        $fileName = uniqid() . '-' . basename($archivo['name']);
        $filePath = $uploadDir . $fileName;

        // Crear el directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!move_uploaded_file($archivo['tmp_name'], $filePath)) {
            die('Error: No se pudo subir el archivo.'); //////////////////////////////////////
        }
    } else {
        $filePath = null; // No se subió archivo
    }

    include_once('../includes/bbdd.php');

    $stmt = $conn->prepare('INSERT INTO transacciones (tipo_tarjeta, importe, descripcion, archivo) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sdss', $tipoTarjeta, $importe, $descripcion, $filePath);
    if ($stmt->execute()) {
        echo 'Datos insertados correctamente.';
    } else {
        echo 'Error al insertar los datos: ' . $stmt->error;
    }
    $stmt->close();
    $conexion->close();

    // Respuesta de éxito
    echo 'Datos procesados con éxito.';
    if ($filePath) {
        echo ' Archivo guardado en: ' . htmlspecialchars($filePath);
    }
} else {
    die('Método de solicitud no permitido.');
}
