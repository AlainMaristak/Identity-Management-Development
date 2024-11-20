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
        <div class="row g-3">
            <!-- Campo de Dirección IP -->
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <label for="ip1" class="form-label">Dirección IP</label>
                <div class="d-flex flex-wrap align-items-center">
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip1" name="ip1" placeholder="0" style="width: 70px;" value="10" required>
                    <span class="mx-1" style="font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip2" name="ip2" placeholder="0" style="width: 70px;" value="11" required>
                    <span class="mx-1" style="font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip3" name="ip3" placeholder="0" style="width: 70px;" value="0" required>
                    <span class="mx-1" style="font-size: 1.5rem;">.</span>
                    <input class="form-control text-center mx-1" type="text" maxlength="3" id="ip4" name="ip4" placeholder="X" style="width: 70px;" value="" required>
                </div>
            </div>

            <!-- Modo de escaneo -->
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <label for="modo_escaneo_simple" class="form-label">Modo de escaneo</label>
                <div class="btn-group w-100" role="group" aria-label="Tipo de scaneo" id="modo_escaneo">
                    <input type="radio" class="btn-check" name="modo_escaneo" id="modo_escaneo_simple" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="modo_escaneo_simple">Simple</label>

                    <input type="radio" class="btn-check" name="modo_escaneo" id="modo_escaneo_completo" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modo_escaneo_completo">Completo</label>

                    <input type="radio" class="btn-check" name="modo_escaneo" id="modo_escaneo_vulnerabilidades" autocomplete="off">
                    <label class="btn btn-outline-primary" for="modo_escaneo_vulnerabilidades">Vulnerabilidades</label>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="col-12 col-lg-4 d-flex justify-content-lg-end align-items-center mt-auto mb-3">
                <button type="submit" class="btn btn-primary w-100 w-lg-auto">Realizar análisis</button>
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
    echo "
    <script src='./assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    <script src='./assets/js/main.js'></script>
    <script src='./assets/js/analisis.js'></script>";
}

include_once('./includes/footer.php');
?>