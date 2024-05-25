<?php
include_once 'consulta.php';

// Verifica si se proporcionaron categorías en la solicitud GET
if (isset($_GET['categorias'])) {
    // $_GET['categorias'] debe ser un array con los identificadores de categoría
    $categorias = $_GET['categorias'];

    // Instancia la clase de consulta
    $consulta = new consulta();

    // Crea un array para almacenar los productos de todas las categorías
    $productosTotales = array();

    // Recorre cada categoría y obtén los productos
    foreach ($categorias as $categoriaId) {
        // Utiliza consultas preparadas para evitar la inyección de SQL
        $productos = $consulta->obtenerProductosPorCategoriaVista($categoriaId);

        // Agrega los productos al array general
        $productosTotales[] = $productos;
    }

    // Devuelve los productos de todas las categorías en formato JSON
    echo json_encode($productosTotales);
} else {
    // No se proporcionaron categorías, manejar el error apropiadamente
    echo json_encode(['error' => 'No se proporcionaron categorías.']);
}
?>
