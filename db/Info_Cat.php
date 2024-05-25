<?php
session_start();
include_once 'consulta.php';


$idCategoria = isset($_GET['CAT_ID']) ? $_GET['CAT_ID'] : null;

if ($idCategoria  !== null) {
    $consultas = new consulta();
    $categoria = $consultas->cargarContenidoCat($idCategoria );
    header('Content-Type: application/json');
    echo json_encode($categoria);
} else {
    echo json_encode(['error' => 'ID de categoria no proporcionado']);
}

?>
