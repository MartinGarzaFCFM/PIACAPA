<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ./db/Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Categorias</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="Lista.css">
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
<div class="container mt-5">
<div class="row">
        <div class="col-md-4 offset-md-2">
            <h2>Categorias</h2>
            
            <ul class="list-group" id="miscategorias">
           <!-- Ejemplo de lista -->
           <li class="list-group-item d-flex justify-content-between align-items-center">
        </li>
        <!-- Agregar más listas aquí -->
    </ul>
    
</div>

<script>
function showListDetails(catId) {
    console.log('In showListDetails function');
    console.log('Categoria ID:', catId); 
    
    $.ajax({
        url: 'db/obtenerinfo_Cat.php',
        method: 'GET',
        data: { CAT_ID: catId },  
        dataType: 'json',
        success: function (infoCat) {
            console.log('List details successfully displayed for Lista ID:', catId);
            console.log(infoCat);
            if (infoCat.CAT_NOMBRE) {
                console.log('nombrecat:', infoCat.CAT_NOMBRE);
            }
            if (infoCat.CAT_DESC) {
                console.log('descripcioncat:', infoCat.CAT_DESC);
            }

            
            $('#nombrecat').val(infoCat.CAT_NOMBRE);
            $('#descripcioncat').val(infoCat.CAT_DESC);
            $('#idCategoriaModificar').val(catId);

            $('#listaCat').collapse('show');
            $('#formlistaCat').show();
            $('#clickedcatId').text('Clicked Categoria-item with ID: ' + catId);
},

        error: function (xhr, status, error) {
            console.error('Error obtaining list information:');
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
        }

       
    });
}

   $(document).ready(function () {
    $.ajax({
        url: 'db/Cargar_Cat.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var CatContainer = $('#miscategorias');
            if (Array.isArray(data)) {
                data.forEach(function (Categoria) {
                    var CategoriaHTML = `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#" class="Categoria-item" data-id="${Categoria.CAT_ID}">${Categoria.CAT_NOMBRE}</a>
                        </li>
                    `;
                    var listItem = $(CategoriaHTML).appendTo(CatContainer);
                    listItem.find('.Categoria-item').click(function (event) {
                        event.preventDefault();
                        var catId = $(this).data('id');
                        console.log('List item clicked with ID:', catId);
                        showListDetails(catId);
                    });
                });
            } else {
                console.error('La respuesta JSON no es un array:', data);
            }
            console.log(data);
        },
        error: function (xhr, status, error) {
            console.error('Error obtaining list names:');
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
        }
    });

    $('form').submit(function (event) {
        event.preventDefault();
        console.log('Form submitted!');
    });

    function cargarContenidoProd(catId) {
        $.ajax({
            url: 'db/Info_Cat.php',
            method: 'GET',
            data: { catId: catId },
            dataType: 'json',
            success: function (Categoria) {
                $('#contenidoCategoria').empty();

                var CategoriaHTML = `
                            <h5 class="card-title">${Categoria.CAT_NOMBRE}</h5>
                            <p class="card-text">${Categoria.PRO_DESCRIPCION}</p>
                            <!-- Agrega más detalles del Categoria según sea necesario -->
                        </div>
                    </div>
                `;

                $('#contenidoCategoria').append(CategoriaHTML);
            },
            error: function (error) {
                console.error('Error obteniendo Categoria de la lista:', error);
            }
        });
    }

    $('#miscategorias').on('click', '.list-group-item', function (event) {
        event.preventDefault();
        var catId = $(this).data('id');
        console.log('List item clicked with ID:', catId);
        showListDetails(catId);
    });
}); 
</script>

<div >
<div class="col-md-12 ml-auto">
    <div  id="listaCat">
        <h3>Categorias</h3>
        <form>
            <div class="form-group" id="formlistaCat">
                    <label for="nombrecat">Nombre del categoria</label>
                    <input type="text" class="form-control" id="nombrecat" name="nombrecat" placeholder="Nombre de la categoria">
                </div>
                <div class="form-group">
                    <label for="descripcioncat">Descripción del categoria</label>
                    <textarea class="form-control" id="descripcioncat" name="descripcioncat" rows="3" placeholder="Descripción de la categoria"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    
             <input type="hidden" id="idCategoriaModificar" name="idCategoriaModificar">
             <button type="submit" class="btn btn-secundary ml-5" id="Regresar">Regresar</button>
                <button type="submit" class="btn btn-primary mr-2" id="Modificar">Modificar</button>
                <button type="submit" class="btn btn-danger" id="Eliminar">Eliminar</button>
              
            </div>
            
        </form>
    </div>
</div>
</div>
<script> document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault();
    
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="Categoria.js"></script>
<script src="MostrarCotizables.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>
</html>