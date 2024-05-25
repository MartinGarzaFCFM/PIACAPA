<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";

?>

<!--- CLIENTE-->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrito</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="Venta.css">
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

<div class="container-Compras mt-5">
    <h2>Consulta de Compras</h2>
    <form id="consultaForm" >
        <div class="form-group">
           
<!-- Modifica las etiquetas de fecha en tu formulario -->
<label for="fechaInicio">Fecha de Inicio:</label>
<input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>

<label for="fechaFin">Fecha de Fin:</label>
<input type="date" class="form-control" id="fechaFin" name="fechaFin" required>




        <div class="form-group">
          <label for="categoria">Categoría</label>
          <select class="form-control" id="categoriaSelect" name="categoria">
        <option value="">Seleccione una categoría</option>
             </select>
             </div>
    
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>
    
    <!-- consulta de compras -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha y Hora de Compra</th>
                <th>Categoría</th>
                <th>Producto</th>
                <th>Precio</th>
            </tr>
        </thead>
      
        <tbody id="resultadosCompras">
        <!-- Los resultados se mostrarán aquí dinámicamente -->
    </tbody>
            
       
    </table>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        // Manejar el envío del formulario
        $("#consultaForm").submit(function (event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            // Obtener los valores del formulario
            var fechaInicio = $("#fechaInicio").val();
            var fechaFin = $("#fechaFin").val();
            var categoria =$("#categoriaSelect").val();

            // Realizar una solicitud AJAX para obtener los resultados de la consulta
            $.ajax({
                type: "POST",
                url: "db/Obtener_Pedidos.php",
                data: {
                    fechaInicio: fechaInicio,
                    fechaFin: fechaFin,
                    categoria: categoria
                },
                success: function (data) {
                    // Actualizar dinámicamente la tabla de resultados
                    $("#resultadosCompras").html(data);
                },
                error: function (xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                }
            });
        });
   
</script>







<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
