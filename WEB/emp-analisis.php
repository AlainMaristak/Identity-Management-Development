<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}

$usuario = $_SESSION['usuario'];
$nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/navbar.php');
include_once('./includes/BBDD.php');
?>

<!-- Contenido principal -->
<h1>Bienvenido <?php echo $usuario ?></h1>
<!-- <p>texto de ejemplo</p> -->
<h2 class="text-center mb-4">Nuevo Análisis</h2>
<div class="card shadow-lg p-4">
    <form id="ipForm">
        <div class="row">
            <!-- Campo de Dirección IP -->
            <div class="mb-3 col-md-6">
                <label for="ip1" class="form-label">Dirección IP</label>
                <div class="d-flex align-items-center">
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip1" name="ip1" placeholder="0" style="width: 70px;" value='10' required>
                    <span style="margin-bottom: 6px; font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip2" name="ip2" placeholder="0" style="width: 70px;" value='11' required>
                    <span style="margin-bottom: 6px; font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip3" name="ip3" placeholder="0" style="width: 70px;" value='0' required>
                    <span style="margin-bottom: 6px; font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip4" name="ip4" placeholder="X" style="width: 70px;" value='' required>
                </div>
            </div>
            <!-- Botones de Acción -->
            <div class="mb-3 col-md-6 d-flex justify-content-end align-items-center mt-auto">
                <button type="button" class="btn btn-secondary me-2" onclick="resetInputs()">Limpiar</button>
                <button type="submit" class="btn btn-primary">Realizar análisis</button>
            </div>
        </div>
    </form>

    <!-- Barra de Progreso -->
    <div id="progressContainer" class="mt-4" style="display: none;">
        <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuemin="0" aria-valuemax="100">
            <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%;"></div>
        </div>
    </div>

    <!-- Resultado -->
    <div id="result" class="mt-4"></div>
</div>
<?php

function footerjs() {
    echo "<script src='./assets/js/analisis.js'></script>";
}

include_once('./includes/footer.php');
?>