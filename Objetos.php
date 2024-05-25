<?php
 // //if (isset($_GET['categorias'])) {
    // $categoriaSeleccionada = $_GET['categorias'];

    // Aquí debes conectar a la base de datos y ejecutar una consulta para obtener los productos de la categoría seleccionada
    // ...

    // Luego, puedes mostrar los productos en esta página
    // ...
 //}

 

session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: ./db/Login.php");
    exit();
} // codigo recien colocadoo 19-10-2023

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Electronica</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="index.css">
</head>
<body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
        var categoriaIdSeleccionada = <?php echo json_encode($_GET['categoriaId']); ?>;

       
        console.log("ID de la categoría seleccionada:", categoriaIdSeleccionada);

            function cargarProductosPorCategoria(categoryId) {
                $.ajax({
                    url: 'db/cargar_productos_por_categoria.php?categoriaId=' + categoryId,
                    method: 'GET',
                    dataType: 'json',
                    data: { categorias: categoriaId },
                    success: function(data) {
                        console.log(data);
                        console.log("Datos obtenidos correctamente:", data);

                        var productosContainer = $('.productos-container');
                        productosContainer.empty();
                        console.log("Procesando producto:", producto);
                        // Recorrer los productos y crear elementos de lista
                        data.forEach(function(producto) {

                            var productHTML = `
                            <div class="card">
                            <div class="producto">
                            
                                <img src="data:image/jpeg;base64, ${producto.Imagen}" alt="Imagen del producto" class="tamaño">
                                <div class="card-body">
                                    <h5 class="card-title">${producto.PRO_NOMBRE}</h5>
                                    <p class="card-text">${producto.PRO_DESCRIPCION}</p>
                                    <p> Precio: $${producto.PRO_PRECIOTOTAL}</p>
                                    <a href="DetalleProductoComprar.php?productoID=${producto.ID_PRO}" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                                
             </div>

                            `;
                            console.log("Producto construido:", productHTML);

                            console.log("ID del producto:", producto.ID);

                            productosContainer.append(productHTML);
                        });
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
       
    </script>
<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand"  href="index.php">
            <img src="logo_minimarket.png" alt="Logo" width="40" height="40">
        </a>
     <!--   <div class="dropdown">
     <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categorías
    </a>-->
 <!--   <div class="dropdown-menu" aria-labelledby="categoryDropdown" data-toggle="manual-dropdown" id="categoryMenu">
       Categorías se cargarán aquí 
    </div> -->

    <?php
include_once 'db/consulta.php';

if (class_exists('consulta')) {
    $consultas = new consulta();

    if (method_exists($consultas, 'obtenerCategorias')) {
        $categorias = $consultas->obtenerCategorias();

        echo '<div class="dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        echo 'Categorías';
        echo '</a>';
        echo '<div class="dropdown-menu" aria-labelledby="categoryDropdown" data-toggle="manual-dropdown" id="categoryMenu">';

        // Bucle foreach para generar los elementos de lista de categorías  echo '<a class="dropdown-item" href=""objetos.php?categoriaId" data-category-id="' . $categoria['CAT_ID'] . '">' . $categoria['CAT_NOMBRE'] . '</a>';
        foreach ($categorias as $categoria) {
         
            echo '<a class="dropdown-item" href="objetos.php?categoriaId=' . $categoria['CAT_ID'] . '" data-category-id="' . $categoria['CAT_ID'] . '">' . $categoria['CAT_NOMBRE'] . '</a>';
       
        }
        
        echo '</div>';
        echo '</div>';
    } else {
        echo "El método 'obtenerCategorias' no está definido en la clase 'consulta'.";
    }
} else {
    echo "La clase 'consulta' no está definida.";
}
?>


    
</div>
<form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Buscar</button>
        </form>
        <div class="ml-auto">
            <div class="btn-group">
                 <!-- Botón del carrito -->
                 <a href="carrito.php" class="btn btn-outline-light">
                    <i class="fas fa-shopping-cart"></i> Carrito
                </a>
                 <!-- Botón para Mi Cuenta -->
                <button type="button" class="btn btn-outline-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mi cuenta
                </button>
<div class="dropdown-menu dropdown-menu-right">
    <?php
   
    
//si da error en los otros .php en el menu es porque solo una vez se debe usar el session start
    // $rolUsuario obtiene el rol del usuario actual (0 para 'Cliente' y 1 para 'Vendedor' y 2 "administrador")
    // Obtener el rol del usuario desde la sesión
    $userRol = isset($_SESSION['user_rol']) ? $_SESSION['user_rol'] : null;
    
    if ($userRol == 1) {
        // Usuario con rol 'Cliente'
        echo '<a class="dropdown-item" href="Lista.php">Mi lista</a>';
        echo '<a class="dropdown-item" href="CrearLista.php">Crear lista</a>';
        echo '<a class="dropdown-item" href="perfil.php">Mi perfil</a>';
        echo '<a class="dropdown-item" href="PedidosRealizados.php">Pedidos</a>';
    } elseif ($userRol == 2) {
        // Usuario con rol 'Vendedor'
        echo '<a class="dropdown-item" href="Lista.php">Mi lista</a>';
        echo '<a class="dropdown-item" href="CrearLista.php">Crear lista</a>';
        echo '<a class="dropdown-item" href="perfil.php">Mi perfil</a>';
        echo '<a class="dropdown-item" href="ProductoVendedor.php">Productos</a>';
        echo '<a class="dropdown-item" href="Venta.php">Consulta Venta</a>';
        echo '<a class="dropdown-item" href="CotizarVendedor.php">Conversaciones Cotizacion</a>';
    } elseif ($userRol == 3) {
        // Usuario con rol 'Administrador'
        echo '<a class="dropdown-item" href="Lista.php">Mi lista</a>';
        echo '<a class="dropdown-item" href="CrearLista.php">Crear lista</a>';
        echo '<a class="dropdown-item" href="perfil.php">Mi perfil</a>';
        echo '<a class="dropdown-item" href="ProductoAdminis.php">Administrar Productos</a>';
    }

   
    echo '<div class="dropdown-divider"></div>';
    echo '<a class="dropdown-item" href="Landpage.php">Cerrar sesión</a>';
    ?>
</div>

                <?php include 'menu.php'; ?>
                  
            </div>
        </div>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Sección de productos -->
<section class="products-section">
    <div class="container">
        <h2 class="titulo">Productos populares</h2>
        <div class="row"> 
        <div class="col-lg-11 col-md-8 col-sm-10 mb-5">
                <div id="productosContainer2" class="productos-container"></div>    
            </div> 
        </div>
    </div>
</section>

<?php
include_once 'db/consulta.php';
if (isset($_GET['categoriaId'])) {
    // Obtén el valor de la categoría desde la solicitud GET
    $categoriaId = $_GET['categoriaId'];

    // Instancia la clase consulta
    $consultas = new consulta();

   // Verifica si el método 'obtenerProductosPorCategoriaVista' existe en la clase 'consulta'
   if (method_exists($consultas, 'obtenerProductosPorCategoriaVista')) {
    // Llama al método para obtener productos por categoría
    $productos = $consultas->obtenerProductosPorCategoriaVista($categoriaId);

    // Ahora puedes hacer lo que quieras con la lista de productos obtenida
    // Por ejemplo, imprimir las tarjetas de productos
    echo '<div class="row">';
    foreach ($productos as $producto) {
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<img src="data:image/jpeg;base64, ' . $producto['Imagen'] . '" alt="Imagen del producto" class="tamaño">';
        echo '<h5 class="card-title">' . $producto['PRO_NOMBRE'] . '</h5>';
        echo '<p class="card-text">' . $producto['PRO_DESCRIPCION'] . '</p>';
        echo '<p>Precio: $' . $producto['PRO_PRECIOTOTAL'] . '</p>';
        echo '<a href="DetalleProductoComprar.php?productoID=' . $producto['ID_PRO'] . '" class="btn btn-primary">Ver detalles</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';

    echo '<script>';
    echo 'var categoriaIdSeleccionada = ' . json_encode($_GET['categoriaId']) . ';';
    echo '</script>';

} else {
    // Muestra un mensaje de error si el método no está definido en la clase
    echo "El método 'obtenerProductosPorCategoriaVista' no está definido en la clase 'consulta'.";
}
} else {
// Muestra un mensaje si no se proporcionó un valor de categoría en la solicitud GET
echo "No se proporcionó un valor de categoría en la solicitud GET.";
}
?>




  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
