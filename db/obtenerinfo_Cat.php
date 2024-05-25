<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['CAT_ID'])) {
        $CAT_ID = $_GET['CAT_ID'];

        $CAT_CREADOR = $_SESSION['user_id'];

        if (class_exists('consulta')) {
            $consultas = new consulta();

            if (method_exists($consultas, 'obtenerInformacionCat')) {
                $infoCat = $consultas->obtenerInformacionCat($CAT_ID, $CAT_CREADOR);
                echo json_encode($infoCat);
            } else {
                echo "El método 'obtenerInformacionCat' no está definido en la clase 'consulta'.";
            }
        } else {
            echo "La clase 'consulta' no está definida.";
        }
    } else {
        echo "No se proporcionó un ID de la categoria.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
