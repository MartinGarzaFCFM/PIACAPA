<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: Login.php");
    exit();
} // codigo recien colocadoo 19-10-2023

$user_id = $_SESSION['user_id'];


var_dump($user_id);
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Categoria</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="ProductoVendedor.css">
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
<div class="container-Vendedor mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Registro de categoria</h2>
            <form  name= "form" method="POST" action="./db/categoria.php" id="signupForm";>
            
           
                
                <div class="form-group">
                    <label for="nombre">Nombre del categoria</label>
                    <input type="text" class="form-control" id="nombrecat" name="nombrecat" placeholder="Nombre de la categoria">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción del categoria</label>
                    <textarea class="form-control" id="descripcioncat" name="descripcioncat" rows="3" placeholder="Descripción de la categoria"></textarea>
                </div>
                
                <input type="submit" class="button" name="agregarCategoria" id="agregarCategoria" value="Agregar Categoría">
                <div class="mt-2">
                    <a href="ProductoVendedor.php" class="btn btn-danger mt-2">Regresar a ProductoVendedor</a>
                    <a href="GestionCategorias.php" class="btn btn-primary mt-2">Gestionar categorias</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!--<script src=""></script>-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>