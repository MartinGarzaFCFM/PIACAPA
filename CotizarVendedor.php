<?php
session_start();
include_once 'db/consulta.php';
if (!isset($_SESSION['user_id'])) {
    // El usuario no ha iniciado sesión o la sesión ha expirado
    // Puedes redirigirlo a la página de inicio de sesión u otra acción adecuada.
    header("Location: Loginn.php");
    exit();
}
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$user_id = $_SESSION['user_id'];
$user_rol = $_SESSION['user_rol'];
$user_priv = $_SESSION['user_priv'];
// Ahora puedes usar $user_id para mostrar la información o realizar otras acciones
echo "¡Bienvenido! Tu ID de usuario es: $user_id";
echo "Tu rol es: $user_rol";
echo "Tu nivel de privacidad es: $user_priv";

$consultas = new consulta();
// eNUEVOOOOOOOOOOOOOO---------------------------------------------------------- user_id
$conversaciones = $consultas->obtenerConversaciones($user_id);
//$conversaciones = $consultas->obtenerConversaciones();

// Ahora $conversaciones contiene la información de todas las conversaciones
// Puedes iterar sobre este array para mostrar la información en tu interfaz
foreach ($conversaciones as $conversacion) {
    // Haz algo con cada conversación, por ejemplo, imprímela
   // echo 'Conversación ID: ' . $conversacion['id_conversacion'] . '<br>';
   // echo 'Remitente: ' . $conversacion['RemitenteNombre'] . '<br>';
   // echo 'Destinatario: ' . $conversacion['DestinatarioNombre'] . '<br>';
   // echo 'Producto: ' . $conversacion['ProductoNombre'] . '<br>';
   // echo 'Producto:ID ' . $conversacion['producto_id'] . '<br>';
   // echo '------------------------<br>';
}


// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$consultas = new consulta();
$datosCotizacionesVencidas = $consultas->vista_para_eliminar_el_cotizado($user_id);

if (isset($_POST['eliminar_cotizacion_id'])) {
    $cotizacion_id = $_POST['eliminar_cotizacion_id'];
    $consulta = new consulta();

    // Llamada al procedimiento almacenado
    $query = $consulta->connect()->prepare("CALL GestionarCotizacionesVencidas(@cotizacion_id)");
    $query->execute();

    // Recuperar el valor del parámetro de salida
    $outputQuery = $consulta->connect()->query("SELECT @cotizacion_id AS cotizacion_id");
    $output = $outputQuery->fetch(PDO::FETCH_ASSOC);

    $cotizacion_id_afectada = $output['cotizacion_id'];

    // Manejar el valor recuperado según tus necesidades
    if ($cotizacion_id_afectada > 0) {
        echo 'Cotización vencida gestionada. ID de la cotización afectada: ' . $cotizacion_id_afectada;
    } else {
        echo 'No hay cotizaciones vencidas para gestionar.';
    }
}
// ////////////////////////////////////////////////////////////////////////////////////////////////////////////////

?>
<script>
// Pasa el valor de $user_id a una variable JavaScript
var user_id = <?php echo json_encode($user_id); ?>;
// Resto de tu código JavaScript aquí
</script>

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
         <a class="navbar-brand"  href="home.html">
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



<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Mis conversaciones</h2>
            
            <ul class="list-group" id="misconversaciones">
           <!-- Ejemplo de lista -->
           <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#" class="lista-item" data-id="1">Lista de conversacion</a>
        </li>
        <!-- Agregar más listas aquí -->
    </ul>
    </div>

<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <h2>Mis cotizaciones vencidas</h2>
            
            <ul class="list-group" id="Miscotizacionesvencidas">
                <!-- Verifica si hay datos antes de intentar iterar -->
                <?php if ($datosCotizacionesVencidas !== null && is_array($datosCotizacionesVencidas)): ?>
                    <!-- Itera sobre los resultados de las cotizaciones vencidas -->
                    <?php foreach ($datosCotizacionesVencidas as $cotizacion): ?>
                        <li class="list-group-item">
                            <strong>ID Cotización:</strong> <?php echo $cotizacion['ID_COTI']; ?><br>
                            <strong>Vendedor:</strong> <?php echo $cotizacion['Vendedor']; ?><br>
                            <strong>Cliente:</strong> <?php echo $cotizacion['Cliente']; ?><br>
                            <strong>ID Producto:</strong> <?php echo $cotizacion['ID_PRO']; ?><br>
                            <strong>Fecha Cotización:</strong> <?php echo $cotizacion['FECHA_COTIZACION']; ?><br>
                            <strong>Fecha Agregado al Carrito:</strong> <?php echo $cotizacion['CARR_FECHA_AGREGADO']; ?><br>
                            <strong>Fecha de Caducidad:</strong> <?php echo $cotizacion['PRO_CADUCIDAD']; ?><br>
                            <!-- Agrega más campos según sea necesario -->
                             <!-- Agrega aquí el botón o acción específica para productos normales -->
                             <form method="post" action="CotizarVendedor.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta cotización?');">
                                <input type="hidden" name="eliminar_cotizacion_id" value="<?php echo $cotizacion['ID_COTI']; ?>">
                                <button type="submit" class="btn btn-danger btn-eliminar">Eliminar</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="list-group-item">No hay cotizaciones vencidas.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>


<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

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
      <!--  <input type="text" name="mensaje" id="mensajeInput" placeholder="Escribe un mensaje..." required>
-->
        <!-- Campos ocultos para los valores del chat -->
        <input type="hidden" name="remitente" value="<?php echo $remitente; ?>">
        <input type="hidden" name="conversacion_id" value="<?php echo $id_conversacion; ?>">
        <input type="hidden" name="destinatario" value="<?php echo $destinatario; ?>">
        <input type="hidden" name="producto" value="<?php echo $producto_id; ?>">
        <!-- Botón para enviar el formulario -->
        <!-- <input type="submit" class="button" name="Registermsj" id="Registermsj" value="Enviarr">-->
        <!--<button type="submit">Enviar</button>-->
    </form>
    
    <!-- producto cotizable -->
   <!--  <div class="product-info">
        <h2> Cotización</h2>
        <label for="productMeasure">Medida:</label>
        <input type="text" id="productMeasure" placeholder="Ingrese la medida">
        <label for="productMaterials">Materiales:</label>
        <input type="text" id="productMaterials" placeholder="Ingrese los materiales">
        <label for="productFlete">¿Requiere flete?</label>
        <input type="checkbox" id="productFlete">
        <button id="sendProductInfo">Pase</button>
    </div> -->
</div>

<!-- PHP: Cargar conversaciones iniciales -->


<script>
$(document).ready(function () {
    var conversacionesContainer = $('#misconversaciones');
    var user_id = <?php echo json_encode($user_id); ?>;
    // Carga inicial de conversaciones
    $.ajax({
        url: 'db/Obtener_mensajesVendedor.php?id_conversacion',
        method: 'GET',
        dataType: 'json',
        data: { user_id: user_id }, // eNUEVOOOOOOOOOOOOOO---------------------------------------------------------- user_id
        success: function (data) {
            if (Array.isArray(data)) {
    data.forEach(function (conversacion) {
        var conversacionHTML = `
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="#" class="conversacion-item" data-id="${conversacion.id_conversacion}" data-producto-id="${conversacion.producto_id}" data-usuario1="${conversacion.usuario1}" data-usuario2="${conversacion.usuario2}">Conversación ${conversacion.id_conversacion}</a>
        </li>
        `;
        conversacionesContainer.append(conversacionHTML);
    });
            } else {
                console.error('La respuesta JSON no es un array:', data);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error obtaining conversations:');
            console.log('Status:', status);
            console.log('Error:', error);
            console.log('Response Text:', xhr.responseText);
        }
    });
    
//$user_id = $_SESSION['user_id'];;
    // Añade un manejador de clic al contenedor de conversaciones
    conversacionesContainer.on('click', '.conversacion-item', function (event) {
        event.preventDefault();
        var conversacionId = $(this).data('id');
        console.log('Conversation item clicked with ID:', conversacionId);
         // Obtén los valores necesarios de la conversación
         var productoId = $(this).data('producto-id');
    var usuario1 = $(this).data('usuario1');
    var usuario2 = $(this).data('usuario2');

    var idRemitente, idDestinatario;

if (user_id === usuario1) {
    idRemitente = usuario1;
    idDestinatario = usuario2;
} else {
    idRemitente = usuario2;
    idDestinatario = usuario1;
}

     // Construye el URL con los parámetros necesarios
var url = 'cotizar.php?id_conversacion=' + conversacionId + '&producto_id=' + productoId + '&id_usuario1=' + idRemitente + '&id_usuario2=' + idDestinatario;

  window.location.href = url;

        // Imprimir el valor de id_conversacion en la consola
        console.log('Valor de id_conversacion:', conversacionId);
        console.log('id_usuario1:', usuario1);
console.log('id_usuario2:', usuario2);
        // Puedes agregar más lógica aquí para manejar el clic en una conversación
        // Por ejemplo, cargar los mensajes de esa conversación.
    });
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