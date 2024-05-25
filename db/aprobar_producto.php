<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['idCoti'])) {
        $idCoti = $_POST['idCoti'];

        // Llama a tu procedimiento almacenado
        aprobarProductoCotizado($idCoti);
        
        // Devuelve una respuesta (puedes personalizar según sea necesario)
        echo "Producto aprobado exitosamente.";
    } else {
        echo "ID_COTI no proporcionado en la solicitud.";
    }
} else {
    echo "Método de solicitud no válido.";
}

function aprobarProductoCotizado($idCoti) {
    // Aquí debes conectar a tu base de datos y ejecutar el procedimiento almacenado
    // Puedes utilizar la lógica de tu procedimiento almacenado
    $consulta = new consulta();
    $consulta->AprobarProductoCotizado($idCoti); // Ajusta el nombre de tu función según sea necesario
}
?>
