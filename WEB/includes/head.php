  <?php
  $usuario = $_SESSION['usuario'];
  echo ("
<!DOCTYPE html>
<html lang='es'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <title>$np</title>
  <link rel='icon' href='./assets/img/favicon.ico' type='image/x-icon'>
  <link href='./assets/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
  <link rel='stylesheet' href='./assets/bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.css'>
  <link href='./assets/css/dashboard.css' rel='stylesheet'>
  <link href='./assets/css/gpt.css' rel='stylesheet'>
  <link href='./assets/css/wannacrack.css' rel='stylesheet'>
  <link href='https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js'></script>
</head>
  <style>
    .snow-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1050; /* Superior a cualquier contenido */
      pointer-events: none; /* Para no interferir con los clics en otros elementos */
      background: url('./assets/img/snow.gif') repeat; /* URL del GIF */
      opacity: 0.8; /* Ajusta la opacidad si es necesario */
    }
  </style>
<body class='$bodyclass'>
");
  ?>
