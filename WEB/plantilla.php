<?php
// session_start();
// if (empty($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') { header("Location: index.php"); die(); }

$np = "Inicio";
$bodyclass = '';
include_once('./includes/head.php');
include_once('./includes/cabecera.php');
include_once('./includes/navbar2.php');
?>

<!-- CONTENIDO -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
  </div>



</main>
<!-- FIN CONTENIDO -->

<?php
//FOOTER
function footerjs() { echo ""; }
//<script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"></script>
include_once('./includes/footer.php');
?>