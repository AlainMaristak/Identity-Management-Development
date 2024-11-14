<?php
$servername = "localhost";
$username = "wannacrack"; 
$password = "n0sequeponer";
$database = "reto"; 

$conn = new mysqli($servername, $username, $password, $database);

// Comprobar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}