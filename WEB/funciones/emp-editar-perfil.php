<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}
include_once '../includes/bbdd.php';

// Comprobar si se enviaron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $usuario = htmlspecialchars($_POST['usuario']);
    $correo = htmlspecialchars($_POST['correo']);
    $nombre_empresa = htmlspecialchars($_POST['nombre_empresa']);
    $CIF = htmlspecialchars($_POST['CIF']);
    $id = $_SESSION['id'];

    $sql = "UPDATE usuarios SET 
            usuario = ?, 
            correo = ?, 
            nombre_empresa = ?, 
            CIF = ? 
            WHERE id = ?";

    // Preparar la sentencia SQL
    if ($stmt = $conn->prepare($sql)) {
        // Vincular los parámetros a la sentencia SQL
        $stmt->bind_param("ssssi", $usuario, $correo, $nombre_empresa, $CIF, $id);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // echo "Usuario actualizado correctamente.";
            $_SESSION['usuario'] = $usuario;
            $_SESSION['nombre_empresa'] = $nombre_empresa;
        } else {
            // echo "Error al actualizar el usuario: " . $stmt->error;
        }

        // Cerrar la sentencia
        $stmt->close();
    } else {
        // echo "Error en la preparación de la consulta: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
}
header("Location: ../emp-perfil.php");
?>
