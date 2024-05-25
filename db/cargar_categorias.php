<?php
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerCategorias')) {
        $categorias = $consultas->obtenerCategorias();
        echo json_encode($categorias);
    } else {
        echo "El método 'obtenerCategorias' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}

?>
