<?php
//Limpiando las sesiones
session_start();
session_unset();
session_destroy();

$np = 'Login';
$bodyclass = 'wcBGColor2 WCRaton';
include_once('./includes/head.php');
?>


<div class="container d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card p-4 shadow w-100" style="max-width: 600px; height: 300px;">
        <h3 class="text-center mb-4">Iniciar Sesión en WannaCrack</h3>
        <div class="row h-100">
            <div class="col-6 d-flex">
                <div class="card-option d-flex justify-content-center align-items-center flex-fill text-center bg-info rounded" 
                     role="button" onclick="window.location.href='./test/loginsso.php?app=tarjetas';">
                    <span>APLICACIÓN DE GESTIÓN DE TARJETAS Y TRANSACCIONES</span>
                </div>
            </div>
            <div class="col-6 d-flex">
                <div class="card-option d-flex justify-content-center align-items-center flex-fill text-center bg-info rounded" 
                     role="button" onclick="window.location.href='./test/loginsso.php?app=otro';">
                    <span>OTRA COSA</span>
                </div>
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