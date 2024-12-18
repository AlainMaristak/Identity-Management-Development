<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (empty($_SESSION['tipo']) || $_SESSION['tipo'] != 'admin') {
    header("Location: ../index.php?funcionHistorico");
    die();
}

include_once('../includes/bbdd.php');

// Recibir los filtros desde el frontend
$data = json_decode(file_get_contents("php://input"), true);
$fecha_inicio = $data['fecha_inicio'] ?? null;
$fecha_fin = $data['fecha_fin'] ?? null;
$precio_min = $data['precio_min'] ?? null;
$precio_max = $data['precio_max'] ?? null;

// Construir consulta con filtros
$sql = "SELECT transacciones.fecha, transacciones.descripcion, transacciones.importe, transacciones.ticket, usuarios.usuario
        FROM transacciones
        INNER JOIN usuarios_tarjetas ON usuarios_tarjetas.id = transacciones.id_usuario_tarjeta
        INNER JOIN usuarios ON usuarios.id = usuarios_tarjetas.id_usuario
        WHERE 1=1"; // El WHERE 1=1 facilita agregar condiciones dinámicamente

$types = "";
$params = [];

// Agregar filtros dinámicos
if ($fecha_inicio) {
    $sql .= " AND transacciones.fecha >= ?";
    $types .= "s";
    $params[] = $fecha_inicio;
}
if ($fecha_fin) {
    $sql .= " AND transacciones.fecha <= ?";
    $types .= "s";
    $params[] = $fecha_fin;
}
if ($precio_min) {
    $sql .= " AND transacciones.importe >= ?";
    $types .= "d";
    $params[] = $precio_min;
}
if ($precio_max) {
    $sql .= " AND transacciones.importe <= ?";
    $types .= "d";
    $params[] = $precio_max;
}

$sql .= " ORDER BY transacciones.fecha DESC";
$stmt = $conn->prepare($sql);

// Solo asignar parámetros si existen
if (!empty($types)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Inicializar variables
$transacciones = [];
$total_mes_actual = $total_mes_anterior = $total_ano = $total_global = 0;

$fecha_actual = new DateTime();
$primer_dia_mes_actual = (clone $fecha_actual)->modify('first day of this month')->format('Y-m-d');
$ultimo_dia_mes_anterior = (clone $fecha_actual)->modify('last day of previous month')->format('Y-m-d');
$primer_dia_mes_anterior = (clone $fecha_actual)->modify('first day of previous month')->format('Y-m-d');
$inicio_ano = $fecha_actual->format('Y') . '-01-01';

while ($row = $result->fetch_assoc()) {
    $fecha_transaccion = $row['fecha'];
    $importe = floatval($row['importe']);

    // Calcular totales
    if ($fecha_transaccion >= $primer_dia_mes_actual) {
        $total_mes_actual += $importe;
    } elseif ($fecha_transaccion >= $primer_dia_mes_anterior && $fecha_transaccion <= $ultimo_dia_mes_anterior) {
        $total_mes_anterior += $importe;
    }
    if ($fecha_transaccion >= $inicio_ano) {
        $total_ano += $importe;
    }
    $total_global += $importe;

    // Añadir transacción al array
    $transacciones[] = $row;
}

// Generar salida JSON
$data = [
    "transacciones" => $transacciones,
    "totales" => [
        "mes_actual" => $total_mes_actual,
        "mes_anterior" => $total_mes_anterior,
        "ano_actual" => $total_ano,
        "global" => $total_global
    ]
];
header('Content-Type: application/json');
echo json_encode($data);
exit;
