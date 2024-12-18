<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
if (empty($_SESSION['usuario']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}

$usuario = $_SESSION['usuario'];
// $nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/bbdd.php');
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Nueva transaccion</h1>
    </div>

    <div class="card shadow-lg p-4">
        <form action="./funciones/emp-insert-transaccion.php" method="POST" enctype="multipart/form-data">
            <!-- Opciones de Tipo de Tarjeta en dos columnas -->
            <!-- <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-check card-option" style="padding-left: 0;">
                        <input class="form-check-input" type="radio" name="tipo_tarjeta" id="debito" value="debito" required>
                        <label class="form-check-label" for="debito">
                            Débito
                            <p>1234-5678-9012-3456</p>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-check card-option ps-0">
                        <input class="form-check-input" type="radio" name="tipo_tarjeta" id="credito" value="credito" required>
                        <label class="form-check-label" for="credito">
                            Crédito
                            <p>6543-2109-8765-4321</p>
                        </label>
                    </div>
                </div>
            </div> -->

            <!-- Campo de Importe -->
            <div class="mb-3">
                <label for="importe" class="form-label">Importe</label>
                <input type="number" class="form-control" id="importe" name="importe" placeholder="Introduce el importe" step="0.01" required>
            </div>

            <!-- Campo de Descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Escribe una descripción" required></textarea>
            </div>

            <!-- Campo de Subida de Archivo -->
            <div class="mb-3">
                <label for="archivo" class="form-label">Subir archivo</label>
                <input class="form-control" type="file" id="archivo" name="archivo" accept="image/*,application/pdf">
            </div>

            <div>
                <button type="submit" class="btn btn-primary me-auto">Guardar Cambios</button>
            </div>
        </form>

    </div>

</main>
<!-- FIN CONTENIDO -->

<?php
function footerjs()
{
    echo "";
}
include_once('./includes/footer.php');
?>