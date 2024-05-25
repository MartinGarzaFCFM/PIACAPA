<?php
session_start();
include_once 'consulta.php';

// Asegúrate de incluir la lógica para conectar a la base de datos y cualquier cosa necesaria

// Obtén el ID de la lista desde los parámetros GET
$idLista = isset($_GET['idLista']) ? $_GET['idLista'] : null;

// Verifica si el ID de la lista está presente
if ($idLista !== null) {
    // Llama a tu función cargarContenidoLista con el ID de la lista
    $consultas = new consulta(); // Asegúrate de instanciar tu clase consulta
    $productos = $consultas->cargarContenidoLista($idLista);

    // Devuelve los productos en formato JSON
    echo json_encode($productos);
} else {
    // Manejo de error si no se proporciona el ID de la lista
    echo json_encode(['error' => 'ID de lista no proporcionado']);
}
?>
