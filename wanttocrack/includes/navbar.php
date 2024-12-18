<!-- BARRA DE NAVEGACIÓN LATERAL-->
<div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
  <div class="offcanvas-md offcanvas-start bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="sidebarMenuLabel">WannaCrack | <?php echo $usuario ?></h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
      <ul class="nav flex-column">
        <?php
        if ($tipo == 'empresa') {
        ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="./emp-panel.php">
              <i class="bi bi-house-fill"></i>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./emp-historial-transacciones.php">
              <i class="bi bi-clock-history"></i>
              Historial de transacciones
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./emp-tarjeta-nuevo-gasto.php">
              <i class="bi bi-file-earmark-plus"></i>
              Nuevo gasto
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./emp-cambiar-tarjeta.php">
              <i class="bi bi-wallet2"></i>
              Activar tarjeta
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./emp-perfil.php">
              <i class="bi bi-person-circle"></i>
              Perfil
            </a>
          </li>
        <?php
        } else if ($tipo == 'admin') { ?>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="./adm-panel.php">
              <i class="bi bi-house-fill"></i>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./adm-lista-usuarios.php">
              <i class="bi bi-people"></i>
              Usuarios
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./adm-historial-transacciones.php">
              <i class="bi bi-clock-history"></i>
              Transacciones
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link d-flex align-items-center gap-2" href="./adm-analisis.php">
              <i class="bi bi-search"></i>
              Análisis
            </a>
          </li>
          
        <?php } ?>

      </ul>
      <hr class="my-3">

      <ul class="nav flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center gap-2" href="./funciones/salir_tarjetas.php">
            <i class="bi bi-door-closed"></i>
            Cerrar sesión
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- FIN BARRA DE NAVEGACIÓN LATERAL-->