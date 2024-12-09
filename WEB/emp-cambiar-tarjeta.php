<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}

$usuario = $_SESSION['usuario'];
$nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];

$np = "Cambiar tarjeta";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/BBDD.php');
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Activar tarjeta</h1>
    </div>

    <div class="card shadow-lg p-4">
        <!-- Opciones de Tipo de Tarjeta en dos columnas -->
        <div class="row mb-2">
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
        </div>
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