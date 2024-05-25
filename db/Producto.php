<?php
include_once 'consulta.php';
session_start();
// Función para convertir video a base64
function videoToBase64($videoPath)
{
    // Verificar si el archivo existe
    if (!file_exists($videoPath)) {
        return null;
    }

    // Obtener el tipo MIME del video
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $videoMimeType = finfo_file($finfo, $videoPath);
    finfo_close($finfo);
    // Verificar si el archivo es un video
    if (strpos($videoMimeType, 'video') !== false) {
        // Leer el contenido del video y codificarlo en base64
        $videoContent = file_get_contents($videoPath);
        $videoBase64 = base64_encode($videoContent);
        return $videoBase64;
    }

    return null;
}




function registrarProducto($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto = null, $medidasProducto = null) {
    $consulta = new consulta();
    $user_id = $_SESSION['user_id'];

    // Lógica para convertir la imagen a base64 (puedes ajustar según sea necesario)
    $imagen_temporal = $_FILES["imagenesPro"]["tmp_name"];
    $tipo_imagen = $_FILES["imagenesPro"]["type"];

    if (exif_imagetype($imagen_temporal)) {
        $imagen_base64 = base64_encode(file_get_contents($imagen_temporal));
    } else {
        echo "<script type='text/javascript'>alert('El archivo seleccionado no es una imagen válida.');</script>";
        exit();
    }

    // Lógica para convertir el video a base64 (puedes ajustar según sea necesario)
    $videoPath = $_FILES['videoPro']['tmp_name'];
    $videoBase64 = videoToBase64($videoPath);

    if ($videoBase64 !== null) {
        $consulta->registrarProducto($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $user_id, $materialProducto, $medidasProducto);
        echo "<script type='text/javascript'>alert('Producto registrado exitosamente.');</script>";
        echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('El archivo seleccionado no es un video válido.');</script>";
    }
}

function registrarProductoCotizable($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto) {
    $consulta = new consulta();
    $user_id = $_SESSION['user_id'];

    // Lógica para convertir la imagen a base64 (puedes ajustar según sea necesario)
    $imagen_temporal = $_FILES["imagenesPro"]["tmp_name"];
    $tipo_imagen = $_FILES["imagenesPro"]["type"];

    if (exif_imagetype($imagen_temporal)) {
        $imagen_base64 = base64_encode(file_get_contents($imagen_temporal));
    } else {
        echo "<script type='text/javascript'>alert('El archivo seleccionado no es una imagen válida.');</script>";
        exit();
    }

    // Lógica para convertir el video a base64 (puedes ajustar según sea necesario)
    $videoPath = $_FILES['videoPro']['tmp_name'];
    $videoBase64 = videoToBase64($videoPath);

    if ($videoBase64 !== null) {
        $consulta->registrarProductoCotizable($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto, $user_id);
        echo "<script type='text/javascript'>alert('Producto registrado exitosamente.');</script>";
        echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('El archivo seleccionado no es un video válido.');</script>";
    }
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RegisterProd'])) {
    $nombreProducto = $_POST['nombrePro'];
    $descripcionProducto = $_POST['descripcionPro'];
    $tipo = $_POST['tipo'];
    $categoriaProducto = $_POST['categoria'];
    $precioProducto = $_POST['precioPro'];
    $cantidadProducto = $_POST['cantidadPro'];
    $materialProducto = ($_POST['tipo'] == 1) ? $_POST['materialCot'] : null;
    $medidasProducto = ($_POST['tipo'] == 1) ? $_POST['medidasCot'] : null;

    // Validaciones de los datos ingresados
    if (empty($nombreProducto) || empty($descripcionProducto) || empty($tipo) || empty($categoriaProducto) || empty($precioProducto) || empty($cantidadProducto)) {
        echo "<script type='text/javascript'>alert('Por favor, completa todos los campos.');</script>";
    } else {
        if ($tipo == 1) {
            registrarProductoCotizable($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto);
        } else {
            registrarProducto($tipo, $nombreProducto, $descripcionProducto, $precioProducto, $cantidadProducto, $categoriaProducto, $videoBase64, $imagen_base64, $materialProducto, $medidasProducto);
        }
    }
}












/*
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['RegisterProd'])) {

        $nombreProducto = $_POST['nombrePro'];
        $descripcionProducto = $_POST['descripcionPro'];
        $tipo = $_POST['tipo'];
        $categoriapro = $_POST['categoria'];
        $preciopro = $_POST['precioPro'];
        $cantidadpro = $_POST['cantidadPro'];
        $user_id = $_SESSION['user_id']; 
    


        // Validaciones de los datos ingresados
        if (empty($nombreProducto) || empty($descripcionProducto) || empty($tipo) || empty($categoriapro) || empty($preciopro) || empty($cantidadpro)) {
            echo "<script type='text/javascript'>alert('Por favor, completa todos los campos.');</script>";
        } else {
            // Procede a insertar el producto en la base de datos
            $consulta = new consulta();

            // Obtén la ruta del archivo temporal del video desde $_FILES
            $videoPath = $_FILES['videoPro']['tmp_name'];

            // Llama a la función para convertir el video a base64
            $videoBase64 = videoToBase64($videoPath);     
            if ($videoBase64 !== null) {    
                // Lógica para convertir la imagen a base64
                if (isset($_FILES["imagenesPro"]) && $_FILES["imagenesPro"]["error"] == 0) {
                    $imagen_temporal = $_FILES["imagenesPro"]["tmp_name"];
                    $tipo_imagen = $_FILES["imagenesPro"]["type"];
                    // Verificar si es una imagen
                    if (exif_imagetype($imagen_temporal)) {
                        $imagen_base64 = base64_encode(file_get_contents($imagen_temporal));
                    } else {
                        echo "<script type='text/javascript'>alert('El archivo seleccionado no es una imagen válida.');</script>";
                        
                        exit();
                    }
                } else {
                    echo "<script type='text/javascript'>alert('Seleccione un archivo para subir.');</script>";
                    exit();
                }


            } else {
                echo "<script type='text/javascript'>alert('El archivo seleccionado no es un video válido.');</script>";
            }
            // Llama a la función con las rutas de los archivos y la imagen en base64
            $consulta->registrarProducto($tipo, $nombreProducto, $descripcionProducto, $preciopro, $cantidadpro, $categoriapro, $videoBase64, $imagen_base64, $user_id);
            echo "<script type='text/javascript'>alert('Producto registrado exitosamente.');</script>";
            echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
        }
    }
}
*/








?>
