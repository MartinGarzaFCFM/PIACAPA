<?php
session_start();
include_once 'consulta.php';

$idProducto = isset($_GET['ID_PRO']) ? $_GET['ID_PRO'] : null;

if ($idProducto !== null) {
    $consultas = new consulta(); 
    $productos = $consultas->cargarContenidoProd($idProducto);
    header('Content-Type: application/json');
    echo json_encode($productos);
} else {
    echo json_encode(['error' => 'ID de producto no proporcionado']);
}

?>
