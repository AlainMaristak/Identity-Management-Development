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

$usuario = $_SESSION['usuario'];
$nombre_empresa = $_SESSION['nombre_empresa'];
$tipo = $_SESSION['tipo'];
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Últimas transacciones</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <table class="table table-striped table-bordered" id="tabla-transacciones">
                <thead>
                    <tr>
                        <th scope="col">Fecha</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Importe</th>
                        <th scope="col">Ticket</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="col-lg-4">
            <div class="bg-body-secondary p-2">
                <p class="h3">Mes actual: <span id="mes-actual">0.00 €</span></p>
                <p class="h4">Mes anterior: <span id="mes-anterior">0.00 €</span></p>
                <p class="h5">Año actual: <span id="ano-actual">0.00 €</span></p>
                <p class="h6">Total global: <span id="global">0.00 €</span></p>
            </div>
            <div>
                <form id="filtroForm" class="mb-4 mt-2">
                    <!-- Filtro por fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label">Fecha fin</label>
                            <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
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
                ?>
</main>
<!-- FIN CONTENIDO -->

<script>
    // Función para obtener y cargar las transacciones
    function cargarTransacciones(filtros = {}) {
        const {
            fecha_inicio = "", fecha_fin = "", precio_min = "", precio_max = ""
        } = filtros;

        fetch("./funciones/emp-datos-historial-transacciones.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    fecha_inicio,
                    fecha_fin,
                    precio_min,
                    precio_max
                })
            })
            .then(response => response.json())
            .then(data => {
                // Limpiar la tabla antes de agregar los nuevos datos
                const tbody = document.querySelector("#tabla-transacciones tbody");
                tbody.innerHTML = "";

                // Insertar las nuevas transacciones
                data.transacciones.forEach(transaccion => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                <td>${transaccion.fecha}</td>
                <td>${transaccion.descripcion}</td>
                <td>${Number(transaccion.importe).toFixed(2)} €</td>
                <td>${transaccion.ticket 
                    ? `<a href="${transaccion.ticket}" target="_blank">Ticket</a>` 
                    : "No hay ticket"}</td>`;
                    tbody.appendChild(row);
                });


                // Actualizar los totales (si no se han puesto filtros)
                if (!fecha_inicio && !fecha_fin && !precio_min && !precio_max) {
                    document.getElementById("mes-actual").textContent = `${data.totales.mes_actual.toFixed(2)} €`;
                    document.getElementById("mes-anterior").textContent = `${data.totales.mes_anterior.toFixed(2)} €`;
                    document.getElementById("ano-actual").textContent = `${data.totales.ano_actual.toFixed(2)} €`;
                    document.getElementById("global").textContent = `${data.totales.global.toFixed(2)} €`;
                }
            })
            .catch(error => console.error("Error al cargar los datos:", error));
    }

    // Ejecutar cuando el formulario sea enviado
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío normal del formulario

        const fechaInicio = document.getElementById("fecha_inicio").value;
        const fechaFin = document.getElementById("fecha_fin").value;
        const precioMin = document.getElementById("precio_min").value;
        const precioMax = document.getElementById("precio_max").value;

        // Llamar a la función para cargar las transacciones con filtros
        cargarTransacciones({
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin,
            precio_min: precioMin,
            precio_max: precioMax
        });
    });

    // Ejecutar al cargar la página sin filtros
    document.addEventListener("DOMContentLoaded", () => {
        cargarTransacciones();
    });
</script>



<?php
function footerjs()
{
    echo "";
}
include_once('./includes/footer.php');
?>