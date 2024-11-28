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
        <h1 class="h2">Historial de transacciones</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div id="tabla-transacciones"></div>
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
    let grid; // Variable para almacenar la instancia de Grid.js

    // Función para cargar las transacciones con Grid.js
    function cargarTransacciones(filtros = {}) {
        const tabla = document.getElementById('tabla-transacciones');

        if (tabla.innerHTML.trim() === "") {
            console.log("true");
            var actualizar_totales = true;
        } else {
            console.log("false");
            tabla.innerHTML = "";
            var actualizar_totales = false;
        }

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
                if (grid) {
                    grid.destroy();
                }

                // Crear la tabla con Grid.js
                grid = new gridjs.Grid({
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
                            formatter: (cell) => cell ?
                                gridjs.html(`<a href="${cell}" target="_blank">Ticket</a>`) : "No hay ticket"
                        }
                    ],
                    data: data.transacciones.map(transaccion => [
                        transaccion.fecha,
                        transaccion.descripcion,
                        parseFloat(transaccion.importe).toFixed(2),
                        transaccion.ticket
                    ]),
                    pagination: {
                        limit: 10, // Número de registros por página
                    },
                    search: false,
                    sort: true,
                    language: {
                        search: {
                            placeholder: 'Buscar...'
                        },
                        pagination: {
                            showing: 'Mostrando del',
                            // 1
                            to: 'al',
                            // 10
                            of: 'de un total de',
                            // 20
                            previous: 'Anterior',
                            next: 'Siguiente',
                            results: () => 'registros',
                        }
                    }
                }).render(document.getElementById("tabla-transacciones"));

                // Actualizar los totales si no hay filtros
                if (actualizar_totales) {
                    document.getElementById("mes-actual").textContent = `${data.totales.mes_actual.toFixed(2)} €`;
                    document.getElementById("mes-anterior").textContent = `${data.totales.mes_anterior.toFixed(2)} €`;
                    document.getElementById("ano-actual").textContent = `${data.totales.ano_actual.toFixed(2)} €`;
                    document.getElementById("global").textContent = `${data.totales.global.toFixed(2)} €`;
                }
            })
            .catch(error => console.error("Error al cargar los datos:", error));
    }

    // Configurar el evento de envío del formulario
    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío normal del formulario

        const fechaInicio = document.getElementById("fecha_inicio").value;
        const fechaFin = document.getElementById("fecha_fin").value;
        const precioMin = document.getElementById("precio_min").value;
        const precioMax = document.getElementById("precio_max").value;

        // Recargar la tabla con los filtros aplicados
        cargarTransacciones({
            fecha_inicio: fechaInicio,
            fecha_fin: fechaFin,
            precio_min: precioMin,
            precio_max: precioMax
        });
    });

    // Cargar los datos al inicio
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