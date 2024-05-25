<?php
session_start();
include_once 'consulta.php';


$idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : null;
$nombreProducto = isset($_POST['nombrePro']) ? $_POST['nombrePro'] : null;
$descripcionProducto = isset($_POST['descripcionPro']) ? $_POST['descripcionPro'] : null;
$tipoProducto = isset($_POST['tipo']) ? $_POST['tipo'] : null;
$cantidadProducto = isset($_POST['cantidadPro']) ? $_POST['cantidadPro'] : null;
$categoriaProducto = isset($_POST['categoriaSelect']) ? $_POST['categoriaSelect'] : null;
$precioProducto = isset($_POST['precioPro']) ? $_POST['precioPro'] : null;
$materialProducto = isset($_POST['materialCot']) ? $_POST['materialCot'] : null;
$medidasProducto = isset($_POST['medidasCot']) ? $_POST['medidasCot'] : null;

if ($idProducto !== null) {
    try {
        $consultas = new consulta();

        $result = $consultas->ModificarProducto($idProducto, $nombreProducto, $descripcionProducto, $tipoProducto, $cantidadProducto, $categoriaProducto, $precioProducto, $materialProducto, $medidasProducto);

        echo json_encode($result);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el producto: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID de producto no válido']);
}
?>
