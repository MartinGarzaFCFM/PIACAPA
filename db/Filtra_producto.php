<?php
session_start();
include_once 'consulta.php';

// Validar la sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}


$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : null;

// Obtener el ID de usuario de la sesión
$user_id = $_SESSION['user_id'];


// Crear una instancia de la clase consulta
$resultadosConsulta = new consulta();


// Llamar al método ConsultarProductosVendedor de la instancia
try {
    // Agrega un mensaje de registro antes de la consulta
    error_log("Antes de la consulta:  categoria = $categoria");

    if (!empty($categoria)) {
        // Si se proporciona una categoría, realizar la consulta con categoría
        $resultados = $resultadosConsulta->ConsultarProductosVendedor($categoria, $user_id);
    } else {
        // Si no se proporciona una categoría, realizar la consulta sin categoría
        $resultados = $resultadosConsulta->ConsultarProductosVendedor(null, $user_id);
    }
   
    // Agrega un mensaje de registro después de la consulta
    error_log("Después de la consulta: resultados = " . print_r($resultados, true));

    // Imprimir los resultados en formato HTML
    if (!empty($resultados)) {
        foreach ($resultados as $resultado) {
            echo "<tr>";
            echo "<td>{$resultado['Nombre del Producto']}</td>";
            echo "<td>{$resultado['Categoría']}</td>";
            echo "<td>{$resultado['Existencia Disponible']}</td>";
            echo "<td>{$resultado['Precio Total']}</td>";
            
           
            
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No se encontraron resultados.</td></tr>";
    }
} catch (Exception $e) {
    echo "Error al realizar la consulta: " . $e->getMessage();
    // Agrega un mensaje de registro en caso de error
    error_log("Error al realizar la consulta: " . $e->getMessage());
}
?>