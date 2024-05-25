<?php
include_once 'consulta.php';

// Verifica si se proporcionó el parámetro "id_conversacion" en la URL
if (isset($_GET['id_conversacion'])) {
    $id_conversacion = $_GET['id_conversacion'];

    // Crea una instancia de la clase consulta
    $consultas = new consulta();

    // Verifica si la clase y el método existen
    if (class_exists('consulta') && method_exists($consultas, 'obtenerMensajes')) {
        try {
            // Intenta obtener los mensajes
            $resultado = $consultas->obtenerMensajes($id_conversacion);

            // Verifica si la ejecución fue exitosa
            if ($resultado !== false) {
                // Agrega esta línea para especificar que la respuesta es JSON
                header('Content-Type: application/json');

                // Devuelve la respuesta como JSON
                echo json_encode($resultado);
            } else {
                // Maneja el caso en que no se puedan obtener los mensajes
                echo json_encode(['error' => 'Error al obtener mensajes.']);
            }
        } catch (PDOException $e) {
            // Maneja los errores de la consulta PDO
            echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
        }
    } else {
        // Maneja el caso en que la clase o el método no existan
        echo json_encode(['error' => 'La clase "consulta" no está definida o el método "obtenerMensajes" no está definido en la clase.']);
    }
} else {
    // Maneja el caso en que falta el parámetro "id_conversacion" en la solicitud
    echo json_encode(['error' => 'Falta el parámetro "id_conversacion" en la solicitud.']);
}
?>
