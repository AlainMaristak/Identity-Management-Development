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
include_once('./includes/navbar2.php');
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

    $sql = "SELECT fecha, descripcion, importe FROM tarjetas_transacciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">Fecha</th>
                <th scope="col">Descripción</th>
                <th scope="col">Importe</th>
            </tr>
        </thead>
        <tbody>';
        while ($row = $result->fetch_assoc()) { // Recorrer los resultados de la consulta y mostrarlos en filas
            echo '<tr>
                <td>' . htmlspecialchars($row['fecha']) . '</td>
                <td>' . htmlspecialchars($row['descripcion']) . '</td>
                <td>' . htmlspecialchars($row['importe']) . '</td>
            </tr>';
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