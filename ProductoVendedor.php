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
<title>Productos Vendedor</title>
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
      <!--   <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Categorías
                </a>
                <div class="dropdown-menu" aria-labelledby="categoryDropdown">
                    <a class="dropdown-item" href="Electronica.php">Electrónicos</a>
                    <a class="dropdown-item" href="#">Ropa</a>
                    <a class="dropdown-item" href="#">Hogar</a>
                </div>
            </li>
        </ul>-->
  <!--        <div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categorías
    </a>
    <div class="dropdown-menu" aria-labelledby="categoryDropdown" data-toggle="manual-dropdown">
     
       /* $jsonCategorias = file_get_contents('db/cargar_categorias.php');
        $categorias = json_decode($jsonCategorias);

        if ($categorias !== null) {
            foreach ($categorias as $categoria) {
                echo '<a class="dropdown-item" href="Electronica.php?categoria=' . urlencode($categoria) . '">' . $categoria . '</a>';
            }
        } else {
            echo '<a class="dropdown-item" href="#">No se encontraron categorías</a>';
        }*/
        
    </div>
</div>-->
<!-- <div class="dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categorías
    </a>
    <div class="dropdown-menu" aria-labelledby="categoryDropdown" data-toggle="manual-dropdown">
        
        <script>
        var categoryDropdown = document.getElementById("categoryDropdown");
  var categoryMenu = categoryDropdown.nextElementSibling;

  var xhr = new XMLHttpRequest();
  xhr.open("GET", "db/cargar_categorias.php", true);

  xhr.onload = function () {
      if (xhr.status === 200) {
          var response = JSON.parse(xhr.responseText);
          if (Array.isArray(response) && response.length > 0) {
              response.forEach(function (categoria) {
                  var link = document.createElement("a");
                  link.className = "dropdown-item";
                  link.href = "Electronica.php?categoria=" + encodeURIComponent(categoria);
                  link.textContent = categoria;
                  categoryMenu.appendChild(link);
              });
          } else {
              categoryMenu.innerHTML = '<a class="dropdown-item" href="#">No se encontraron categorías</a>';
          }
      } else {
          categoryMenu.innerHTML = '<a class="dropdown-item" href="#">Error al cargar categorías</a>';
      }
  };

  xhr.send();

  </script>
    

    </div>
</div>-->
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
            <h2>Registro de Producto</h2>
            <form name= "form" method="POST" action="./db/Producto.php" id="signupForm" enctype="multipart/form-data";>
          
            <div class="form-group">
                    <label for="tipo">Tipo de Producto</label>
                    <select class="form-control" id="tipo" name="tipo" oninput="mostrarCamposAdicionales()">
                        <option value="1">Cotizar</option>
                        <option value="2">Vender</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="nombre">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombrePro" name="nombrePro" placeholder="Nombre del producto">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción del Producto</label>
                    <textarea class="form-control" id="descripcionPro" name="descripcionPro"rows="3" placeholder="Descripción del producto"></textarea>
                </div>



                <div class="form-group">
                    <label for="imagenes">Imágenes (mínimo: 3)</label>
                    <input type="file" class="form-control-file" id="imagenesPro"  name= "imagenesPro" accept="image/*" multiple>
                </div>

                <div class="form-group">
                    <label for="video">Video (mínimo: 1)</label>
                    <input type="file" class="form-control-file" id="videoPro"  name= "videoPro" accept="video/*">
                </div>

                       <div class="form-group">
          <label for="categoria">Categoría (al menos una)</label>
          <select class="form-control" id="categoriaSelect" name="categoria">
        <option value="">Seleccione una categoría</option>
             </select>
             <div class="categoria">
          <span class="categoria">¿Quieres agregar una categoria?
           <a href='categoria.php' for="check">Agrega categoria</a>
        </div>
                </div>


                
                    <script>
                var categoriaSelect = document.getElementById("categoriaSelect");

                // Realiza una solicitud GET para cargar las categorías
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "db/cargar_categoriasVendedor.php", true);

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

                
                <!-- Campo para ingresar una nueva categoría -->
               <!--  <div class="form-group">
                <label for="nuevaCategoria">Nueva Categoría</label>
                <input type="text" class="form-control" id="nuevaCategoria" name="nuevaCategoria">
                </div>

                <button type="button" class="btn btn-primary" id="agregarCategoria">Agregar Categoría</button>-->

               
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" class="form-control" id="precioPro" name="precioPro" placeholder="Precio del producto">
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad Disponible</label>
                    <input type="number" class="form-control" id="cantidadPro" name="cantidadPro" placeholder="Cantidad disponible">
                </div>

  <!-- Campos para productos cotizables -->
 <!-- Campos para productos cotizables -->
<div id="camposCotizables" style="display: block;">
    <div class="form-group">
        <label for="material">Material</label>
        <input type="text" class="form-control" id="materialCot" name="materialCot" placeholder="Material del producto">
    </div>
    <div class="form-group">
        <label for="medidas">Medidas</label>
        <input type="text" class="form-control" id="medidasCot" name="medidasCot" placeholder="Medidas del producto">
    </div>
</div>


              <!--   <div class="form-group">
                    <label for="valoracion">Valoración</label>
                    <input type="number" class="form-control" id="valoracion" min="1" max="10" placeholder="Valoración del producto">
                </div>-->
              <!-- <div class="form-group">
                    <label for="comentarios">Comentarios</label>
                    <textarea class="form-control" id="comentarios" rows="3" placeholder="Comentarios sobre el producto"></textarea>
                </div>-->
            
                <input type="submit" class="button" name="RegisterProd" id="RegisterProd" value="Agregar Producto">
              <!-- Agrega este formulario alrededor del botón "Gestionar productos" -->


            </form>
            <form action="Gestion_Productos.php" method="post">
    <input type="submit" class="button" name="GestionarProd" id="GestionarProd" value="Gestionar Productos">
</form>
        </div>
    </div>
</div>



<!-- <script src="ProductoVendedor.js"></script>-->
<script src="MostrarCotizables.js"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>