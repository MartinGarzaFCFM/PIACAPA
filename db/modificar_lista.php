<?php
session_start(); 
include_once 'consulta.php';

// Obtén los datos del formulario
$idLista = $_POST['ID_LISTA'];
$nombreLista = $_POST['LIST_NOMBRE'];
$descripcionLista = $_POST['LIST_DESCRIPCION'];
$tipoLista = $_POST['LIST_PRIVACIDAD'];

// Verifica si el ID de la lista está presente
if ($idLista !== null) {
    try {
        // Instancia la clase consulta
        $consultas = new consulta();

        // Llama al método ModificarLista con los nuevos valores
        $consultas->ModificarLista($idLista, $nombreLista, $descripcionLista, $tipoLista);

        // Devuelve una respuesta de éxito en formato JSON
        echo json_encode(['success' => true, 'message' => 'Lista actualizada con éxito']);
    } catch (Exception $e) {
        // Manejo de errores: Devuelve un mensaje de error en formato JSON
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la lista: ' . $e->getMessage()]);
    }
} else {
    // Devuelve un mensaje de error si el ID de la lista no está presente
    echo json_encode(['success' => false, 'message' => 'ID de lista no válido']);
}
?>
