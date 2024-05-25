<?php
session_start();
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'EliminarLista')) {
        // Obtén el ID de lista desde la solicitud POST
        $idLista = isset($_POST['ID_LISTA']) ? $_POST['ID_LISTA'] : null;

        if ($idLista !== null) {
            // Llama al método para eliminar la lista
            $result = $consultas->EliminarLista($idLista);
            echo json_encode($result);
        } else {
            echo json_encode(['success' => false, 'message' => 'ID de lista no proporcionado']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'El método "EliminarLista" no está definido en la clase "consulta"']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'La clase "consulta" no está definida']);
}
