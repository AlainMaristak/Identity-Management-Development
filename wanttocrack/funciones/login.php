<?php
include_once("../lib/funciones_globales.php");
include_once("../includes/bbdd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $correo = sanitize_input($_POST['correo'], "email");
    $contrasena = sanitize_input($_POST['contrasena'], "string");

    // Consulta para verificar correo, contraseña y estado activo
    $sql = "SELECT id, tipo, usuario, nombre_empresa FROM usuarios WHERE correo = ? AND contrasena = ? AND activo = '1'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    // Comprobar si la consulta devolvió algún resultado
    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();

        $id = $row['id'];
        $tipo = $row['tipo'];
        $usuario = $row['usuario'];
        $nombre_empresa = $row['nombre_empresa'];

        // Variables de sesión
        $_SESSION['id'] = $id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre_empresa'] = $nombre_empresa;
        $_SESSION['tipo'] = $tipo == '1' ? 'admin' : 'empresa';

        // Preparar y ejecutar actualización de la última conexión
        $ultima_conexion = date('Y-m-d H:i:s');
        $sql = "UPDATE usuarios SET ultima_conexion = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql);
        $stmt_update->bind_param("si", $ultima_conexion, $id);
        $stmt_update->execute();

        // Redirigir según el tipo de usuario
        switch ($tipo) {
            case '1': // Administrador
                header("Location: ../adm-panel.php");
                exit();
                break;
            case '2': // Empresa
                header("Location: ../emp-panel.php");
                exit();
                break;
            default:
                header("Location: ../index.php?login=error");
                exit();
                break;
        }
    } else {
        header("Location: ../index.php?login=incorrecto");
        exit();
    }

    // Cerrar la declaración
    $stmt->close();
    $stmt_update->close();
}

$conn->close();
?>
