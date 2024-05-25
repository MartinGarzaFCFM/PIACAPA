<?php
session_start();
include_once 'consulta.php';

// Validar la sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

// Validar y obtener parámetros del formulario
$fechaInicio = isset($_POST["fechaInicio"]) ? $_POST["fechaInicio"] : null;
$fechaFin = isset($_POST["fechaFin"]) ? $_POST["fechaFin"] : null;
$categoria = isset($_POST["categoria"]) ? $_POST["categoria"] : null;

// Obtener el ID de usuario de la sesión
$user_id = $_SESSION['user_id'];

// Validar la existencia de parámetros obligatorios
if ($fechaInicio === null || $fechaFin === null) {
    echo "Error: Debes proporcionar fechas de inicio y fin.";
    exit();
}

// Crear una instancia de la clase consulta
$resultadosConsulta = new consulta();

// Llamar al método ConsultarCompras de la instancia
try {
    if (!empty($categoria)) {
        // Si se proporciona una categoría, realizar la consulta con categoría
        $resultados = $resultadosConsulta->ConsultarCompras($fechaInicio, $fechaFin, $categoria, $user_id);
    } else {
        // Si no se proporciona una categoría, realizar la consulta sin categoría
        $resultados = $resultadosConsulta->ConsultarCompras($fechaInicio, $fechaFin, null, $user_id);
    }

    // Imprimir los resultados en formato HTML
    if (!empty($resultados)) {
        foreach ($resultados as $resultado) {
            echo "<tr>";
            echo "<td>{$resultado['Fecha y Hora de Compra']}</td>";
            echo "<td>{$resultado['Categoría']}</td>";
            echo "<td>{$resultado['Producto']}</td>";
            echo "<td>{$resultado['precio']}</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No se encontraron resultados.</td></tr>";
    }
} catch (Exception $e) {
    echo "Error al realizar la consulta: " . $e->getMessage();
}
?>