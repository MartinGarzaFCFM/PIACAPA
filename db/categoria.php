<?php
/////////////////////////////
include_once 'consulta.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agregarCategoria'])) {
        $nombreCategoria = $_POST['nombrecat'];
        $descripcionCategoria = $_POST['descripcioncat'];
        $user_id = $_SESSION['user_id']; // Retrieve the user ID from the session


        // Validaciones de los datos ingresados
        if (empty($nombreCategoria) || empty($descripcionCategoria)) {
            echo "<script type='text/javascript'>alert('Por favor, completa todos los campos.');</script>";
            echo "<script type='text/javascript'>window.location.href = '../Home.php';</script>";
        } else {
            // Procede a insertar la categoría en la base de datos
            $consulta = new consulta();
            $consulta->insertarCategoria($nombreCategoria, $descripcionCategoria, $user_id);

            echo "Categoría registrada exitosamente.";
            echo "<script type='text/javascript'>window.location.href = '../categoria.php';</script>";
        }
    }
}
?>

   