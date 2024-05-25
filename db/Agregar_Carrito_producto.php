<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idProducto'], $_POST['cantidad'], $_POST['user_id'])) {
        $idProducto = $_POST['idProducto'];
        $cantidad = $_POST['cantidad'];
        $usuario_id = $_POST['user_id'];

        if (class_exists('consulta')) {
            $consulta = new consulta();
            if (method_exists($consulta, 'AgregarProductoAlCarrito')) {
                $resultado = $consulta->AgregarProductoAlCarrito($idProducto, $usuario_id, $cantidad);

                // Verificar si la ejecución fue exitosa
                if ($resultado) {
                    echo json_encode(['success' => true, 'mensaje' => 'Producto agregado al carrito con éxito']);
                } else {
                    echo json_encode(['success' => false, 'mensaje' => 'Error al agregar el producto al carrito']);
                }
            } else {
                echo json_encode(['success' => false, 'mensaje' => 'El método "AgregarProductoAlCarrito" no está definido en la clase "consulta".']);
            }
        } else {
            echo json_encode(['success' => false, 'mensaje' => 'La clase "consulta" no está definida.']);
        }
    } else {
        echo json_encode(['success' => false, 'mensaje' => 'No se proporcionaron ID de producto, la cantidad o el ID de usuario.']);
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método de solicitud no válido.']);
}
?>
