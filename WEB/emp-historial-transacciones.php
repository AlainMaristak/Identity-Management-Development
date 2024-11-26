<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}
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
    if (!is_numeric($id)) {
        die("ID inválido.");
    }

    // Consulta SQL para obtener los datos
    $sql = "SELECT transacciones.fecha, transacciones.descripcion, transacciones.importe, transacciones.ticket
        FROM transacciones
        INNER JOIN usuarios_tarjetas ON usuarios_tarjetas.id = transacciones.id_usuario_tarjeta
        WHERE usuarios_tarjetas.id_usuario = ?
        ORDER BY transacciones.fecha DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Inicializar totales
    $total_mes_actual = 0;
    $total_mes_anterior = 0;
    $total_ano = 0;
    $total_global = 0;

    // Obtener fechas relevantes
    $fecha_actual = new DateTime();
    $primer_dia_mes_actual = (clone $fecha_actual)->modify('first day of this month')->format('Y-m-d');
    $ultimo_dia_mes_anterior = (clone $fecha_actual)->modify('last day of previous month')->format('Y-m-d');
    $primer_dia_mes_anterior = (clone $fecha_actual)->modify('first day of previous month')->format('Y-m-d');
    $inicio_ano = $fecha_actual->format('Y') . '-01-01';

    echo '
    <div class="row">
        <div class="col-lg-8">';

    // Crear tabla
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Descripción</th>
                <th scope="col">Importe</th>
                <th scope="col">Ticket</th>
            </tr>
        </thead>
        <tbody>';

        while ($row = $result->fetch_assoc()) {
            $fecha_transaccion = $row['fecha'];
            $importe = floatval($row['importe']);

            // Calcular totales según el rango de fechas
            if ($fecha_transaccion >= $primer_dia_mes_actual) {
                $total_mes_actual += $importe; // Mes actual
            } elseif ($fecha_transaccion >= $primer_dia_mes_anterior && $fecha_transaccion <= $ultimo_dia_mes_anterior) {
                $total_mes_anterior += $importe; // Mes anterior
            }
            if ($fecha_transaccion >= $inicio_ano) {
                $total_ano += $importe; // Año actual
            }
            $total_global += $importe; // Total acumulado

            // Mostrar filas de la tabla
            echo '<tr>
                <td>' . htmlspecialchars($row['fecha']) . '</td>
                <td>' . htmlspecialchars($row['descripcion']) . '</td>
                <td>' . htmlspecialchars(number_format($importe, 2)) . ' €</td>';
            if (!empty($row['ticket'])) {
                echo '<td><a href="' . htmlspecialchars($row['ticket']) . '" target="_blank">Ticket</a></td>';
            } else {
                echo '<td>No hay ticket</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>
    </table>';
    } else {
        echo "<p>No se encontraron transacciones para el ID especificado.</p>";
    }

    echo "
        </div>
        <div class='col-lg-4'>
            <div class='bg-body-secondary p-2'>
                <p class='h3'>Mes actual: " . number_format($total_mes_actual, 2) . " €</p>
                <p class='h4'>Mes anterior: " . number_format($total_mes_anterior, 2) . " €</p>
                <p class='h5'>Año actual: " . number_format($total_ano, 2) . " €</p>
                <p class='h6'>Total global: " . number_format($total_global, 2) . " €</p>
            </div>
            <div>"; ?>
                <form method="GET" action="ruta_a_tu_script.php" class="mb-4 mt-2">
                    <!-- Filtro por fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <!-- Filtro por precio -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="precio_min" class="form-label">Precio mínimo</label>
                            <input type="number" class="form-control" id="precio_min" name="precio_min" step="0.01" placeholder="Ej. 10.00">
                        </div>
                        <div class="col-md-6">
                            <label for="precio_max" class="form-label">Precio máximo</label>
                            <input type="number" class="form-control" id="precio_max" name="precio_max" step="0.01" placeholder="Ej. 100.00">
                        </div>
                    </div>

                    <!-- Botón de filtro -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                </form>
<?php echo "
            </div>
        </div>

    </div>";
    // Liberar los resultados
    $result->free();
    ?>
</main>
<!-- FIN CONTENIDO -->


<?php
function footerjs()
{
    echo "";
}
include_once('./includes/footer.php');
?>