<?php
session_start();
include_once 'consulta.php';


if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerNombresCat')) {
        $CAT_CREADOR = $_SESSION['user_id'];
        $categorias = $consultas->obtenerNombresCat($CAT_CREADOR);
        echo json_encode($categorias);  
    } else {
        echo "El método 'obtenerNombresCat' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}

