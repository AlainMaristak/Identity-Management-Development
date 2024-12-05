<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') { header("Location: index.php"); die(); }

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar.php');
include_once('./includes/BBDD.php');

$usuario = $_SESSION['usuario'];
$nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Últimas transacciones</h1>
    </div>
    <?php
    $id = $_SESSION['id'];
    // Verifica que $id sea un número
    if (!is_numeric($id)) { die("ID inválido."); }

    $sql = "SELECT transacciones.fecha, transacciones.descripcion, transacciones.importe, transacciones.ticket
            FROM transacciones
            INNER JOIN usuarios_tarjetas ON usuarios_tarjetas.id = transacciones.id_usuario_tarjeta
            WHERE usuarios_tarjetas.id_usuario = ?
            ORDER BY transacciones.fecha DESC
            LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $transacciones = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transacciones[] = [
                htmlspecialchars($row['fecha']),
                htmlspecialchars($row['descripcion']),
                htmlspecialchars($row['importe']),
                htmlspecialchars($row['ticket'])
            ];
        }
    }

    $result->free();
    ?>

    <div id="grid-container"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                                compare: (a, b) => parseFloat(a) - parseFloat(b) // Comparar como números
                            },
                            formatter: (cell) => parseFloat(cell).toFixed(2) // Mostrar con dos decimales
                        },
                        {
                            name: "Ticket",
                            formatter: (cell) => cell ? gridjs.html(`<a href="${cell}" target="_blank">Ticket</a>`) : "No hay ticket"
                        }
                    ],
                data: <?php echo json_encode($transacciones, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>,
                pagination: false,
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
        });
    </script>
</main>
<!-- FIN CONTENIDO -->

<?php
function footerjs()
{
    echo "";
}
include_once('./includes/footer.php');
?>
