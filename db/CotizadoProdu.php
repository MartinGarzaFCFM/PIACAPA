<?php
include_once 'consulta.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sendProductInfo'])) {
        $consulta = new consulta();

        $producto_id = isset($_POST['producto_id']) ? $_POST['producto_id'] : null;
        $vendedor_id = isset($_POST['vendedor_id']) ? $_POST['vendedor_id'] : null;
        $cliente_id = isset($_POST['cliente_id']) ? $_POST['cliente_id'] : null;
        $id_pro = isset($_POST['ID_PRO']) ? $_POST['ID_PRO'] : null;
        $medida = isset($_POST['productMeasure']) ? $_POST['productMeasure'] : null;
        $material = isset($_POST['productMaterials']) ? $_POST['productMaterials'] : null;
        $precio = isset($_POST['productPRECIO']) ? $_POST['productPRECIO'] : null;
        $cantidad = isset($_POST['productCANTIDAD']) ? $_POST['productCANTIDAD'] : null;

        // Validaciones de los datos ingresados
        if (empty($id_pro) || empty($medida) || empty($material) || empty($precio) || empty($cantidad)) {
            echo "<script type='text/javascript'>alert('Por favor, completa todos los campos.');</script>";
        } else {
            // Llama a la función con los valores necesarios
            $consulta->RegistrarAltaCotizacion($producto_id, $vendedor_id, $cliente_id, $precio, $material, $medida, $cantidad);

            echo "<script type='text/javascript'>alert('Producto registrado exitosamente.');</script>";
              // Redirige a CotizarVendedor.php
                // Establece la variable de sesión indicando que el producto ha sido registrado
                $_SESSION['producto_registrado'] = true;

                // Establece la variable de sesión indicando que se hizo clic en sendProductInfo
                $_SESSION['send_product_info_clicked'] = true;
           
              echo "<script type='text/javascript'>window.location.href = '../CotizarVendedor.php';</script>";
              //$user_rol = isset($_SESSION['user_rol']) ? $_SESSION['user_rol'] : null;

              // Genera el enlace según el rol
             // if ($user_rol == '1') {
             //     $enlace = '../carrito.php';
            //  } elseif ($user_rol == '2') {
            //      $enlace = '../CotizarVendedor.php';
            //  } else {
                  // Manejar otros roles si es necesario
             // }
 
// Muestra el enlace en una alerta para depurar
//echo "<script type='text/javascript'>alert('Enlace generado: " . $enlace . "');</script>";

// Redirige al usuario al enlace correspondiente
//echo "<script type='text/javascript'>window.location.href = '$enlace';</script>";
              
        }
    }
}
?>