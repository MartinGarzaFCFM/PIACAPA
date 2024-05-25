<?php
session_start(); 

include_once 'consulta.php';

header('Content-Type: application/json');

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerProductosVendedor')) {
        $usuario_id = isset($_SESSION['usuario']['id']) ? $_SESSION['usuario']['id'] : null;

        if ($usuario_id !== null) {
            $productos = $consultas->obtenerProductosVendedor($usuario_id);
            echo json_encode($productos);
        } else {
            echo json_encode(['error' => 'ID de usuario no definido en la sesión.']);
        }
    } else {
        echo json_encode(['error' => 'El método "obtenerProductosVendedor" no está definido en la clase "consulta".']);
    }
} else {
    echo json_encode(['error' => 'La clase "consulta" no está definida.']);
}
?>
