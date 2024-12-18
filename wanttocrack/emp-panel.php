<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (empty($_SESSION['usuario']) || $_SESSION['tipo'] != 'empresa') {
  header("Location: index.php?EmpresaPanel");
  die();
}

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/bbdd.php');

$usuario = $_SESSION['usuario'];
// $nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];

$id = $_SESSION['id'];
// Verifica que $id sea un número
if (!is_numeric($id)) {
  die("ID inválido.");
}

// Consulta a la base de datos
$sql = "SELECT transacciones.fecha, transacciones.descripcion, transacciones.importe, transacciones.ticket
        FROM transacciones
        INNER JOIN usuarios_tarjetas ON usuarios_tarjetas.id = transacciones.id_usuario_tarjeta
        WHERE usuarios_tarjetas.id_usuario = ?
        ORDER BY transacciones.fecha DESC
        LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Preparar los datos para la tabla y el gráfico
$transacciones = [];
$datosGrafico = []; // Asociativo para agrupar por fecha

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $fecha = htmlspecialchars($row['fecha']);
    $descripcion = htmlspecialchars($row['descripcion']);
    $importe = htmlspecialchars($row['importe']);
    $ticket = htmlspecialchars($row['ticket']);

    // Para la tabla
    $transacciones[] = [$fecha, $descripcion, $importe, $ticket];

    // Para el gráfico (suma los importes por fecha)
    if (!isset($datosGrafico[$fecha])) {
      $datosGrafico[$fecha] = 0;
    }
    $datosGrafico[$fecha] += floatval($importe);
  }
}

// Transformar los datos del gráfico en dos arrays
$labels = array_keys($datosGrafico); // Fechas
$dataset = array_values($datosGrafico); // Importes

$result->free();
?>
<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Últimas transacciones</h1>
  </div>
  <canvas class="my-4 w-100" id="myChart" style="display: block; box-sizing: border-box; height: 287px; width: 681px;"></canvas>
  <div id="grid-container"></div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Crear la tabla Grid.js
      new gridjs.Grid({
        columns: [{
            name: "Fecha",
            sort: true
          },
          {
            name: "Descripción",
            sort: true
          },
          {
            name: "Importe (€)",
            sort: {
              compare: (a, b) => parseFloat(a) - parseFloat(b)
            },
            formatter: (cell) => parseFloat(cell).toFixed(2)
          },
          {
            name: "Ticket",
            formatter: (cell) => cell ? gridjs.html(`<a href="${cell}" target="_blank">Ticket</a>`) : "No hay ticket"
          }
        ],
        data: <?php echo json_encode($transacciones, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>,
        pagination: {
          limit: 4
        },
        search: false,
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

      // Crear el gráfico Chart.js
      const ctx = document.getElementById('myChart').getContext('2d');
      const labels = <?php echo json_encode($labels); ?>;
      const data = <?php echo json_encode($dataset); ?>;

      new Chart(ctx, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: 'Importe (€)',
            data: data,
            lineTension: 0.1,
            backgroundColor: 'rgba(0, 123, 255, 0.1)',
            borderColor: '#007bff',
            borderWidth: 2,
            pointBackgroundColor: '#007bff',
          }]
        },
        options: {
          plugins: {
            legend: {
              display: true
            },
            tooltip: {
              boxPadding: 5
            }
          },
          scales: {
            x: {
              title: {
                display: true,
                text: 'Fecha'
              }
            },
            y: {
              title: {
                display: true,
                text: 'Importe (€)'
              }
            }
          }
        }
      });
    });
  </script>
</main>
<!-- FIN CONTENIDO -->

<?php
function footerjs()
{
  echo "
    <script src='https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js'></script>
    ";
}
include_once('./includes/footer.php');
?>
