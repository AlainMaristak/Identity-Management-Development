<?php
session_start();
if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: index.php");
    die();
}
$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/navbar.php');
include_once('./includes/BBDD.php');
?>

<!-- Contenido principal -->
<h1>Bienvenido Alain</h1>
<p>texto de ejemplo</p>
<h2 class="text-center mb-4">Últimas transacciones</h2>
<?php


// Consulta SQL para obtener las columnas deseadas
$sql = "SELECT fecha, descripcion, importe FROM tarjetas_transacciones WHERE id = 1";

// Ejecutar la consulta
$result = $conn->query($sql);

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
    
    // Recorrer los resultados de la consulta y mostrarlos en filas
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['fecha']) . '</td>
                <td>' . htmlspecialchars($row['descripcion']) . '</td>
                <td>' . htmlspecialchars($row['importe']) . '</td>
            </tr>';
    }
    
    echo '</tbody>
    </table>';
} else {
    // Mensaje si no hay resultados
    echo "<p>No se encontraron transacciones para el ID especificado.</p>";
}

// Liberar los resultados
$result->free();


include_once('./includes/footer.php');
?>