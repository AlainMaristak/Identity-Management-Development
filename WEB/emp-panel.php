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
        <h1 class="h2">Bienvenido <?php echo $usuario ?></h1>
    </div>
    <h2 class="text-center mb-4">Últimas transacciones</h2>

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

    // Verificar si hay resultados
    echo '<p>Últimas 10 transacciones</p>';

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
        while ($row = $result->fetch_assoc()) { // Recorrer los resultados de la consulta y mostrarlos en filas
            echo '<tr>
                <td>' . htmlspecialchars($row['fecha']) . '</td>
                <td>' . htmlspecialchars($row['descripcion']) . '</td>
                <td>' . htmlspecialchars($row['importe']) . '</td>';
                if (!empty($row['ticket'])) {
                    echo '<td><a href="' . htmlspecialchars($row['ticket']) . ' "target="_blank"> Ticket </a></td>';
                } else {
                    echo '<td>No hay ticket</td>';
                }
            echo '</tr>';
        }
        echo '</tbody>
    </table>';
    } else { // Mensaje si no hay resultados
        echo "<p>No se encontraron transacciones para el ID especificado.</p>";
    }
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