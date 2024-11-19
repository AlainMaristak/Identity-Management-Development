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
<h2 class="text-center mb-4">Nueva transacción</h2>

<div class="card shadow-lg p-4">
  <form action="./funciones/emp-nuevo-gasto.php" method="POST" enctype="multipart/form-data">
    <!-- Opciones de Tipo de Tarjeta en dos columnas -->
    <div class="row mb-4">
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
        <div class="form-check card-option">
          <input class="form-check-input" type="radio" name="tipo_tarjeta" id="credito" value="credito" required>
          <label class="form-check-label" for="credito">
            Crédito
            <p>6543-2109-8765-4321</p>
          </label>
        </div>
      </div>
    </div>

    <!-- Campo de Descripción -->
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Escribe una descripción" required></textarea>
    </div>

    <!-- Campo de Subida de Archivo -->
    <div class="mb-3">
      <label for="archivo" class="form-label">Subir archivo (Solo imágenes)</label>
      <input class="form-control" type="file" id="archivo" name="archivo" accept="image/*" required>
    </div>
    <div>
      <button type="submit" class="btn btn-primary me-auto">Guardar Cambios</button>
    </div>
  </form>
</div>

<?php
function footerjs() { echo ""; }
include_once('./includes/footer.php');
?>