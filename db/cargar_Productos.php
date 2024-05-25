<?php
session_start();
include_once 'consulta.php';

//var_dump($_SESSION); // Verifica el contenido de $_SESSION

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerNombresProductos')) {
        $ID_USUARIO = $_SESSION['user_id'];
        $listas = $consultas->obtenerNombresProductos($ID_USUARIO);
        echo json_encode($listas);  // Corregí esta línea
    } else {
        echo "El método 'obtenerNombresProductos' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}

