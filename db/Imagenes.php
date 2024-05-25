<?php
//No sirvió :(
if (isset($_FILES['imagenesPro'])) {
    $uploadDirectory = 'dbo/Imagenes/'; // Ruta donde deseas guardar las imágenes

    // Recorre los archivos cargados
    foreach ($_FILES['imagenesPro']['tmp_name'] as $key => $tmp_name) {
        $imageFileName = $_FILES['imagenesPro']['name'][$key];
        $imageFileTmp = $_FILES['imagenesPro']['tmp_name'][$key];

        // Genera un nombre de archivo único
        $uniqueFileName = uniqid() . '_' . $imageFileName;

        // Mueve el archivo al directorio de almacenamiento
        if (move_uploaded_file($imageFileTmp, $uploadDirectory . $uniqueFileName)) {
            // La imagen se ha cargado correctamente, ahora puedes almacenar la ruta en la base de datos
            $imagePath = $uploadDirectory . $uniqueFileName;
        } else {
            echo "Error al cargar la imagen: $imageFileName";
        }
    }
}
?>
