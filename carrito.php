<?php
session_start();
// DetalleProductoComprar.php
include_once 'db/consulta.php';
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: ./db/Login.php");
    exit();
} 

$user_id = $_SESSION['user_id'];


// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";  


// Crea una instancia de la clase Consulta
$consulta = new Consulta();

// Obtén los datos del carrito del usuario
$datosCarrito = $consulta->ObtenerInformacionCarritoUsuarioProducto($user_id);

//var_dump($datosCarrito);



// Bucle foreach para recorrer $datosCarrito e imprimir la información en la página
foreach ($datosCarrito as $producto):
    
    // ... (resto del código)
endforeach;

// Verifica si se hizo clic en el botón Eliminar
if (isset($_POST['eliminar_carrito_id'])) {
    $carrito_id = $_POST['eliminar_carrito_id'];

    // Llama a la función para eliminar el producto del carrito
    $eliminado = $consulta->EliminarProductoDelCarrito($carrito_id);

    // Maneja el resultado según tus necesidades
    if ($eliminado) {
        echo 'Producto eliminado del carrito exitosamente.';
    } else {
        echo 'Error al eliminar el producto del carrito.';
    }
}

$consulta = new Consulta();

// Obtén los datos del carrito del usuario
$datosCarritoCotizado = $consulta->ObtenerInformacionCarritoUsuarioProductoCotizado($user_id);





?>

    






<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Carrito</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="carrito.css">
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

<!-- Contenido del carrito -->
<!-- Contenido del carrito -->
<div class="container-carrito">
    <h2>Carrito de Compras</h2>

    <?php if (!empty($datosCarrito)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>ID carrito</th>
                    <th>ID Producto</th>
                    <th>Nombre</th>
                    <th>Precio Unitario</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Total Calculado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datosCarrito as $producto): ?>
                    <tr>
                        <td>
                            <?php if (isset($producto['ImagenProducto'])): ?>
                                <img src="data:image/jpeg;base64, <?php echo $producto['ImagenProducto']; ?>" alt="Imagen del producto" class="tamaño" style="max-width: 50px;">
                            <?php endif; ?>
                        </td>
                        <td><?php echo $producto['ID_CARRITO']; ?></td>
                        <td><?php echo $producto['ID_PRODUCTO']; ?></td>
                        <td><?php echo $producto['PRO_NOMBRE']; ?></td>
                        <td>$<?php echo $producto['CARR_PRECIO_UNITARIO']; ?></td>
                        <td><?php echo $producto['PRO_DESCRIPCION']; ?></td>
                        <td>
                            <?php echo $producto['CARR_CANTIDAD']; ?>
                        </td>
                        <td>$<?php echo $producto['PRO_PRECIO_TOTAL_CALCULADO']; ?></td>
                        <td>
                            <!-- Agrega aquí el botón o acción específica para productos normales -->
                            <form method="post" action="carrito.php">
                                <input type="hidden" name="eliminar_carrito_id" value="<?php echo $producto['ID_CARRITO']; ?>">
                                <button type="submit" class="btn btn-danger btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

      
    <?php else: ?>
        <p>No hay productos en el carrito.</p>
    <?php endif; ?>
</div>


<div class="container-carrito ">
    
<?php if (!empty($datosCarritoCotizado)): ?>
            <h3>Productos Cotizados</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                    <th>Imagen</th>
                    <th>ID_CARRITO</th>
                        <th>ID Cotización</th>
                        <th>Nombre</th>
                        <th>Precio Unitario</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Total Calculado</th>
                        <th>Material</th>
                        <th>Medidas</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datosCarritoCotizado as $productoCotizado): ?>
                        <tr>
                        <td>
                        <?php if (isset($productoCotizado['ImagenProducto'])): ?>
                                <img src="data:image/jpeg;base64, <?php echo $productoCotizado['ImagenProducto']; ?>" alt="Imagen del producto" class="tamaño" style="max-width: 50px;">
                            <?php endif; ?>
                            </td>
                            <td><?php echo $productoCotizado['ID_CARRITO']; ?></td>
                            <td><?php echo $productoCotizado['ID_COTI']; ?></td>
                            <td><?php echo $productoCotizado['PRO_NOMBRE']; ?></td>
                            <td>$<?php echo $productoCotizado['CARR_PRECIO_UNITARIO']; ?></td>
                            <td><?php echo $productoCotizado['PRO_DESCRIPCION']; ?></td>
                            <td><?php echo $productoCotizado['CARR_CANTIDAD']; ?></td>
                            <td>$<?php echo $productoCotizado['PRO_PRECIO_TOTAL_CALCULADO']; ?></td>
                            <td><?php echo $productoCotizado['PRO_MATERIAL']; ?></td>
                            <td><?php echo $productoCotizado['PRO_MEDIDAS']; ?></td>
                            <td><?php echo $productoCotizado['PRO_CANTIDAD']; ?></td>
                            <td>
                            <!-- Agrega aquí el botón o acción específica para productos normales -->
                            <form method="post" action="carrito.php">
                                <input type="hidden" name="eliminar_carrito_id" value="<?php echo $productoCotizado['ID_CARRITO']; ?>">
                                <button type="submit" class="btn btn-danger btn-eliminar">Eliminar</button>
                            </form>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
</div>



<!--  
<div class="cart-summary mt-3">
            <h4>Resumen del Carrito</h4>
            
            <button class="btn btn-success btn-block" id="Pago">Proceder al Pago</button>
        </div>-->
       
<!-- PAGOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO-->
<!--<div class="container-carrito ">
  <h4>Resumen del Carrito</h4>
  
  <button class="btn btn-success btn-block" id="Pago" data-toggle="modal" data-target="#paymentModal">Proceder al Pago</button>
</div>-->

<?php
// Verificar si hay productos cotizados o productos normales
$hayProductos = !empty($datosCarritoCotizado) || !empty($datosCarrito);

// Mostrar el botón solo si hay productos cotizados o productos normales
if ($hayProductos):
?>
    <div class="container-carrito">
        <h4>Resumen del Carrito</h4>
  
        <button class="btn btn-success btn-block" id="Pago" data-toggle="modal" data-target="#paymentModal">Proceder al Pago</button>
    </div>
<?php endif; ?>


<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">Formulario de Pago</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
        <form id="paymentForm">
          <div class="form-group">
            <label for="cardType">Tipo de Tarjeta</label>
            <select class="form-control" id="cardType" required>
              <option value="debito">Tarjeta de Débito</option>
              <option value="credito">Tarjeta de Crédito</option>
            </select>
          </div>
          <div class="form-group">
            <label for="cardNumber">Número de Tarjeta</label>
            <input type="text" class="form-control" id="cardNumber" placeholder="Ingrese el número de tarjeta" required>
          </div>
          <div class="form-group">
            <label for="cardName">Nombre en la Tarjeta</label>
            <input type="text" class="form-control" id="cardName" placeholder="Nombre en la tarjeta" required>
          </div>
          <div class="form-group">
            <label for="expiryDate">Fecha de Vencimiento</label>
            <input type="date" class="form-control" id="expiryDate" required>
          </div>
          <div class="form-group" id="cvvGroup" style="display:none;">
            <label for="cvv">CVV</label>
            <input type="text" class="form-control" id="cvv" placeholder="CVV">
          </div>
          <button type="button" class="btn btn-primary" id="Pagar">Pagar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
    // Función para mostrar una alerta cuando se hace clic en el botón Eliminar
    function mostrarAlertaEliminar() {
        alert('Producto eliminado del carrito exitosamente.');
    }

    // Asigna la función al evento click de los botones Eliminar
    document.querySelectorAll('.btn-eliminar').forEach(function(boton) {
        boton.addEventListener('click', mostrarAlertaEliminar);
    });
</script>


<script>
  $(document).ready(function () {
    // Cuando cambia el valor en el campo de selección de tipo de tarjeta
    $("#cardType").change(function () {
      // Obtén el valor seleccionado
      var selectedCardType = $(this).val();

      // Muestra el campo CVV si la tarjeta seleccionada es de crédito
      if (selectedCardType === "credito") {
        $("#cvvGroup").show();
      } else {
        // Oculta el campo CVV si la tarjeta no es de crédito
        $("#cvvGroup").hide();
      }
    });

    // Evento al hacer clic en el botón "Pagar"
    $("#Pagar").click(function () {
       // Obtener los valores ingresados
       var cardNumber = $("#cardNumber").val();
      var cardName = $("#cardName").val();
      var cvv = $("#cvv").val();

      // Validar el número de tarjeta (debe tener 16 dígitos)
      if (!/^\d{16}$/.test(cardNumber)) {
        alert("Ingrese un número de tarjeta válido con 16 dígitos.");
        return;
      }

      // Validar el nombre (debe contener solo letras)
      if (!/^[a-zA-Z\s]+$/.test(cardName)) {
        alert("Ingrese un nombre válido con solo letras.");
        return;
      }

      // Validar el CVV (debe tener 3 dígitos)
      if (!/^\d{3}$/.test(cvv)) {
        alert("Ingrese un CVV válido con 3 dígitos.");
        return;
      }
      
      
        // Realiza aquí la lógica para procesar el pago
      alert("Procesando el pago con exito...");
      // Cierra el modal después de procesar el pago
  $("#paymentModal").modal('hide');
    });
  });
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    $('#Pagar').on('click', function() {
        // Obtén el ID del usuario desde PHP y otros datos necesarios
        var user_id = <?php echo json_encode($user_id); ?>;
        // Otros datos que puedas necesitar para la función InsertarCompra

        // Envía una solicitud AJAX al servidor
        $.ajax({
            type: 'POST',
            url: 'db/procesar_compra.php',
            data: {
                user_id: user_id,
                // Otros datos que necesitas pasar a la función InsertarCompra
            },
            success: function(response) {
                // Maneja la respuesta del servidor
                console.log(response);

                // Puedes redirigir a otra página o realizar otras acciones después del pago
            },
            error: function(error) {
                // Maneja los errores
                console.error(error);
            }
        });
    });
});
</script>






<script src="carrito.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
