<?php
session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica si 'ID_PRO' está definido en $_GET
    if (isset($_GET['ID_PRO'])) {
        $ID_PRO = $_GET['ID_PRO'];

        // Obtén el ID del usuario desde la sesión
        $ID_USUARIO = $_SESSION['user_id'];

        if (class_exists('consulta')) {
            $consultas = new consulta();

            if (method_exists($consultas, 'obtenerInformacionProducto')) {
                $infoProducto = $consultas->obtenerInformacionProducto($ID_PRO, $ID_USUARIO);
                echo json_encode($infoProducto);
            } else {
                echo "El método 'obtenerInformacionProducto' no está definido en la clase 'consulta'.";
            }
        } else {
            echo "La clase 'consulta' no está definida.";
        }
    } else {
        // Si 'ID_PRO' no está definido, muestra un mensaje correspondiente
        echo "No se proporcionó un ID de producto.";
    }
} else {
    echo "Método de solicitud no válido.";
}
?>
