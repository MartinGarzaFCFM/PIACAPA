<?php
session_start();
include_once 'consulta.php';

$idCategoria = isset($_POST['c_cat_id']) ? $_POST['c_cat_id'] : null;
$nuevoNombre = isset($_POST['nuevo_nombre']) ? $_POST['nuevo_nombre'] : null;
$nuevaDescripcion = isset($_POST['nueva_descripcion']) ? $_POST['nueva_descripcion'] : null;

if ($idCategoria !== null) {
    try {
        $consultas = new consulta();

        $result = $consultas->EditarCategoria($idCategoria, $nuevoNombre, $nuevaDescripcion);

        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la categoría: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de categoría no válido']);
}
?>
