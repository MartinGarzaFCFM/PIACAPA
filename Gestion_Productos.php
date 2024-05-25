<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si 'user_id' no está definido, redirige al inicio de sesión
    header("Location: Loginn.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gesion Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="Lista.css">
   
   
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




<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Mis productos</h2>
            
            <ul class="list-group" id="misproductos">
           <!-- Ejemplo de lista -->
           <li class="list-group-item d-flex justify-content-between align-items-center">
        </li>
        <!-- Agregar más listas aquí -->
    </ul>

    <script>
function showListDetails(ProdId) {
    console.log('In showListDetails function');
    console.log('Producto ID:', ProdId); // Add this line for debugging
    
    $.ajax({
        url: 'db/obtenerinfo_Prod.php',
        method: 'GET',
        data: { ID_PRO: ProdId },  // Cambia 'ID_LISTA' a 'ID_PRO'
        dataType: 'json',
        success: function (infoProd) {
            console.log('List details successfully displayed for Lista ID:', ProdId);
            console.log(infoProd);
            // Asegúrate de que las propiedades existan antes de acceder a ellas
            if (infoProd.PRO_NOMBRE) {
                console.log('NombrePro:', infoProd.PRO_NOMBRE);
            }
            if (infoProd.PRO_DESCRIPCION) {
                console.log('descripcionPro:', infoProd.PRO_DESCRIPCION);
            }
            if (infoProd.PRO_TIPO) {
                console.log('Tipo Lista:', infoProd.PRO_TIPO);
            }
            if (infoProd.PRO_PRECIOTOTAL) {
                console.log('precioPro:', infoProd.PRO_PRECIOTOTAL);
            }
            if (infoProd.PRO_CANTIDAD) {
                console.log('cantidadPro:', infoProd.PRO_CANTIDAD);
            }
            if (infoProd.PRO_CATEGORIA) {
                console.log('categoriaSelect:', infoProd.PRO_CATEGORIA);
            }
            if (infoProd.PRO_MATERIAL) {
                console.log('MaterialPro:', infoProd.PRO_MATERIAL);
            }
            if (infoProd.PRO_CATEGORIA) {
                console.log('medidasCot:', infoProd.PRO_MEDIDAS);
            }

            // ... Hacer lo mismo para otras propiedades

            // Actualizar directamente el contenido de los elementos HTML
            $('#nombrePro').val(infoProd.PRO_NOMBRE);
            $('#descripcionPro').val(infoProd.PRO_DESCRIPCION);
            $('#tipo').val(infoProd.PRO_TIPO);
            $('#categoriaSelect').val(infoProd.PRO_CATEGORIA);
            $('#precioPro').val(infoProd.PRO_PRECIOTOTAL);
            $('#cantidadPro').val(infoProd.PRO_CANTIDAD);
            $('#medidasCot').val(infoProd.PRO_MEDIDAS);
            $('#materialCot').val(infoProd.PRO_MATERIAL);
            $('#idProductoModificar').val(ProdId);

            // Mostrar la lista container
            $('#listaProd').collapse('show');
            $('#formlistaProd').show();
            $('#clickedProdId').text('Clicked Producto-item with ID: ' + ProdId);
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
    // Carga inicial de listas
    $.ajax({
        url: 'db/cargar_Productos.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var ProductoContainer = $('#misproductos');
            if (Array.isArray(data)) {
                data.forEach(function (Producto) {
                    var ProductoHTML = `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="#" class="Producto-item" data-id="${Producto.ID_PRO}">${Producto.PRO_NOMBRE}</a>
                        </li>
                    `;
                    var listItem = $(ProductoHTML).appendTo(ProductoContainer);
                    listItem.find('.Producto-item').click(function (event) {
                        event.preventDefault();
                        var ProdId = $(this).data('id');
                        console.log('List item clicked with ID:', ProdId);
                        showListDetails(ProdId);
                    });
                });
            } else {
                console.error('La respuesta JSON no es un array:', data);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error obtaining list names:');
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
        }
    });

    // Añade un evento de submit al formulario
    $('form').submit(function (event) {
        event.preventDefault();
        // Añade tu lógica de envío del formulario aquí
        console.log('Form submitted!');
        // También puedes realizar acciones adicionales después de enviar el formulario, si es necesario
    });

    // Función para cargar el contenido de la lista
    function cargarContenidoProd(idProd) {
        // Realiza una solicitud AJAX para obtener los productos de la lista
        $.ajax({
            url: 'db/Info_Prod.php',
            method: 'GET',
            data: { idProd: idProd },
            dataType: 'json',
            success: function (producto) {
                // Limpia la lista actual
                $('#contenidoProducto').empty();

                // Agrega la información del producto al contenedor
                var productoHTML = `
                    <div class="card">
                        <img src="data:image/jpeg;base64, ${producto.Imagen}" class="card-img-top" alt="Imagen del producto">
                        <div class="card-body">
                            <h5 class="card-title">${producto.PRO_NOMBRE}</h5>
                            <p class="card-text">${producto.PRO_DESCRIPCION}</p>
                            <p class="card-text">Precio: $${producto.PRO_PRECIOTOTAL}</p>
                            <p class="card-text">Cantidad: ${producto.PRO_CANTIDAD}</p>
                            <!-- Agrega más detalles del producto según sea necesario -->
                        </div>
                    </div>
                `;

                $('#contenidoProducto').append(productoHTML);
            },
            error: function (error) {
                console.error('Error obteniendo productos de la lista:', error);
            }
        });
    }

    // Añade un manejador de clic al contenedor de listas
    $('#misproductos').on('click', '.list-group-item', function (event) {
        event.preventDefault();
        var ProdId = $(this).data('id');
        console.log('List item clicked with ID:', ProdId);
        showListDetails(ProdId);
    });
});


</script>


</script>

</div>

        <div class="col-md-8">
            <div id="listaProd" >
                <h3>Producto</h3>
                <form>
                    <div class="form-group" id="formlistaProd">
                    <label for="tipo">Tipo de Producto</label>
                    <select class="form-control" id="tipo" name="tipo" oninput="mostrarCamposAdicionales()">
                        <option value="1">Cotizar</option>
                        <option value="2">Vender</option>
                    </select></div>
                    <div class="form-group">
                    <label for="nombrePro">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombrePro" name="nombrePro" placeholder="Nombre del producto">
                </div>
                <div class="form-group">
                    <label for="descripcionPro">Descripción del Producto</label>
                    <textarea class="form-control" id="descripcionPro" name="descripcionPro"rows="3" placeholder="Descripción del producto"></textarea>
                </div>
    
                <div class="form-group">
          <label for="categoriaSelect">Categoría (al menos una)</label>
          <select class="form-control" id="categoriaSelect" name="categoriaSelect">
        <option value="">Seleccione una categoría</option>
             </select>
             <div class="categoria">
          <span class="categoria">¿Quieres agregar una categoria?
           <a href='categoria.php' for="check">Agrega categoria</a>
        </div>
        <script>

            var xhr = new XMLHttpRequest();
                xhr.open("GET", "db/cargar_categorias.php", true);

                    xhr.onload = function () {
                    if (xhr.status === 200) {
                 var categorias = JSON.parse(xhr.responseText);

                 categorias.forEach(function (categoria) {
                 var option = document.createElement("option");
                 option.text = categoria;
                    categoriaSelect.add(option);
                     });
                }
                };

                xhr.send();



                </script>
            <div class="form-group">
                    <label for="precioPro">Precio</label>
                    <input type="number" class="form-control" id="precioPro" name="precioPro" placeholder="Precio del producto">
                </div>
                <div class="form-group">
                    <label for="cantidadPro">Cantidad Disponible</label>
                    <input type="number" class="form-control" id="cantidadPro" name="cantidadPro" placeholder="Cantidad disponible">
                </div>
                <div id="camposCotizables" style="display:none;">
    <div class="form-group">
        <label for="materialCot">Material</label>
        <input type="text" class="form-control" id="materialCot" name="materialCot" placeholder="Material del producto">
    </div>
    <div class="form-group">
        <label for="medidasCot">Medidas</label>
        <input type="text" class="form-control" id="medidasCot" name="medidasCot" placeholder="Medidas del producto">
    </div>
</div>
                    <!-- Alineación de los botones a la derecha -->
            <div class="d-flex justify-content-end">
             <input type="hidden" id="idProductoModificar" name="idProductoModificar">
                <button type="submit" class="btn btn-primary mr-2" id="Modificar">Modificar</button>
                <button type="submit" class="btn btn-danger" id="Eliminar">Eliminar</button>
            </div>
                </form>
            </div>
            <div style="margin-top: 20px;"></div>
           
        </div>
    </div>
</div>
<script> document.querySelector('form').addEventListener('submit', function (event) {
    // Previene el comportamiento predeterminado del formulario
    event.preventDefault();
    
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="Productos.js"></script>
<script src="MostrarCotizables.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

</body>
</html>
