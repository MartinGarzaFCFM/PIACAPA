<?php
include_once 'consulta.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Registermsj'])) {
    // Recuperar los datos del formulario (ajusta según tu implementación)
    $remitente = $_POST['remitente']; // ID del remitente
    $mensajeTexto = $_POST['mensaje']; // Mensaje
    $conversacion_id = $_POST['conversacion_id']; // ID de la conversación
    $destinatario = $_POST['destinatario']; // Destinatario
    $producto_id = $_POST['producto']; // Destinatario
    echo 'Antes de ejecutar la consulta<br>';
    echo 'Remitente: ' . $remitente . '<br>';
    echo 'Destinatario: ' . $destinatario . '<br>';
    echo 'Mensaje: ' . $mensajeTexto . '<br>';
    echo 'Conversación ID: ' . $conversacion_id . '<br>';
    echo 'prod ID: ' . $producto_id . '<br>';

    // Resto de tu lógica aquí...

    // Crear una instancia de la clase consulta
    $consultas = new consulta();

    // Llamar al método para enviar mensaje
    $resultado = $consultas->enviarMensaje($mensajeTexto, $remitente, $destinatario, $conversacion_id, $producto_id);

    if ($resultado) {
        echo "Mensaje enviado con éxito.";
        //echo "<script type='text/javascript'>alert('Producto registrado exitosamente.');</script>";
        echo "<script type='text/javascript'>window.location.href = '../cotizar.php?id_conversacion={$conversacion_id}&producto_id={$producto_id}&id_usuario1={$remitente}&id_usuario2={$destinatario}';</script>";
    } else {
        echo "Error al enviar el mensaje.";
    }
} else {
    echo "Método no permitido.";
}
?>

