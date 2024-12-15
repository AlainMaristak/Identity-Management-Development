<?php
$endpoint = './funciones/adm-obtener-lista-usuarios.php';
$jsonData = file_get_contents($endpoint);
$usuarios = json_decode($jsonData, true); 
print_r($usuarios);