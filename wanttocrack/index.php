<?php
//Limpiando las sesiones
session_start();
session_unset();
session_destroy();

$np = 'Login';
$bodyclass = '';
include_once('./includes/head.php');
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow w-100" style="max-width: 800px; height: auto;">
        <h3 class="text-center mb-4">Iniciar Sesión en WannaCrack</h3>
        <div class="row">
            <div class="col-md-6 d-flex">
                <!-- Botón 1 -->
                <button
                    class="btn btn-primary d-flex align-items-center justify-content-between p-3 rounded shadow-sm w-100"
                    onclick="window.location.href='./keycloack2/loginsso.php?app=tarjetas';"
                    style="font-size: 1.2rem;">
                    <span>APLICACIÓN DE GESTIÓN DE TARJETAS Y TRANSACCIONES</span>
                    <i class="bi bi-arrow-right-circle-fill fs-3"></i>
                </button>
            </div>
            <div class="col-md-6 d-flex">
                <!-- Botón 2 -->
                <button
                    class="btn btn-secondary d-flex align-items-center justify-content-between p-3 rounded shadow-sm w-100"
                    onclick="window.location.href='./keycloack2/loginsso.php?app=otro';"
                    style="font-size: 1.2rem;">
                    <span>OTRA COSA</span>
                    <i class="bi bi-arrow-right-circle-fill fs-3"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<?php

function footerjs()
{
    echo "
        <script src='./assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    ";
}
include_once('./includes/footer.php');
?>
