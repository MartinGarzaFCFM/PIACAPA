<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idLista'], $_POST['idProducto'], $_POST['cantidad'])) {
        $idLista = $_POST['idLista'];
        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];
        $idUsuario = $_SESSION['user_id'];

        if (class_exists('consulta')) {
            $consultas = new consulta();

            if (method_exists($consultas, 'agregarAListaProducto')) {
                $resultado = $consultas->agregarAListaProducto($idLista, $idProducto, $idUsuario, $cantidad);
                echo json_encode(['mensaje' => $resultado['mensaje']]);
            } else {
                echo "El método 'agregarAListaProducto' no está definido en la clase 'consulta'.";
            }
        } else {
            echo "La clase 'consulta' no está definida.";
        }
    } else {
        echo "No se proporcionaron el ID de lista, el ID de producto o la cantidad.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>