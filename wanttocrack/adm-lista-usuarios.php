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

// Incluir el archivo que obtiene la lista de usuarios
include_once('./funciones/adm-obtener-lista-usuarios.php');

// Se espera que $usuarios esté disponible después del include
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Usuarios</h1>
  </div>

  <h2>Lista de usuarios</h2>

  <!-- Mostrar errores si los hay -->
  <?php if (!empty($error)) { ?>
    <div class="alert alert-danger">
      <?= htmlspecialchars($error); ?>
    </div>
  <?php } ?>

  <!-- Contenedor para Grid.js -->
  <div id="grid-container"></div>
</main>

<!-- Scripts necesarios -->
<script src="https://unpkg.com/gridjs/dist/gridjs.umd.js"></script>
<link href="https://unpkg.com/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Datos de usuarios pasados desde PHP a JavaScript
    const usuarios = <?php echo json_encode($usuarios, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;

    // Función para actualizar el estado de un usuario
    const toggleUserStatus = (userId, currentStatus) => {
      // Determinar el nuevo estado (invertir el actual)
      const newStatus = !currentStatus;
      
      fetch(`./funciones/adm-modificar-disponibilidad.php?id=${userId}&enabled=${newStatus}`, {
        method: 'GET',
        headers: {
          'Content-Type': 'application/json',
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert(data.message); // Mensaje de éxito
          // Actualizar el botón para reflejar el nuevo estado
          const button = document.getElementById(`status-button-${userId}`);
          button.textContent = newStatus ? 'Deshabilitar' : 'Habilitar';
          button.classList.toggle('btn-success', newStatus);
          button.classList.toggle('btn-danger', !newStatus);
        } else {
          alert(data.message); // Mensaje de error
        }
      })
      .catch(error => {
        alert('Error al cambiar el estado del usuario.');
        console.error(error);
      });
    };

    // Crear la tabla Grid.js
    new gridjs.Grid({
      columns: [
        { name: "ID", sort: true },
        { name: "Nombre de Usuario", sort: true },
        { name: "Nombre", sort: true },
        { name: "Apellido", sort: true },
        { name: "Email", sort: true },
        {
          name: "Habilitado",
          formatter: (cell, row) => {
            const userId = row.cells[0].data;
            const isEnabled = cell; // true o false
            return gridjs.html(`
              <button id="status-button-${userId}" 
                      class="btn ${isEnabled ? 'btn-success' : 'btn-danger'}" 
                      onclick="toggleUserStatus(${userId}, ${isEnabled})">
                ${isEnabled ? 'Deshabilitar' : 'Habilitar'}
              </button>
            `);
          }
        }
      ],
      data: usuarios.map(usuario => [
        usuario.id,
        usuario.username,
        usuario.firstName ?? '',
        usuario.lastName ?? '',
        usuario.email ?? 'No especificado',
        usuario.enabled, // Valor booleano para habilitado
      ]),
      pagination: {
        limit: 5
      },
      search: true,
      sort: true,
      language: {
        search: {
          placeholder: "Buscar..."
        },
        pagination: {
          previous: "Anterior",
          next: "Siguiente",
          showing: "Mostrando",
          results: () => "Resultados"
        }
      }
    }).render(document.getElementById("grid-container"));
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Ensure the output is properly encoded
  const usuarios = <?php echo json_encode($usuarios, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
  console.log(usuarios); // Check the structure of the output
  // Continue with your Grid.js logic
});
</script>
<?php
// FOOTER
function footerjs()
{
  echo "";
}
include_once('./includes/footer.php');
?>