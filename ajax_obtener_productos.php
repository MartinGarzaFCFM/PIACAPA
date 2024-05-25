
<?php
include_once 'consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerproducto')) {
        $PRODUCTO = $consultas->obtenerproducto();
        echo json_encode($PRODUCTO);
    } else {
        echo "El método 'obtenerproducto' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}

?>
