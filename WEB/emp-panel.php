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
?>

<!-- Contenido principal -->
<div class="content">
    <h1>Bienvenido</h1>
    <p>Este es el contenido principal de la página. El sidebar se encuentra a la izquierda y es fijo.</p>
    <h2 class="text-center mb-4">Lista de Productos</h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">Categoría</th>
                <th scope="col">Stock</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Producto A</td>
                <td>$10.00</td>
                <td>Electrónica</td>
                <td>50</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Producto B</td>
                <td>$20.00</td>
                <td>Ropa</td>
                <td>100</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Producto C</td>
                <td>$15.00</td>
                <td>Alimentos</td>
                <td>200</td>
            </tr>
        </tbody>
    </table>
</div>
    <?php
    include_once('./includes/footer.php');
    ?>