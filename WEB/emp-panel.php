<?php
include_once('./includes/head.php');
include_once('./includes/navbar.php');
?>
<div class='container mt-5'>
    <h1 class='text-center'>Ejemplo de Modal en Bootstrap 5</h1>

    <!-- Botón para abrir el modal -->
    <div class='text-center mt-4'>
        <button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#myModal'>Abrir Modal</button>
    </div>
</div>

<!-- Modal -->
<div class='modal fade' id='myModal' tabindex='-1' aria-labelledby='myModalLabel' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='myModalLabel'>Título del Modal</h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Cerrar'></button>
            </div>
            <div class='modal-body'>
                Este es el contenido de tu modal. Puedes colocar cualquier información aquí.
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cerrar</button>
                <button type='button' class='btn btn-primary'>Guardar cambios</button>
            </div>
        </div>
    </div>
</div>
<?php
include_once('./includes/footer.php');
?>