<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') { header("Location: index.php"); exit(); }

$usuario = $_SESSION['usuario'];
$uploadDir = '../tickets/' . $usuario . '/'; // Directorio para guardar los archivos
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf']; // Tipos de archivos permitidos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $tipoTarjeta = $_POST['tipo_tarjeta'] ?? null;
    $importe = $_POST['importe'] ?? null;
    $descripcion = $_POST['descripcion'] ?? null;
    $archivo = $_FILES['archivo'] ?? null;

    // Validar campos obligatorios
    // if (!$tipoTarjeta || !$importe || !$descripcion) {
    //     die('Error: Todos los campos son obligatorios.');
    // }

    if (!is_numeric($importe) || $importe <= 0) {
        die('Error: El importe debe ser un número mayor a 0.');
    }

    if ($archivo && $archivo['error'] === 0) {
        $fileType = mime_content_type($archivo['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            die('Error: Tipo de archivo no permitido.');
        }

        $fileName = uniqid() . '-' . preg_replace('/[^a-zA-Z0-9_\.-]/', '', basename($archivo['name']));
        $filePath = $uploadDir . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if (!move_uploaded_file($archivo['tmp_name'], $filePath)) {
            die('Error: No se pudo subir el archivo.');
        }
    } else {
        $filePath = null;
    }

    include_once('../includes/bbdd.php');

    $id_usuario = $_SESSION['id'];
    $num_tipo_tarjeta = $importe < 500 ? '1' : '2';
    // $num_tipo_tarjeta = $tipoTarjeta === 'debito' ? '1' : ($tipoTarjeta === 'credito' ? '2' : null);
    // if ($num_tipo_tarjeta === null) {
    //     die('Error: Tipo de tarjeta no válido.');
    // }

    $sql = "SELECT usuarios_tarjetas.id FROM `usuarios_tarjetas`
            INNER JOIN tarjetas ON tarjetas.id = usuarios_tarjetas.id_tarjeta
            WHERE tarjetas.tipo = ? AND usuarios_tarjetas.id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $num_tipo_tarjeta);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $id_usuario_tarjeta = $row['id'];
    } else {
        die('Error: No se encontró la tarjeta asociada.');
    }

    $fecha = date('Y-m-d H:i:s');

    $filePath = substr($filePath, 1);
    $stmt = $conn->prepare('INSERT INTO transacciones (id_usuario_tarjeta, fecha, descripcion, importe, ticket) VALUES (?, ?, ?, ?, ?)');
    $stmt->bind_param('issss', $id_usuario_tarjeta, $fecha, $descripcion, $importe, $filePath);

    if ($stmt->execute()) {
        echo 'Datos insertados correctamente.';
    } else {
        echo 'Error al insertar los datos: ' . htmlspecialchars($stmt->error);
    }
    $stmt->close();
    $conn->close();

    echo 'Datos procesados con éxito.';
    if ($filePath) {
        echo ' Archivo guardado en: ' . htmlspecialchars($filePath);
    }
} else {
    die('Método de solicitud no permitido.');
}

header("Location: ../emp-tarjeta-nuevo-gasto.php");
