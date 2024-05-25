<?php

include_once 'consulta.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RegisterLista'])) {

    if (isset($_POST['RegisterLista'])) {
        $nombreLista = $_POST['nombreLista'];
        $descripcionLista = $_POST['descripcionLista'];
        $privacidadLista = $_POST['tipoLista'];
        $creadorLista = $_SESSION['user_id'];  // Obtén el ID del usuario de la sesión

        // Validaciones de los datos ingresados
        if (empty($nombreLista) || empty($descripcionLista) || empty($privacidadLista)) {
            echo "<script type='text/javascript'>alert('Por favor, completa todos los campos.');</script>";
        } else {
            // Procede a insertar la lista en la base de datos
            $consulta = new consulta();
            $consulta->registrarLista($nombreLista, $descripcionLista, $privacidadLista, $creadorLista);

            echo "<script type='text/javascript'>alert('Lista creada exitosamente.');</script>";
            echo "<script type='text/javascript'>window.location.href = '../Home.php';</script>";
        }
    }
}
?>


