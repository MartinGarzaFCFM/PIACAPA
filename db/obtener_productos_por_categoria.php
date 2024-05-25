<?php
include_once 'consulta.php';

if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];

    if (class_exists('consulta')) {
        $consultas = new consulta();

        if (method_exists($consultas, 'obtenerProductosPorCategoria')) {
            $productos = $consultas->obtenerProductosPorCategoria($categoria);
            echo json_encode($productos);
        } else {
            echo "El método 'obtenerProductosPorCategoria' no está definido en la clase 'consulta'.";
        }
    } else {
        echo "La clase 'consulta' no está definida.";
    }
} else {
    echo "Falta el parámetro 'categoria' en la solicitud.";
}
?>
public function obtenerProductosPorCategoria($categoria) {
    $query = $this->connect()->prepare('SELECT PRO_NOMBRE, PRO_DESCRIPCION, PRO_PRECIOTOTAL, ip.Imagen
                                       FROM PRODUCTO AS p
                                       LEFT JOIN ImagenProducto AS ip ON p.ID_PRO = ip.FKProducto
                                       WHERE PRO_CATEGORIA = :categoria');
    $query->execute([':categoria' => $categoria]);
    $productos = $query->fetchAll(PDO::FETCH_ASSOC); // Obtén los productos como un arreglo asociativo
    return $productos;
}
