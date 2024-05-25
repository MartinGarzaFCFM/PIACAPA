

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: ./db/Login.php");
    exit();
} // codigo recien colocadoo 19-10-2023

// Una vez que el usuario ha iniciado sesión, puedes acceder a su ID
$user_id = $_SESSION['user_id'];
$user_rol = $_SESSION['user_rol'];
$user_priv = $_SESSION['user_priv'];
// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";
echo "Tu rol es: $user_rol";
echo "Tu nivel de privacidad es: $user_priv";



?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="index.css">
</head>
<body>





<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="logo_minimarket.png" alt="Logo" width="40" height="40">
        </a>
        <div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categorías
    </a>
    <div class="dropdown-menu" aria-labelledby="categoryDropdown" data-toggle="manual-dropdown" id="categoryMenu">
        <!-- Categorías se cargarán aquí -->
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    if (typeof jQuery === 'undefined') {
        console.error('jQuery no se ha cargado correctamente');
    } else {
        console.log('jQuery está cargado correctamente');
    }
</script>

<script>
    
function buscarProductos() {
    var busqueda = $('#searchQuery').val();

    $.ajax({
        url: 'db/buscar_productos.php',
        method: 'POST',
        data: { busqueda: busqueda },
        success: function(response) {
            console.log(response);

            var productos = JSON.parse(response);

            var productosContainer = $('.productos-container');

            productosContainer.empty();

            if (productos.length > 0) {
                // Mostrar resultados
                productos.forEach(function(producto) {
                    var productoHTML = `
                        <div class="card">
                            <div class="producto">
                                <img src="data:image/jpeg;base64, ${producto.Imagen}" alt="Imagen del producto" class="tamaño">
                                <div class="card-body">
                                    <h5 class="card-title">${producto.PRO_NOMBRE}</h5>
                                    <p class="card-text">${producto.PRO_DESCRIPCION}</p>
                                    ${producto.PRO_TIPO !== '1' ? `<p>Precio: $${producto.PRO_PRECIOTOTAL}</p>` : ''}
                                    <a href="DetalleProductoComprar.php?productoID=${producto.ID_PRO}" class="btn btn-primary">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    `;

                    productosContainer.append(productoHTML);
                });
            } else {
                // Mostrar mensaje de aviso y cargar el contenido predeterminado
                alert('No se encontraron resultados.');
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}
</script>


<script>
$.ajax({
    url: 'db/cargar_categorias.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
        console.log(data);  // Agrega esta línea para depurar

        var categoryMenu = $('#categoryMenu');

        // Recorrer las categorías y crear elementos de lista antes era categoryName
        data.forEach(function(category) {
            console.log(category);  // Agrega esta línea para depurar

            // Accede a las propiedades correctas del objeto
            var categoryId = category.CAT_ID;
            var categoryName = category.CAT_NOMBRE;

            var categoryLink = $('<a class="dropdown-item" href="objetos.php?categoriaId=' + categoryId + '">' + categoryName + '</a>');
            console.log('ID: ' + categoryId + ', Nombre: ' + categoryName);

            // Adjuntar el elemento de lista al menú de categorías
            categoryMenu.append(categoryLink);
        });
    }
});



</script>
<form class="form-inline" id="searchForm">
    <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="searchQuery" id="searchQuery">
    <button class="btn btn-outline-light my-2 my-sm-0" type="button" onclick="buscarProductos()">Buscar</button>
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
                 </div>


             </div>
             

    </div>

</nav>

  


<!-- Sección de productos más vendidos -->
<section class="products-section">
    <div class="container">
        <h2 class="titulo">Productos más vendidos</h2>
        <div class="row">
        <div class="col-lg-11 col-md-8 col-sm-10 mb-5">
                <div class="productos-container" id="productosContainer1"></div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de productos recomendados -->
<section class="products-section bg-light">
    <div class="container">
    <h2 class="titulo">Productos recomendados</h2>
        <div class="row">
        <div class="col-lg-11 col-md-8 col-sm-10 mb-5">
                <div id="productosContainer2" class="productos-container"></div>         
            </div>
        </div>  
    </div>
</section>

<!-- Sección de productos populares -->
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

<script>
// Realiza una solicitud AJAX para obtener los productos
$.ajax({
    url: 'db/View_Productos.php',
    method: 'GET',
    dataType: 'json',
    success: function(data) {
        // data contiene los productos como un arreglo de objetos

        // Obtén la referencia del contenedor de productos
        var productosContainer = $('.productos-container');

        // Recorre los productos y crea elementos HTML para mostrarlos en la página <a href="DetalleProductoComprar.php?productoID=${index + 1}" class="btn btn-primary">Ver detalles</a>
        data.forEach(function(producto) {
            console.log('Tipo de producto:', producto.PRO_APROBADO);  
          // Verifica producto es de tipo cotizado
       
       if (producto.PRO_APROBADO !== '1') { 
                       //Para ver la imagen:
            var productoHTML = `
            <div class="card">
                <div class="producto">
                
                    <img src="data:image/jpeg;base64, ${producto.Imagen}" alt="Imagen del producto" class="tamaño"">
                    <div class="card-body">
                        <h5 class="card-title">${producto.PRO_NOMBRE}</h5>
                        <p class="card-text">${producto.PRO_DESCRIPCION}</p>
                       
                        ${producto.PRO_TIPO !== '1' ? `<p>Precio: $${producto.PRO_PRECIOTOTAL}</p>` : ''}
                   
                        <a href="DetalleProductoComprar.php?productoID=${producto.ID_PRO}" class="btn btn-primary">Ver detalles</a>
                   
                        </div>
                </div>
           
             </div>
            `;
           /*   
                    //Si quieres mostrar el video descomenta esto
            var productoHTML = `
            <div class="card">
                <div class="producto">
                
                    <video width="100%" height="auto" controls>
                    <source type="video/mp4" src="data:video/mp4;base64, ${producto.Video}">
                    </video>
                                //esas 3 lineas de arriba son las que cambian, lo de abajo es lo mismo

                    <div class="card-body">
                        <h5 class="card-title">${producto.PRO_NOMBRE}</h5>
                        <p class="card-text">${producto.PRO_DESCRIPCION}</p>
                        <p>Precio: $${producto.PRO_PRECIOTOTAL}</p>
                        <a href="DetalleProductoComprar.php" class="btn btn-primary">Ver detalles</a>
                    </div>
                </div>
           
             </div>
            `;*/
            // Agrega el elemento de producto al contenedor de productos
            productosContainer.append(productoHTML);
           }
        });
    }
});
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  


</script>

<script>

</script>
</body>
</html>
