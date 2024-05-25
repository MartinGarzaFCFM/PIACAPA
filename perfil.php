<?php

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: Login.php");
    exit();
}
 
$usuario = $_SESSION['usuario'];
$nombreUsuario = $usuario['usuario'];
$correo = $usuario['correo'];
$nombre = $usuario['Nombre'];
$Nacimiento = $usuario['nacimiento'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Perfil</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="perfil.css">

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


 

<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto mt-5">
            <div class="profile-card">
                <img src="sloth.png" alt="Foto de Perfil" class="profile-image">
            

                <!--<h3>Nombre de Usuario</h3>-->
                <div class="description" >
                <p>Usuario: <?php echo $nombreUsuario; ?></p>
                <h4>Correo: <?php echo $correo; ?></h4>
                    <p>Nombre: <?php echo $nombre; ?></p>
                    <p>Nacimiento: <?php echo $Nacimiento; ?></p>


</div>
<div class="privado">
    <a href="PerfilModificar.php">Modificar</a>

</div>
<!--$user_priv = isset($_SESSION['user_priv']) ? $_SESSION['user_priv'] : null;//nuevooooooooooo-->

                <!-- Mostrar contenido según el rol del usuario -->
                <div class="role-content">
                <?php
    // Obtener el rol y la configuración de privacidad desde la base de datos
   
    $userRol = isset($_SESSION['user_rol']) ? $_SESSION['user_rol'] : null;
    $user_priv = isset($_SESSION['user_priv']) ? $_SESSION['user_priv'] : null;
  // "0">Público
   //"1"Privado
    // Aqui se muestra contenido basado en el rol y la configuración de privacidad
    if ($userRol == 1) { // Cliente
        if ($user_priv == 0) { // Perfil público
            echo '<div class="listas-container">';
            echo '<h4>Listas Públicas</h4>';
            echo '<ul>';
            //las listas de productos públicas o solo mostrar nombre listas
            echo '<li>Producto 1</li>';
            echo '<li>Producto 2</li>';
            echo '<li>Producto 3</li>';
            // ...
            echo '</ul>';
            echo '</div>';
        } else { // Perfil privado
            echo '<div class="private-content">';
            echo '<p>Perfil Privado</p>';
            echo '</div>';
        }

    } elseif ($userRol == 2) { 
        if ($user_priv == 0) { // Perfil público
            echo '<div class="public-content">';
            echo '<h4>Productos Publicados</h4>';
            echo '<ul id="productos-container">';
            // los productos publicados por el vendedor
            echo '<li>Producto 1</li>';
            echo '<li>Producto 2</li>';
            echo '<li>Producto 3</li>';
            // ...
            echo '</ul>';
            echo '</div>';
        
            echo '<div class="listas-container">';
            echo '<h4>Mis Listas</h4>';
            echo '<ul>';
            // Las listas del usuario se cargarán aquí dinámicamente
            echo '</ul>';
            echo '</div>';
        } else { // Perfil privado
            echo '<div class="private-content">';
            echo '<p>Perfil Privado</p>';
            echo '</div>';
        }
        

         } elseif ($userRol == 3) { // Administrador
        // Muestra contenido especial para administradores, independientemente de la configuración de privacidad
        echo '<div class="seller-admin-content">';
        echo '<h4>Productos Autorizados</h4>';
        echo '<ul id="productos-aprobados-container">';
        //  los productos autorizados
        echo '<li>Producto Autorizado 1</li>';
        echo '<li>Producto Autorizado 2</li>';
        echo '<li>Producto Autorizado 3</li>';
        // ...
        echo '</ul>';
        echo '</div>';
      }









    ?>
                  <form action="./db/api.php" method="post">
    <button type="submit" id="eliminar-informacion" name="eliminar" class="btn btn-danger">Borrar Información</button>
</form>
<script>


document.getElementById('eliminar-informacion').addEventListener('click', function() {
    //  ventana de confirmación
    var confirmacion = confirm("¿Estás seguro de que deseas eliminar tu información?");

    // Si el usuario confirma la eliminación, procede con la eliminación
    if (confirmacion) {
        
       
        
    } else {
        
    }
});
</script>
                   
                    
                  
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    function cargarListas() {
        console.log("Cargando listas...");
        $.ajax({
            url: 'db/obtener_listas.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var listasContainer = $('.listas-container ul');
                listasContainer.empty();
                console.log(data);
                data.forEach(function(lista) {
                    console.log(lista);
                    var listaItem = $('<li>' + lista.LIST_NOMBRE + '</li>');
                    listasContainer.append(listaItem);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    }

    cargarListas();

  });
</script>

<script>
$(document).ready(function() {
    function cargarProductos() {
        console.log("Cargando productos...");
        $.ajax({
            url: 'db/Productos_listas.php', 
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var productosContainer = $('#productos-container');
                productosContainer.empty();
                console.log(data);
                data.forEach(function(producto) {
                    console.log(producto);
                    var productoItem = $('<li>' + producto.PRO_NOMBRE + '</li>');
                    productosContainer.append(productoItem);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    }

    cargarProductos();

});
</script>

<script>
$(document).ready(function() {
    function cargarProductosAprobados() {
        console.log("Cargando productos aprobados...");
        $.ajax({
            url: 'db/ObtenerProductosAdimin.php', 
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var productosAprobadosContainer = $('#productos-aprobados-container');
                productosAprobadosContainer.empty(); 
                console.log(data);
                data.forEach(function(producto) {
                    console.log(producto);
                    var productoItem = $('<li>' + producto.PRO_NOMBRE + '</li>');
                    productosAprobadosContainer.append(productoItem);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
            }
        });
    }

    cargarProductosAprobados();
});
</script>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
  
   


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


  
</body>
</html>

