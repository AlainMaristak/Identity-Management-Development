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
        <div class="modal-body">
          <!-- Opciones de Tipo de Tarjeta en dos columnas -->
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="form-check card-option">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary me-auto" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
      </form>
</div>


<!-- NO ↓↓ -->



<div class="card shadow-lg p-4">
    <form action="./funciones/emp-nuevo-gasto.php" method="POST" enctype="multipart/form-data">
        <!-- Opciones de Tipo de Tarjeta en dos columnas -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label class="form-check card-option d-flex align-items-center p-3 border rounded shadow-sm" for="debito">
                    <input class="form-check-input d-none" type="radio" name="tipo_tarjeta" id="debito" value="debito" required>
                    <div>
                        <h6 class="mb-0">Débito</h6>
                        <p class="text-muted mb-0">1234-5678-9012-3456</p>
                    </div>
                </label>
            </div>
            <div class="col-md-6">
                <label class="form-check card-option d-flex align-items-center p-3 border rounded shadow-sm" for="credito">
                    <input class="form-check-input d-none" type="radio" name="tipo_tarjeta" id="credito" value="credito" required>
                    <div>
                        <h6 class="mb-0">Crédito</h6>
                        <p class="text-muted mb-0">6543-2109-8765-4321</p>
                    </div>
                </label>
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

        <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </div>
    </form>
</div>

<style>
    .card-option {
        transition: border-color 0.3s, background-color 0.3s;
        cursor: pointer;
    }
    .card-option:hover {
        border-color: #0d6efd;
    }
    .card-option input:checked + div {
        border-color: #28a745 !important; /* Verde */
        background-color: #d4edda; /* Verde claro */
    }
</style>


<?php
include_once('./includes/footer.php');
?>