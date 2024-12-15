<?php

session_start();
if (empty($_SESSION['usuario']) || $_SESSION['tipo'] != 'admin') {
    header("Location: index.php?lista-usuarios");
    die();
}

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/bbdd.php');

$endpoint = '/funciones/adm-obtener-lista-usuarios.php';
$jsonData = file_get_contents($endpoint);
$usuarios = json_decode($jsonData, true); 
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Usuarios</h1>
  </div>

  <h2>Lista de usuarios</h2>

  <!-- Tabla de usuarios -->
  <div class="table-responsive">
    <table class="table table-striped table-bordered">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Nombre de Usuario</th>
          <th>Nombre</th>
          <th>Apellido</th>
          <th>Email</th>
          <th>Habilitado</th>
          <th>DN en LDAP</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($usuarios)) { ?>
          <?php foreach ($usuarios as $usuario) { ?>
            <tr>
              <td><?= htmlspecialchars($usuario['id']); ?></td>
              <td><?= htmlspecialchars($usuario['username']); ?></td>
              <td><?= htmlspecialchars($usuario['firstName'] ?? ''); ?></td>
              <td><?= htmlspecialchars($usuario['lastName'] ?? ''); ?></td>
              <td><?= htmlspecialchars($usuario['email'] ?? 'No especificado'); ?></td>
              <td><?= $usuario['enabled'] ? 'Sí' : 'No'; ?></td>
              <td><?= htmlspecialchars($usuario['attributes']['LDAP_ENTRY_DN'][0] ?? ''); ?></td>
            </tr>
          <?php } ?>
        <?php } else { ?>
          <tr>
            <td colspan="7" class="text-center">No se encontraron usuarios.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</main>
<!-- FIN CONTENIDO -->

<?php
// FOOTER
function footerjs()
{
  echo "";
}
include_once('./includes/footer.php');
?>