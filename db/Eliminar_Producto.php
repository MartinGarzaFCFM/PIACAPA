<?php

session_start();
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'EliminarProducto')) {
        $idProducto = isset($_POST['idProducto']) ? $_POST['idProducto'] : null;

        if ($idProducto !== null) {
            $result = $consultas->EliminarProducto($idProducto);
            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'ID de producto no proporcionado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'El método "EliminarProducto" no está definido en la clase "consulta"']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'La clase "consulta" no está definida']);
}
?>
