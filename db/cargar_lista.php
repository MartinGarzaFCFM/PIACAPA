<?php
session_start();
include_once 'consulta.php';

//var_dump($_SESSION); // Verifica el contenido de $_SESSION

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerNombresListas')) {
        $ID_USUARIO = $_SESSION['user_id'];
       // var_dump($ID_USUARIO); // Verifica el valor de $ID_USUARIO
        $listas = $consultas->obtenerNombresListas($ID_USUARIO);
        //var_dump($listas); // Verifica el contenido de $listas
        echo json_encode($listas);
    } else {
        echo "El método 'obtenerNombresListas' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}
