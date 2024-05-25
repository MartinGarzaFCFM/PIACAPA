<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idCoti'])) {
        $idCoti = $_POST['idCoti'];

        // Llama a la función para rechazar el producto cotizado
        rechazarProductoCotizado($idCoti);
        
        // Devuelve una respuesta (puedes personalizar según sea necesario)
        echo "Producto rechazado exitosamente.";
    } else {
        echo "ID_COTI no proporcionado en la solicitud.";
    }
} else {
    echo "Método de solicitud no válido.";
}

function rechazarProductoCotizado($idCoti) {
    // Aquí debes conectar a tu base de datos y ejecutar el procedimiento almacenado
    // Puedes utilizar la lógica de tu procedimiento almacenado
    $consulta = new consulta();
    $consulta->EliminarProductoCotizado($idCoti); // Ajusta el nombre de tu función según sea necesario
}
?>
