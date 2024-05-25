<?php
session_start();
include_once 'db/consulta.php';

$consulta = new consulta();

if (isset($_SESSION['usuario']['id'])) {
    $usuarioID = $_SESSION['usuario']['id'];

    $productosPendientes = $consulta->ProductosPendientesAprobacion($usuarioID);

   
/*

    // Imprimir información de depuración
    echo '<div class="container mt-4">';
    echo '<h2>Productos Pendientes de Aprobación</h2>';
    echo '<div class="card">';
    echo '<div class="card-body">';
    echo '<!-- Listado de productos pendientes de aprobación -->';
    echo '<div class="row">';*/

    foreach ($productosPendientes as $producto) {
        /*
        echo '<div class="col-md-4">';
        echo '<div class="product-card">';
        echo '<h4>' . $producto['PRO_NOMBRE'] . '</h4>';
        echo '<p>' . $producto['PRO_DESCRIPCION'] . '</p>';
        echo '<p>' . $producto['id_usuario'] . '</p>';
        echo '<button onclick="window.location.href = \'DetallesDelProducto.php?id=' . $producto['ID_COTI'] . '\'" class="btn btn-primary">Ver Detalles</button>';
        echo '<button class="btn btn-success" id="Aprobar">Aprobar</button>';
        echo '<button class="btn btn-danger" id="Rechazar">Rechazar</button>';
        echo '</div>';
        echo '</div>';*/
    }
/*



    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';*/
} else {
    echo "Usuario no autenticado.";

}
?>






<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos Administrador</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="ProductoAdminis.css">
</head>
<body>

<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="Home.php">
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

            </div>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <h2>Productos Pendientes de Aprobación</h2>
    <div class="card mb-4" style="background-color: #d8d9da;">
        <div class="card-body">
            <!-- Listado de productos pendientes de aprobación -->
            <div class="row">
                <?php foreach ($productosPendientes as $producto) : ?>
                    <div class="col-md-4">
                        <div class="product-card d-flex flex-column align-items-center p-3">
                            <!-- Muestra la imagen si existe en el array $producto -->
                            <?php if (isset($producto['Imagen'])) : ?>
                                <img src="data:image/jpeg;base64,<?= $producto['Imagen']; ?>" class="tamaño mb-3" style="max-width: 200px;">
                            <?php endif; ?>
                            <div class="text-center">
                                <p class="mb-2">Producto: <?= $producto['PRO_NOMBRE']; ?></p>
                                <p class="mb-2">Descripción del producto: <?= $producto['PRO_DESCRIPCION']; ?></p>
                                <p>Usuario que manda esta petición: <?= $producto['Usuario']; ?></p>
                                <!-- Botón para abrir el modal -->
                                <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#detallesProductoModal<?= $producto['ID_COTI']; ?>">
                                    Ver Detalles
                                </button>
                                
                         
                             
                                <button class="btn btn-success mb-2 btn-aprobar" data-id="<?= $producto['ID_COTI']; ?>">Aprobar</button>

                                <button class="btn btn-danger btn-rechazar" data-id="<?= $producto['ID_COTI']; ?>">Rechazar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Modal para mostrar detalles del producto -->
                    <div class="modal fade" id="detallesProductoModal<?= $producto['ID_COTI']; ?>" tabindex="-1" role="dialog" aria-labelledby="detallesProductoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <!-- Contenido del modal... -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detallesProductoModalLabel">Detalles del Producto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php if (isset($producto['Imagen'])) : ?>
                                        <img src="data:image/jpeg;base64,<?= $producto['Imagen']; ?>" class="tamaño mb-3" style="max-width: 200px;">
                                    <?php endif; ?>
                                    <video width="100%" height="auto" controls>
    <source type="video/mp4" src="data:video/mp4;base64,<?= $producto['Video']; ?>" class="tamaño mb-3" style="max-width: 200px;">
</video>

                                    <p class="mb-2">Producto: <?= $producto['PRO_NOMBRE']; ?></p>
                                    <p class="mb-2">Descripcion: <?= $producto['PRO_DESCRIPCION']; ?></p>
                                    <p class="mb-2">Categoria: <?= $producto['PRO_CATEGORIA']; ?></p>
                                    <p class="mb-2">
    Tipo: 
    <?php 
    if ($producto['PRO_TIPO'] == 1) {
        echo 'Cotizable';
    } elseif ($producto['PRO_TIPO'] == 2) {
        echo 'Vender';
    } else {
        echo 'Tipo desconocido'; // Puedes manejar otros valores de PRO_TIPO según sea necesario
    }
    ?>
</p>
                                    <!--<p class="mb-2">Tipo: 1 Cotizable Tipo 2 Vender <= $producto['PRO_TIPO']; ?></p>-->
                                    <p class="mb-2">Precio: <?= $producto['PRO_PRECIOTOTAL']; ?></p>
                                    <p class="mb-2">Cantidad: <?= $producto['PRO_CANTIDAD']; ?></p>
                                    <p>Usuario que manda esta petición: <?= $producto['Usuario']; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>






<!-- 
<div class="container mt-4">
    <h2>Productos Pendientes de Aprobación</h2>
    <div class="card">
        <div class="card-body">
           
            <div class="row">
                <div class="col-md-4">
                    <div class="product-card">
                    <p>Producto: $producto['PRO_NOMBRE']; ?></p>
                    <img src="data:image/jpeg;base64,$producto.['Imagen'];?>'" alt="Imagen del producto" class="tamaño">
                        <p>Descripción del producto  $producto['PRO_DESCRIPCION']; ?></p>

                        <p>Usuario que manda esta peticion   $producto['Usuario']; ?></p>
                        <button onclick="window.location.href = 'DetallesDelProducto.php?id= $producto['ID_COTI']; ?>'" class="btn btn-primary">Ver Detalles</button>
                        <button class="btn btn-success" id="Aprobar">Aprobar</button>
                     <button class="btn btn-danger" id="Rechazar">Rechazar</button>
                    </div>
                </div>
                          
               
            </div>
        </div>
    </div>
</div>-->
<script src="ProductoAminis.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="ProductoAminis.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</body>
</html>