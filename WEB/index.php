<?php

//Limpiando las sesiones
session_start();
session_unset();
session_destroy();

$np = 'Login';
$bodyclass = 'wcBGColor2';
include_once('./includes/head.php');
?>

<div class="container d-flex justify-content-center align-items-center vh-100" style='cursor: zoom-in'>
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-1">Iniciar Sesión en</h3>
        <h4 class="text-center mb-4">Wanna Crack</h4>
        <form method="POST" action="./funciones/login.php">
            <!-- Email input con form-floating -->
            <div class="form-floating mb-4">
                <input type="email" id="formLoginCorreo" class="form-control" placeholder="Correo electrónico" name="correo" required>
                <label for="formLoginCorreo">Correo electrónico</label>
            </div>

            <!-- Password input con form-floating -->
            <div class="form-floating mb-4">
                <input type="password" id="formLoginContrasena" class="form-control" placeholder="Contraseña" name="contrasena" required>
                <label for="formLoginContrasena">Contraseña</label>
            </div>

            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn btn-primary w-100 mb-2 wcBtnColor3">Iniciar sesión</button>
        </form>

        <!-- Divider con línea y texto "OR" en el centro -->
        <div class="d-flex align-items-center my-4">
            <hr class="flex-grow-1">
            <span class="text-center mx-3 text-muted fw-bold">o</span>
            <hr class="flex-grow-1">
        </div>

        <!-- Botón de inicio de sesión con otra opción (ejemplo de red social) -->
        <button type="button" class="btn btn-outline-secondary w-100">Iniciar sesión con SSO</button>

    </div>
</div>

<?php
include_once('./includes/footer.php');
?>