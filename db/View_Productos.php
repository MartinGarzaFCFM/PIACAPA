<?php
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerProductos')) {
        $productos = $consultas->obtenerProductos();
        echo json_encode($productos);
    } else {
        echo "El método 'obtenerProductos' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}
?>
