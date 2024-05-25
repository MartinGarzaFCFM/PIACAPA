<?php
header('Content-Type: application/json');

session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ID_LISTA'], $_POST['ID_PRODUCTO'])) {
        $idLista = $_POST['ID_LISTA'];
        $idProducto = $_POST['ID_PRODUCTO'];
        $idUsuario = $_SESSION['user_id'];
        
        if (class_exists('consulta')) {
            $consultas = new consulta();

            if (method_exists($consultas, 'eliminarProductoDeLista')) {
                $resultado = $consultas->eliminarProductoDeLista($idLista, $idProducto, $idUsuario);
                echo json_encode(['mensaje' => $resultado['mensaje']]);
            } else {
                echo "El método 'eliminarProductoDeLista' no está definido en la clase 'consulta'.";
            }
        } else {
            echo "La clase 'consulta' no está definida.";
        }
    } else {
        echo "No se proporcionaron el ID de lista o el ID de producto.";
    }
} else {
    echo json_encode(['success' => false, 'mensaje' => 'Método de solicitud no válido.']);
}
?>
