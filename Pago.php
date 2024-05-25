
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pago</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
<link rel="stylesheet" href="Pago.css">
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
        var categoryMenu = $('#categoryMenu');

        // Recorrer las categorías y crear elementos de lista antes era categoryName
        data.forEach(function(category) {
            var categoryLink = $('<a class="dropdown-item" href="#">' + category  + '</a>');

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
                <?php include 'menu.php'; ?>
                  
              
            </div>
            
        </div>
        
    </div>
    
</nav>




<div class="container-pago mt-5">
    <div class="row"></div>
    <div class="col-md-8 mx-auto">

    <h2>Formulario de Pago</h2>
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

<script src="Pago.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
