<?php
  session_start();
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
    // Verifica si 'ID_LISTA' está definido en $_GET
    if (isset($_GET['ID_LISTA'])) {
        $ID_LISTA = $_GET['ID_LISTA'];
        
        // Obtén el ID del usuario desde la sesión
        $ID_USUARIO = $_SESSION['user_id'];
       // $user_id = $_SESSION['user_id'];
      
        if (class_exists('consulta')) {
            $consultas = new consulta();

            if (method_exists($consultas, 'obtenerInformacionLista')) {
                $infoLista = $consultas->obtenerInformacionLista($ID_LISTA, $ID_USUARIO);
                echo json_encode($infoLista);
            } else {
                echo "El método 'obtenerInformacionLista' no está definido en la clase 'consulta'.";
            }
        } else {
            echo "La clase 'consulta' no está definida.";
        }
    } else {
        // Si 'ID_LISTA' no está definido, muestra un mensaje correspondiente
        echo "No se proporcionó un ID de lista.";
        
    }
} else {
    echo "Método de solicitud no válido.";
}

?>