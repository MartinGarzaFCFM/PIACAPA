<?php
session_start();
include_once 'consulta.php'; // Reemplaza con la ruta correcta
$consulta = new Consulta();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Llama a la función InsertarCompra
        $resultado = $consulta->InsertarCompra($user_id);

        // Maneja el resultado según tus necesidades
        if ($resultado) {
            echo 'La compra se ha insertado correctamente.';
        } else {
            echo 'Error al insertar la compra.';
        }
    } else {
        echo 'ID de usuario no proporcionado.';
    }
} else {
    echo 'Método no permitido.';
}
?>
