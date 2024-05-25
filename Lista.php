<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Si 'user_id' no está definido, redirige o maneja la situación según sea necesario
    header("Location: Loginn.php");
    exit();
}
$user_id = $_SESSION['user_id'];

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Listas</title>
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
        <!--  <form class="form-inline">
            <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Buscar</button>-->
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
            <h2>Mis Listas</h2>
            
            <ul class="list-group" id="misListas">
           <!-- Ejemplo de lista -->
           <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#" class="lista-item" data-id="1">Lista de Compras</a>
        </li>
        <!-- Agregar más listas aquí -->
    </ul>

    <script>
function showListDetails(listaId) {
    console.log('In showListDetails function');
    console.log('Lista ID:', listaId); // Add this line for debugging
    
    $.ajax({
        
        url: 'db/obtenerinfo_Lista.php',
        method: 'GET',
        data: { ID_LISTA: listaId },
        dataType: 'json',
        success: function (infoLista) {
              // Debugging messages
              console.log('List details successfully displayed for Lista ID:', listaId);
            console.log('Nombre Lista:', infoLista.LIST_NOMBRE);
            console.log('Descripción Lista:', infoLista.LIST_DESCRIPCION);
            console.log('Tipo Lista:', infoLista.LIST_PRIVACIDAD);


                  // Actualizar directamente el contenido de los elementos HTML
        $('#nombreListaCompra').val(infoLista.LIST_NOMBRE);
        $('#descripcionListaCompra').val(infoLista.LIST_DESCRIPCION);
        $('#tipoListaCompra').val(infoLista.LIST_PRIVACIDAD);
        $('#idListaModificar').val(listaId);

            // Show the list container
            $('#listaCompras').collapse('show');
            $('#contenidoLista').show();

            // Display the clicked list ID
            $('#clickedListaId').text('Clicked lista-item with ID: ' + listaId);
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
        url: 'db/cargar_lista.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            var listasContainer = $('#misListas');
            data.forEach(function (lista) {
                var listaHTML = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="lista-item" data-id="${lista.ID_LISTA}">${lista.LIST_NOMBRE}</a>
                    </li>
                `;
                var listItem = $(listaHTML).appendTo(listasContainer);
                listItem.find('.lista-item').click(function (event) {
                    event.preventDefault();
                    var listaId = $(this).data('id');
                    console.log('List item clicked with ID:', listaId);
                    showListDetails(listaId);
                });
            });
        },
        error: function (error) {
            console.error('Error obtaining list names:', error);
        }
    });

    // Añade un evento de submit al formulario
    $('form').submit(function (event) {
        event.preventDefault();
        // Añade tu lógica de envío del formulario aquí
        console.log('Form submitted!');
        // También puedes realizar acciones adicionales después de enviar el formulario, si es necesario
    });
});


/*
 // Agrega un evento de clic a cada elemento de lista
 $(document).on('click', '.lista-item', function (event) {
        event.preventDefault();
        // Obtén el ID de la lista desde el atributo data-id
        var listaId = $(this).data('id');
        console.log('Clicked lista-item with ID: ' + listaId);

        // Realiza una solicitud AJAX para obtener la información de la lista
        $.ajax({
            url: 'db/obtenerinfo_Lista.php',
            method: 'GET',
            data: { ID_LISTA: listaId },
            dataType: 'json',
            success: function (infoLista) {
    console.log('InfoLista:', infoLista);

    // Now you can access individual fields like infoLista.ID_LISTA, infoLista.LIST_NOMBRE, etc.
    $('#nombreListaCompra').val(infoLista.LIST_NOMBRE);
    $('#descripcionListaCompra').val(infoLista.LIST_DESCRIPCION);
    $('#tipoListaCompra').val(infoLista.LIST_PRIVACIDAD);

    $('#listaCompras').collapse('show');
    $('#contenidoLista').show();
},

            error: function (error) {
                console.error('Error al obtener información de lista:', error);
            }
        });
    });*/

    // Add a submit event listener to the form
/*$('form').submit(function (event) {
    event.preventDefault();
    // Add your form submission logic here
    console.log('Form submitted!');
});*/

$(document).ready(function () {
    // Función para cargar el contenido de la lista
    function cargarContenidoLista(idLista) {
        // Realiza una solicitud AJAX para obtener los productos de la lista
        $.ajax({
            url: 'db/Lista_Producto.php',
            method: 'GET',
            data: { idLista: idLista },
            dataType: 'json',
            success: function (productos) {
                // Limpia la lista actual
                $('#contenidoListaCompras').empty();

                // Itera sobre los productos y agrega cada uno a la lista
                // QUITE EL CALCULAR PRECIO PORQUE SI SE MODIFICA EL PRODUCTO SE QUEDA CON EL CALCULADO VIEJO
                // <p class="mb-1">Precio Calculado: ${producto.PRO_PRECIO_TOTAL_CALCULADO}</p> <!-- Agregado -->
                productos.forEach(function (producto) {
                    var productoHTML = `
                    <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex">
                    <img src="data:image/jpeg;base64, ${producto.Imagen}" alt="Imagen del producto" class="tamaño mr-3" style="max-width: 50px;">
                    <div>

                        <h5 class="mb-1">${producto.PRO_NOMBRE}</h5>
                        <p class="mb-1">${producto.PRO_DESCRIPCION}</p>

                    </div>
                </div>
                <div class="text-right">
                    <h6 class="mb-1">Precio: $${producto.PRO_PRECIOTOTAL}</h6>
                    <p class="mb-1">Cantidad: ${producto.PRO_CANTIDAD}</p>
                    <p class="mb-1">Lista Cantidad: ${producto.LISTA_PRO_CANTIDAD}</p> <!-- Agregado -->
                                
                </div>
            </div>
            <div class="d-flex justify-content-end mt-2">
            
            <button class="btn btn-primary btn-agregar-carrito" id="agregar-carrito" data-producto-id="${producto.ID_PRO}" data-producto-cantidad="${producto.LISTA_PRO_CANTIDAD}">Agregar al Carrito</button>

                
                <button class="btn btn-danger btn-sm ml-2" id="Eliminar2" data-id-producto="${producto.ID_PRO}">Eliminar</button>
            
                </div>
        </li>

                    `;
                    $('#contenidoListaCompras').append(productoHTML);
                });
            },
            error: function (error) {
                console.error('Error obteniendo productos de la lista:', error);
            }
        });
    }

    // Añade un manejador de clic al contenedor de listas
    $('#misListas').on('click', '.lista-item', function (event) {
        event.preventDefault();
        // Obtiene el ID de la lista desde el atributo de datos 
        var listaId = $(this).data('id');
        console.log('List item clicked with ID:', listaId);
        cargarContenidoLista(listaId);
    });
    







});

</script>
<script>
  $(document).ready(function () {
        // Delegación de eventos para el botón "Agregar al Carrito"
        $('#contenidoListaCompras').on('click', '.btn-agregar-carrito', function () {
            // Obtener el ID del producto y otros datos del atributo de datos
            var productoId = $(this).data('producto-id');
            var usuarioId = <?php echo json_encode($user_id); ?>;
            var cantidad =  $(this).data('producto-cantidad');

            // Resto del código para agregar al carrito
            // ...

            // Hacer la solicitud AJAX al servidor
            $.ajax({
                url: 'db/Agregar_carrito_producto.php', // Reemplaza con la ruta correcta a tu script PHP
                method: 'POST',
                data: { idProducto: productoId, cantidad: cantidad, user_id: usuarioId },
                dataType: 'json',
                success: function (resultado) {
                    // ...
                },
                error: function (error) {
                    // ...
                }
            });
        });

        // Resto de tu código existente
    });
</script>
</div>
        <div class="col-md-8">
            <div id="listaCompras" class="collapse show">
                <h3>Nombre Lista de Compras</h3>
                <form>
                    <div class="form-group" id="formListaCompras">
                        <label for="nombreListaCompra">Nombre de la Lista</label>
                        <input type="text" class="form-control" id="nombreListaCompra" name="nombreListaCompra"  placeholder="Ingrese el nombre de la lista">
                    </div>
                    <div class="form-group">
                        <label for="descripcionListaCompra">Descripción de la Lista</label>
                        <textarea class="form-control" id="descripcionListaCompra" name="descripcionListaCompra" rows="3" placeholder="Ingrese la descripción de la lista"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tipoListaCompra">Tipo de Lista</label>
                        <select class="form-control" id="tipoListaCompra" name="tipoListaCompra">
                            <option value="1">Pública</option>
                            <option value="2">Privada</option>
                        </select>
                    </div>
            
                    <!-- Alineación de los botones a la derecha -->
            <div class="d-flex justify-content-end">
             <input type="hidden" id="idListaModificar" name="idListaModificar">
                <button type="submit" class="btn btn-primary mr-2" id="Modificar">Modificar</button>
                <button type="submit" class="btn btn-danger" id="Eliminar">Eliminar</button>
            </div>
                </form>
            </div>
            <div style="margin-top: 20px;"></div>
            <div id="contenidoLista"   class="in" style="display: none;">
                <h3>Contenido de la Lista</h3>
                <ul class="list-group" id="contenidoListaCompras">
                    <!-- Productos en la lista -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="Estufa.png" alt="Producto 1" class="mr-3" style="max-width: 50px;">
                            Estufa 
                             Mabe de Piso 30"
                             $299.99
                            
                           
                        </div>
                        <button class="btn btn-primary btn-sm mr-2" id="carrito">Agregar al Carrito</button>
                    </li>
                    <!-- Agregar más productos aquí -->
                </ul>
                <!-- Contenido de la Lista -->
            </div>
        </div>
    </div>
</div>


<script src="Lista.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
