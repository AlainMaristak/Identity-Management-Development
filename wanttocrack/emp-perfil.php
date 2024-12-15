<?php
session_start();
if (empty($_SESSION['usuario']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}

$usuario = $_SESSION['usuario'];
$nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];

$np = "Inicio";
$bodyclass = '';
//includes
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/BBDD.php');
?>



<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Perfil</h1>
    </div>
    <!-- <h2 class="text-center mb-4">Datos del perfil</h2> -->
    <?php
    // Consulta SQL para obtener los datos de un único usuario con id = 1
    $sql = "SELECT id, tipo, usuario, correo, contrasena, nombre_empresa, CIF, ultima_conexion, fecha_registro, activo FROM usuarios WHERE id = 1";

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener los datos del usuario
        $row = $result->fetch_assoc();

        echo '
<div class="container mt-5">
    <div class="row">
        <!-- Primer div -->
        <div class="col-md-6">
            <div class="card h-100 shadow-lg">
                <div class="card-body p-3 mb-3">
                    <!-- Botón de Editar Perfil (arriba a la derecha) -->
                    <div class="row">
                        <div class="col-xl-8">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Usuario:</strong> &nbsp;' . htmlspecialchars($row['usuario']) . '</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Correo:</strong> &nbsp;' . htmlspecialchars($row['correo']) . '</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Nombre Empresa:</strong> &nbsp;' . htmlspecialchars($row['nombre_empresa']) . '</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">CIF:</strong> &nbsp;' . htmlspecialchars($row['CIF']) . '</li>
                            </ul>
                        </div>
                        <div class="col-xl-4">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    Editar perfil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segundo div -->
        <div class="col-md-6">
            <div class="card h-100 shadow-lg">
                <div class="card-body p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Última Conexión:</strong> &nbsp;' . htmlspecialchars($row['ultima_conexion']) . '</li>
                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Fecha de Registro:</strong> &nbsp;' . htmlspecialchars($row['fecha_registro']) . '</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
    <div class="row">
        <div class="col-12"><h5 class="modal-title" id="staticBackdropLabel">Editar Datos de Usuario</h5></div>
        <div class="col-12"><small class="text-muted">Los cambios realizados en el perfil solo se aplicarán en esta aplicación web, no afectarán a tu usuario LDAP.</small></div>
    </div>  
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="./funciones/emp-editar-perfil.php" method="POST">
        <div class="modal-body">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" value="' . htmlspecialchars($row['usuario']) . '" required>
            </div>

            <div class="mb-3">
                <label for="correo" class="form-label">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" value="' . htmlspecialchars($row['correo']) . '" required>
            </div>

            <div class="mb-3">
                <label for="nombre_empresa" class="form-label">Nombre de Empresa</label>
                <input type="text" class="form-control" id="nombre_empresa" name="nombre_empresa" value="' . htmlspecialchars($row['nombre_empresa']) . '" required>
            </div>

            <div class="mb-3">
                <label for="CIF" class="form-label">CIF</label>
                <input type="text" class="form-control" id="CIF" name="CIF" value="' . htmlspecialchars($row['CIF']) . '" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>

      </form>
    </div>
  </div>
</div>';
    } else {
        // Mensaje si no se encuentra el usuario
        echo '<div class="alert alert-warning text-center" role="alert">No se encontró el usuario con ID = 1.</div>';
    }

    // Liberar los resultados
    $result->free();
    ?>

</main>
<!-- FIN CONTENIDO -->

<?php

function footerjs()
{
    echo "";
}
include_once('./includes/footer.php');
?>