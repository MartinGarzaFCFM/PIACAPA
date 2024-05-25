<?php
session_start();
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'EliminarCategoria')) {
        $idCategoria = isset($_POST['idCategoria']) ? $_POST['idCategoria'] : null;

        if ($idCategoria !== null) {
            $result = $consultas->EliminarCategoria($idCategoria);
            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'ID de categoría no proporcionado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'El método "EliminarCategoria" no está definido en la clase "consulta"']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'La clase "consulta" no está definida']);
}
?>
