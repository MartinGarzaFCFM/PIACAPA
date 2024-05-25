<?php
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'registrarProducto')) {
        $Producto = $consultas->registrarProducto();
        echo json_encode($Producto);
    } else {
        echo "El método 'registrarProducto' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}


?>
