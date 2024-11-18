<div class="d-flex">
  <!-- Sidebar -->
  <div id="sidebar" class="bg-dark text-white p-3">
    <h3 class="mb-4">Wanna Crack</h3>
    <ul class="nav flex-column">
      <?php if ($tipo == 'admin') { //Navbar Administrador ?> 
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-house"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-person-circle"></i> Perfil</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-wallet2"></i> Configuración</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-search"></i> Análisis</a>
        </li>
        <li class="nav-item">
          <a href="./funciones/salir.php" class="nav-link text-white"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </li>
      <?php } else if ($tipo == 'empresa') { //Navbar Empresa ?>
        <li class="nav-item">
          <a href="./emp-panel.php" class="nav-link text-white"><i class="bi bi-house"></i> Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="./emp-perfil.php" class="nav-link text-white"><i class="bi bi-person-circle"></i> Perfil</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-wallet2"></i> Configuración</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link text-white"><i class="bi bi-search"></i> Análisis</a>
        </li>
        <li class="nav-item">
          <a href="./funciones/salir.php" class="nav-link text-white"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </li>
      <?php } ?>

    </ul>
  </div>

  <!-- Botón de tirador -->
  <button id="toggle-sidebar" class="btn d-lg-none">
    <span id="toggle-icon" class="lni lni-chevron-left"></span>
  </button>

  <!-- Contenido Principal -->
  <div id="main-content" class="flex-grow-1 p-4">