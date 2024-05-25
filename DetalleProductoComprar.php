
<?php
session_start();
// DetalleProductoComprar.php
include_once 'db/consulta.php';
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: Loginn.php");
    exit();
} 

$user_id = $_SESSION['user_id'];


// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";

$productoID = isset($_GET['productoID']) ? intval($_GET['productoID']) : 0;

if ($productoID > 0) {
    $consulta = new consulta();
    $productoSeleccionado = $consulta->obtenerProductoPorID($productoID);

    if ($productoSeleccionado) {
        
      // producto seleccionado en la base de datos
      $cantidadDisponible = $productoSeleccionado['PRO_CANTIDAD'];
 $TipoProducto = $productoSeleccionado['PRO_TIPO'];
 $usuario2 = $productoSeleccionado['id_usuario'];
 
 echo '<pre>';
 print_r($productoSeleccionado);
 echo '</pre>';
 
        ?>

    



        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Producto Comprar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <link rel="stylesheet" href="DetalleProductoComprar.css">
</head>
<body>
<!-- Barra superior -->

<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
        <a class="navbar-brand"  href="home.php">
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
            <a href="carrito.php" class="btn btn-outline-light">
                    <i class="fas fa-shopping-cart"></i> Carrito
                </a>
                 <!-- Botón del carrito href="carrito.php" -->
                 <!-- <a  class="btn btn-outline-light">
                    <i class="fas fa-shopping-cart"></i> Carrito-->
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

<div class="container-Comprar mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Detalles del Producto</h2>
            
            <p class="name-vendedor">Vendedor: <?= $productoSeleccionado['Nombre']; ?></p>
            
            <p class="name-vendedor">Vendedor: <?= $productoSeleccionado['id_usuario']; ?></p>
            <p class="name-produ">Numero del producto: <?= $productoSeleccionado['ID_PRO']; ?></p>

            <div class="product-details">
            <div class="product-details">
            <div id="productCarousel" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <?php
        // Muestra la única imagen del producto
        echo '<div class="carousel-item active">';
        echo '<img src="data:image/jpeg;base64,' . $productoSeleccionado['Imagen'] . '" alt="Imagen del producto" class="tamaño">';
        echo '</div>';
        
        // Muestra el video
        echo '<div class="carousel-item">';
        echo '<video class="tamaño" controls style="width: 100%; height: auto;">'; 
        echo '<source type="video/mp4" src="data:video/mp4;base64,' . $productoSeleccionado['Video'] . '" alt="Video del producto">';
        echo '</video>';
        echo '</div>';
        ?>
    </div>



    
    <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Anterior</span>
    </a>
    <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Siguiente</span>
    </a>
</div>

 

                
                <div class="product-info" >
                
                <h3 class="product-name"><?= $productoSeleccionado['PRO_NOMBRE']; ?></h3>
    <div class="product-rating">
        <!-- Aquí puedes mostrar la información de la calificación -->
    </div>


<?php if ($productoSeleccionado['PRO_TIPO'] != 1) { ?>
        <!-- Solo muestra este bloque si PRO_TIPO no es igual a 1 -->
        <p class="product-price">Precio: $<?= $productoSeleccionado['PRO_PRECIOTOTAL']; ?></p>

        <p>Cantidad Disponible: <?= $productoSeleccionado['PRO_CANTIDAD']; ?></p>

        <div class="product-quantity">
            <label for="quantity">Cantidad a pedir:</label>
            <input type="number" id="quantity" class="quantity-input" min="1" value="1">
        </div>
    <?php } ?>
    <p class="product-description"> Descripcion: <?= $productoSeleccionado['PRO_DESCRIPCION']; ?></p>
    <div class="product-actions">


    <?php
        // Verifica el valor de PRO_TIPO
        if ($productoSeleccionado['PRO_TIPO'] != 1) {
            echo '<button class="btn btn-primary" id="Carrito" data-producto-id="' . $productoSeleccionado['ID_PRO'] . '">Agregar al Carrito</button>';
           

            //  echo ' <button class="btn btn-success" id="Pago">Comprar Ahora</button>';
  
       // <button class="btn btn-success agregar-a-lista" data-producto-id="<?= $productoSeleccionado['ID_PRO']; >" data-toggle="modal" data-target="#listaModal">Agregar a la lista</button>

        

            // Muestra el botón solo si PRO_TIPO no es igual a 1
            echo '<button class="btn btn-success agregar-a-lista" data-producto-id="' . $productoSeleccionado['ID_PRO'] . '" data-toggle="modal" data-target="#listaModal">Agregar a la lista</button>';
        }
        ?>
    
<script>
 $(document).ready(function () {
        // Agregar un evento de clic al botón "Agregar al Carrito"
        

        $('#Carrito').click(function () {
            // Obtener el ID del producto y la cantidad
            var productoId = <?= $productoSeleccionado['ID_PRO']; ?>;
            var usuario_id = <?php echo json_encode($user_id); ?>;
          //  var productoId = $('#name-produ');
            var cantidad = $('#quantity').val();

            console.log('Producto ID:', productoId);
            console.log('usu ID:', usuario_id);
            console.log('Cantidad:', cantidad);

            // Hacer la solicitud AJAX al servidor
            $.ajax({
                url: 'db/Agregar_carrito_producto.php', // Reemplaza con la ruta correcta a tu script PHP
                method: 'POST',
                data: { idProducto: productoId, cantidad: cantidad, user_id: usuario_id },
                dataType: 'json',
                success: function (resultado) {
                    console.log('Resultado:', resultado);

                    // Realizar acciones adicionales después de agregar al carrito, si es necesario
                    if (resultado.success) {
                        alert('Producto agregado al carrito con éxitoo: ' + resultado.mensaje);
                    } else {
                        alert('Error al agregar el producto al carritoo: ' + resultado.mensaje);
                    }
                },
                error: function (error) {
                    console.error('Error al agregar el producto al carrito:', error);
                    
                }
            });
        });
    }); 
</script>


<?php

// Agregar una lógica condicional para mostrar o no el enlace "Cotizar"
if ($productoSeleccionado['PRO_TIPO'] == 1) {
    // Obtén el ID del usuario que está en el servidor
    $usuario1 = $_SESSION['user_id'];

    // Obtén el ID del vendedor desde el producto seleccionado
    $usuario2 = $productoSeleccionado['id_usuario'];

    // Obtén el ID del producto seleccionado
    $producto_id = $productoSeleccionado['ID_PRO'];

    // Llama a la función para insertar la conversación y obtén el ID de la conversación
    $id_conversacion = $consulta->insertarConversacion($usuario1, $usuario2, $producto_id);
    var_dump($id_conversacion);
?>
                    
       <a class="btn cotizar-btn" href="#" data-producto-id="<?= $producto_id; ?>" data-id-conversacion="<?= $id_conversacion; ?>" data-id-usuario1="<?= $usuario1; ?>" data-id-usuario2="<?= $usuario2; ?>">Cotizar</a>


    <!-- Agrega el script de AJAX -->
         <!--  <button class="btn btn-success" id="Lista" data-toggle="modal" data-target="#listaModal">Agregar a la lista</button>-->
         <script>
document.addEventListener('DOMContentLoaded', function() {
    // Busca todos los elementos con la clase cotizar-btn y agrega un event listener
    document.querySelectorAll('.cotizar-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            // Obtiene el producto_id y el id_conversacion desde los atributos data-
            var producto_id = this.getAttribute('data-producto-id');
            var id_conversacion = this.getAttribute('data-id-conversacion');
            var id_usuario2 = this.getAttribute('data-id-usuario2');
            var id_usuario1 = this.getAttribute('data-id-usuario1');
            // Crea una instancia de XMLHttpRequest
            var xhr = new XMLHttpRequest();

            // Configura la solicitud POST a tu archivo PHP
            xhr.open('POST', 'db/consulta.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Define la función que se ejecutará cuando la solicitud esté completa
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // No necesitas obtener el id_conversacion de la respuesta del servidor,
                    // ya lo tienes desde los atributos data-
                    alert('URL de redirección: cotizar.php?id_conversacion=' + id_conversacion + '&producto_id=' + producto_id + '&id_usuario1=' + id_usuario1 + '&id_usuario2=' + id_usuario2);

// Redirige a la página de cotización con los parámetros necesarios
window.location.href = 'cotizar.php?id_conversacion=' + id_conversacion + '&producto_id=' + producto_id + '&id_usuario1=' + id_usuario1 + '&id_usuario2=' + id_usuario2;

                    //alert('URL de redirección: cotizar.php?id_conversacion=' + id_conversacion + '&producto_id=' + producto_id); sirve

                    // Redirige a la página de cotización con los parámetros necesarios
                    //window.location.href = 'cotizar.php?id_conversacion=' + id_conversacion + '&producto_id=' + producto_id; sirve
                    
                }
            };

            // Envía los datos necesarios al servidor (puedes ajustar según tus necesidades)
            var data = 'producto_id=' + producto_id;
            xhr.send(data);
        });
    });
});

    </script>
<?php
}
?>
    </div>
</div>

            <!-- 
            <div class="modal" id="listaModal">
                
            </div>-->
        </div>
    </div>
</div>


<!-- Modal para elegir la lista -->
<div class="modal" id="listaModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar a la Lista</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Selecciona la lista a la que deseas agregar este producto:</p>
                <ul class="list-group" id="misListas">
                   
                    <!-- Agregar más listas aquí -->
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="agregarALista">Agregar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function () {
    var listaSeleccionada = {}; // Almacena la información de la lista seleccionada

    // Hacer la solicitud AJAX para obtener las listas
    $.ajax({
        url: 'db/cargar_lista.php',
        method: 'GET',
        dataType: 'json',
        success: function (listas) {
            var listasContainer = $('#misListas');

            // Construir dinámicamente las listas en el modal
            listas.forEach(function (lista) {
                var listaHTML = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="lista-item" data-listid="${lista.ID_LISTA}" data-listname="${lista.LIST_NOMBRE}">${lista.LIST_NOMBRE}</a>
                    </li>
                `;
                listasContainer.append(listaHTML);
            });

    // Agregar un evento de clic a los elementos de lista
    $('.lista-item').click(function (event) {
                event.preventDefault();
                listaSeleccionada.id = $(this).data('listid');
                listaSeleccionada.nombre = $(this).data('listname');
                console.log('Lista ID:', listaSeleccionada.id);
                console.log('Lista Nombre:', listaSeleccionada.nombre);
            });
        },
        error: function (error) {
            console.error('Error obteniendo las listas:', error);
        }
    });

   
// Agregar un evento de clic al botón "Agregar"
$('#agregarALista').click(function () {
    var productoId = <?= $productoSeleccionado['ID_PRO']; ?>; // Obtener el ID del producto desde PHP
    var cantidad = $('#quantity').val(); // Obtener la cantidad desde el campo de entrada
    if (productoId && cantidad) {
        agregarAListaProducto(listaSeleccionada.id, productoId, cantidad);
    } else {
        console.error('Error obteniendo el ID del producto o la cantidad.');
    }
});

// Función para agregar a la tabla LISTA_PRODUCTO
function agregarAListaProducto(idLista, idProducto, cantidad) {
    $.ajax({
        url: 'db/agregar_lista_producto.php',
        method: 'POST',
        data: { idLista: idLista, idProducto: idProducto, cantidad: cantidad }, // Enviar también la cantidad
        dataType: 'json',
        success: function (resultado) {
            console.log('Producto agregado a la lista con éxito.');
            // Puedes realizar acciones adicionales después de agregar a la lista aquí
            // Por ejemplo, cerrar el modal, mostrar un mensaje de éxito, etc.
            $('#listaModal').modal('hide');
        },
        error: function (error) {
            console.error('Error al agregar el producto a la lista:', error);
        }
    });
}
});


    /*
$(document).ready(function () {
    // Hacer la solicitud AJAX para obtener las listas
    $.ajax({
        url: 'db/cargar_lista.php', // Ajusta la ruta según tu estructura de archivos
        method: 'GET',
        dataType: 'json',
        success: function (listas) {
            var listasContainer = $('#misListas');

            // Construir dinámicamente las listas en el modal
            listas.forEach(function (lista) {
                var listaHTML = `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <a href="#" class="lista-item" data-listid="${lista.ID_LISTA}" data-listname="${lista.LIST_NOMBRE}">${lista.LIST_NOMBRE}</a>
                    </li>
                `;
                listasContainer.append(listaHTML);
            });

            // Agregar un evento de clic a los elementos de lista
            $('.lista-item').click(function (event) {
                event.preventDefault();
                var listaId = $(this).data('listid');
                var listaNombre = $(this).data('listname');
                
                // Realizar acciones con el ID y nombre de la lista seleccionada
                console.log('Lista ID:', listaId);
                console.log('Lista Nombre:', listaNombre);
            });
        },
        error: function (error) {
            console.error('Error obteniendo las listas:', error);
        }
    });
});*/




</script>
                </div>
            </div>
         <!--   <div class="product-reviews">
                <h4>Reseñas de los Comentarios</h4>
                <p>Comentario 1:  ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <p>Comentario 2: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
             
            </div>
              . -->
          
        </div>
    </div>
</div>

<script src="DetalleProductoComprar.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
        <?php
    } else {
        echo "Producto no encontrado.";
    }
} else {
    echo "ID de producto no válido.";
}
?>


