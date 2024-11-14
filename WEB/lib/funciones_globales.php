<?php
function sanitize_input($data, $type = "string") {
    $data = trim($data); // Eliminar espacios en blanco al inicio y final
    switch ($type) {
        case "email":
            return filter_var($data, FILTER_SANITIZE_EMAIL);
        case "int":
            return filter_var($data, FILTER_SANITIZE_NUMBER_INT);
        case "string":
        default:
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
