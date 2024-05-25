<?php
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerCategoriasVendedor')) {
        $categorias = $consultas->obtenerCategoriasVendedor();
        echo json_encode($categorias);
    } else {
        echo "El método 'obtenerCategoriasVendedor' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}

?>
