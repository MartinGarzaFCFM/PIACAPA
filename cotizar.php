<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: Loginn.php");
    exit();
}

if (!isset($_GET['producto_id'])) {
    // Redirige a alguna página de manejo de error o a donde consideres apropiado
    header("Location: error.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_rol = $_SESSION['user_rol'];
$user_priv = $_SESSION['user_priv'];
// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";
echo "Tu rol es: $user_rol";
echo "Tu nivel de privacidad es: $user_priv";



// Obtener valores de la URL
$id_conversacion = isset($_GET['id_conversacion']) ? $_GET['id_conversacion'] : null;
$producto_id = $_GET['producto_id'];

// Verifica si conversacion_id está definido y no es 0 antes de imprimirlo
if (isset($id_conversacion) && $id_conversacion != 0) {
    echo "conversacion es: $id_conversacion";
} else {
    echo "conversacion no está definido o es 0";
}

echo "Tu producto: $producto_id";

//$remitente = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$destinatario = isset($_GET['id_usuario2']) ? $_GET['id_usuario2'] : null;
$remitente = isset($_GET['id_usuario1']) ? $_GET['id_usuario1'] : null;

echo "var remitentee =  $remitente";
echo "El destinatarioo es: $destinatario";

// Establece los valores adecuados para $producto_id, $vendedor_id y $cliente_id
$producto_id = isset($_GET['producto_id']) ? $_GET['producto_id'] : null;

// Dependiendo del rol del usuario, asigna valores a $vendedor_id y $cliente_id
if ($user_rol == 2) {
    // El usuario es un vendedor
    $vendedor_id = $user_id; // El vendedor es el usuario actual
    $cliente_id = $destinatario; // El cliente es el destinatario de la conversación
} else {
    // El usuario es un cliente
    $vendedor_id = $destinatario; // El vendedor es el remitente de la conversación
    $cliente_id = $user_id; // El cliente es el usuario actual
}

echo "Producto ID: $producto_id";
echo "Vendedor ID: $vendedor_id";
echo "Cliente ID: $cliente_id";



?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cotizar</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="cotizar.css">
</head>
<body>
<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
         <a class="navbar-brand"  href="index.html">
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
                  <a href="carrito.html" class="btn btn-outline-light">
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

<script>
  // Ahora puedes usar estas variables de JavaScript
 // Ahora puedes usar estas variables de JavaScript
 var remitente = <?php echo json_encode($remitente); ?>;
   // var mensaje = <php echo json_encode($mensaje); ?>;
    var id_conversacion = <?php echo json_encode($id_conversacion); ?>;
    var destinatario = <?php echo json_encode($destinatario); ?>;
    var producto_id = <?php echo json_encode($producto_id); ?>;
    // Convertir las cadenas JSON a objetos (si no son nulas)
    remitente = remitente !== 'null' ? JSON.parse(remitente) : null;
     //mensaje = mensaje !== 'null' ? JSON.parse(mensaje) : null;
    id_conversacion = id_conversacion !== 'null' ? JSON.parse(id_conversacion) : null;
    destinatario = destinatario !== 'null' ? JSON.parse(destinatario) : null;
    producto_id = producto_id !== 'null' ? JSON.parse(producto_id) : null;
    console.log('Valor de remitente:', remitente);
    // console.log('Valor de mensaje:', mensaje);
    console.log('Valor de id_conversacion:', id_conversacion);
    console.log('Valor de destinatario:', destinatario);
    console.log('Valor de producto:', producto_id);



/* SUPEEEEEEEEEEEEEEEEEEEEEER FUNCIONAAAAAAAAAAAAAAAL-------------------------------------------
 // Función para cargar los mensajes
 function cargarMensajes() {
        $.ajax({
            url: 'db/obtener_mensajes.php?id_conversacion=<php echo $id_conversacion; ?>',
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Limpiar el contenedor de mensajes
                $('#mensajesContainer').empty();

                // Mostrar cada mensaje en el contenedor
                for (var i = 0; i < data.length; i++) {
                    var mensaje = data[i];
                    var mensajeHTML = '<p>' + mensaje.MSJ_MENSAJE + '</p>';
                    $('#mensajesContainer').append(mensajeHTML);
                }
            },
            error: function () {
                console.error('Error al cargar los mensajes.');
            }
        });
    }*/
    function cargarMensajes() {
    $.ajax({
        url: 'db/obtener_mensajes.php?id_conversacion=<?php echo $id_conversacion; ?>',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            // Limpiar el contenedor de mensajes
            $('#mensajesContainer').empty();

            // Mostrar cada mensaje en el contenedor
            for (var i = 0; i < data.length; i++) {
                var mensaje = data[i];


                
                var mensajeHTML = '<div>';
                mensajeHTML += '<p><strong>USUARIO:</strong> ' + mensaje.MSJ_REMITENTE + '</p>';
                mensajeHTML += '<p><strong>Mensaje:</strong> ' + mensaje.MSJ_MENSAJE + '</p>';
                mensajeHTML += '<p><strong>Fecha y Hora:</strong> ' + mensaje.MSJ_FECHA + '</p>';
                mensajeHTML += '</div>';
                $('#mensajesContainer').append(mensajeHTML);
            }
        },
        error: function () {
            console.error('Error al cargar los mensajes.');
        }
    });
}

    // Llamar a la función para cargar los mensajes al cargar la página
    cargarMensajes();





/* SUPER FUNCIONAAAAAAAAAAAAL-----------------------------------------------
// Actualiza la lista de mensajes cada cierto intervalo
function actualizarMensajes() {
    $.ajax({
        url: 'db/obtener_mensajes.php?id_conversacion=<php echo $id_conversacion; ?>',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#mensajesContainer').empty();
            // Manejar la respuesta JSON y actualizar la interfaz
            // Puedes usar un bucle para recorrer los mensajes y agregarlos al contenedor
            // Por ejemplo:
            for (var i = 0; i < data.length; i++) {
                var mensaje = data[i].MSJ_MENSAJE;
                // Agrega el mensaje al contenedor
                $('#mensajesContainer').append('<div>' + mensaje + '</div>');
            }
        },
        error: function (error) {
            console.error('Error al obtener mensajes: ', error);
        }
    });
}

// Llama a la función cada 5 segundos (o el intervalo que prefieras)
setInterval(actualizarMensajes, 5000);  // 5000 milisegundos = 5 segundos

*/

// Actualizar la lista de mensajes cada cierto intervalo
function actualizarMensajes() {
    $.ajax({
        url: 'db/obtener_mensajes.php?id_conversacion=<?php echo $id_conversacion; ?>',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Limpiar el contenedor de mensajes
            $('#mensajesContainer').empty();

            // Mostrar cada mensaje en el contenedor
            for (var i = 0; i < data.length; i++) {
                var mensaje = data[i];
                var mensajeHTML = '<div>';
                mensajeHTML += '<p><strong>USUARIO:</strong> ' + mensaje.MSJ_REMITENTE + '</p>';
                mensajeHTML += '<p><strong>Mensaje:</strong> ' + mensaje.MSJ_MENSAJE + '</p>';
                mensajeHTML += '<p><strong>Fecha y Hora:</strong> ' + mensaje.MSJ_FECHA + '</p>';
                mensajeHTML += '</div>';
                $('#mensajesContainer').append(mensajeHTML);
            }
        },
        error: function (error) {
            console.error('Error al obtener mensajes: ', error);
        }
    });
}

// Llama a la función cada 5 segundos (o el intervalo que prefieras)
setInterval(actualizarMensajes, 5000);  // 5000 milisegundos = 5 segundos




</script>

<div class="container-chat">
    <h1>Chat en línea</h1>
    <div class="chat-box" id="chatBox">
    <div id="mensajesContainer"></div>

    </div>
    <!--<input type="text" id="messageInput" placeholder="Escribe un mensaje...">-->
    <!-- <button id="sendButton">Enviar</button>-->
    
    
     <!-- Formulario para enviar el mensaje -->
     <form id="messageForm" action="db/enviar_mensaje.php" method="post">
        <!-- Campo de mensaje -->
        <input type="text" name="mensaje" id="mensajeInput" placeholder="Escribe un mensaje..." required>

        <!-- Campos ocultos para los valores del chat -->
        <input type="hidden" name="remitente" value="<?php echo $remitente; ?>">
        <input type="hidden" name="conversacion_id" value="<?php echo $id_conversacion; ?>">
        <input type="hidden" name="destinatario" value="<?php echo $destinatario; ?>">
        <input type="hidden" name="producto" value="<?php echo $producto_id; ?>">
        <!-- Botón para enviar el formulario -->
        <input type="submit" class="button" name="Registermsj" id="Registermsj" value="Enviarr">
        <!--<button type="submit">Enviar</button>-->
    </form>
   
<!-- producto cotizable -->
<?php if ($user_rol == 2): ?>
    
    <form name= "form" method="POST" action="./db/CotizadoProdu.php" id="signupForm" enctype="multipart/form-data";>
   
       <!-- Agrega campos ocultos para enviar los valores -->
       
    <input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>">
    <input type="hidden" name="vendedor_id" value="<?php echo $vendedor_id; ?>">
    <input type="hidden" name="cliente_id" value="<?php echo $cliente_id; ?>">
    <div class="product-info">
        <h2> Cotización</h2>
        <div class="ID_PRO">
        <label for="ID_PRO">producto:</label>
            <input type="text" id="ID_PRO" name= "ID_PRO" placeholder="Ingrese cantidad "> 
        
        </div>

        <div class="productMeasure">
        <label for="productMeasure">Medida:</label>
        <input type="text" id="productMeasure"  name= "productMeasure" placeholder="Ingrese la medida">

       
        </div>

        <div class="productMaterials">
        <label for="productMaterials">Material:</label>
        <input type="text" id="productMaterials" name= "productMaterials" placeholder="Ingrese los materiales">
        
        </div>

        <div class="productPRECIO">
        <label for="productPRECIO">precio:</label>
            <input type="text" id="productPRECIO"  name= "productPRECIO" placeholder="Ingrese PRECIO "> 
        
        </div>

        <div class="productCANTIDAD">
        <label for="productCANTIDAD">cantidad:</label>
            <input type="text" id="productCANTIDAD" name= "productCANTIDAD" placeholder="Ingrese cantidad "> 
        
        </div>
        
        
        <label for="productFlete">¿Requiere flete?</label>
        <input type="checkbox" id="productFlete">
        <input type="submit" name="sendProductInfo" id="sendProductInfoBtn" value="Enviar información del producto">
    </div>
    </form>
    <?php
// Verifica si el producto_id está definido y no es nulo
if (isset($producto_id) && $producto_id !== null) {
    ?>
    <script>
        //aqui cambie codigo reciente   
       // console.log('Valor de producto_id:', producto_id);
        //var producto_id = document.querySelector('input[name="producto"]').value; 
        console.log('Valor de producto_id:',  <?= $producto_id; ?>);
        var producto_id_js = <?= $producto_id; ?>;
       

<?php
include_once 'db/consulta.php';
$consulta = new consulta();

$infoProductoCotizado = $consulta->ObtenerInformacionProductoCotizado($producto_id);

// Agrega un console.log para imprimir los resultados
echo 'console.log("Resultados:", ' . json_encode($infoProductoCotizado) . ');';

// Verifica si se obtuvieron resultados
// Verifica si se obtuvieron resultados
if (!empty($infoProductoCotizado)) {
    // Accede a cada conjunto de resultados
    $infoCotizado = isset($infoProductoCotizado[0]) ? $infoProductoCotizado[0] : array();
    echo 'console.log("Info Cotizado:", ' . json_encode($infoCotizado) . ');';

    // Ejemplo de cómo acceder a los datos
    $medida = isset($infoCotizado[0]['PRO_MEDIDAS']) ? $infoCotizado[0]['PRO_MEDIDAS'] : '';
    $materiales = isset($infoCotizado[0]['PRO_MATERIAL']) ? $infoCotizado[0]['PRO_MATERIAL'] : '';
    $PRO_PRECIOUNITARIO = isset($infoCotizado[0]['PRO_PRECIOUNITARIO']) ? $infoCotizado[0]['PRO_PRECIOUNITARIO'] : '';
    $PRO_CANTIDAD = isset($infoCotizado[0]['PRO_CANTIDAD']) ? $infoCotizado[0]['PRO_CANTIDAD'] : '';
    $producto_id = isset($infoCotizado[0]['ID_PRO']) ? $infoCotizado[0]['ID_PRO'] : '';
    // Asigna los valores a los campos
    //  echo 'document.getElementById("productMeasure").value = "' . $medida . '";';
    //  echo 'document.getElementById("productMaterials").value = "' . $materiales . '";';
   //   echo 'document.getElementById("productPRECIO").value = "' . $PRO_PRECIOUNITARIO . '";';
   //   echo 'document.getElementById("productCANTIDAD").value = "' . $PRO_CANTIDAD . '";';
      echo 'document.getElementById("ID_PRO").value = "' . $producto_id . '";';
}
?>
    </script>
    
    <?php
}
?>
<?php endif; ?>
</div>

<?php if ($user_rol == 1): ?>
    
    <input type="submit" name="clienteboton" id="clienteboton" value="Enviar información del producto a cliente">
<!--
    <script>
        // Muestra un alert específicamente para el rol 1
       // alert('¡Bienvenido, cliente! Una vez acordado tus parametro del producto cotizado cuando el vendedor lo cree este producto se reflejara en tu carrito y este tendra una duracion en tu carrito si no lo compras se borrara de tu carrito.');
    </script>
-->

    <?php endif; ?>

<script>
    $(document).ready(function() {
        // Verifica si se hizo clic en sendProductInfo y el usuario es un cliente
        console.log('send_product_info_clicked:', <?php echo json_encode($_SESSION['send_product_info_clicked']); ?>);
        console.log('user_rol:', <?php echo json_encode($_SESSION['user_rol']); ?>);

        <?php if ($_SESSION['send_product_info_clicked'] && $_SESSION['user_rol'] == 1): ?>
            // Muestra el botón del cliente
            $('#clienteboton').show();
        <?php endif; ?>

        // Restablece la variable de sesión send_product_info_clicked después de usarla
        <?php $_SESSION['send_product_info_clicked'] = false; ?>
    });
</script>



<!--<script src="script.js"></script>-->

<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>

<!--<script src="https://kit.fontawesome.com/a076d05399.js"></script>-->
</body>
</html>
