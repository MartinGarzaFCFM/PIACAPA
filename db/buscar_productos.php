<?php
session_start();
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'buscarProductos')) {
        // Obtén el valor de búsqueda
        $busqueda = $_POST['busqueda'];

        // Ejecuta la función para buscar productos
        $resultados = $consultas->buscarProductos($busqueda);

        // Maneja los resultados según sea necesario
        echo json_encode($resultados);
    } else {
        echo "El método 'buscarProductos' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}
?>
