<?php
session_start(); 

include_once 'consulta.php';

header('Content-Type: application/json');

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerProductosAprobados')) {
        $productos = $consultas->obtenerProductosAprobados();
        echo json_encode($productos);
    } else {
        echo json_encode(['error' => 'El método "obtenerProductosAprobados" no está definido en la clase "consulta".']);
    }
} else {
    echo json_encode(['error' => 'La clase "consulta" no está definida.']);
}
?>
