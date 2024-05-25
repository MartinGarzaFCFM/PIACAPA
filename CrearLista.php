




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear listas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="CrearLista.css">
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

                <?php include 'menu.php'; ?>
              
            </div>
        </div>
    </div>
</nav>
<div class="container-Lista mt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h2>Mis Listas</h2>
        
            <form name="form" method="POST" action="./db/Lista.php" id="signupForm" enctype="multipart/form-data">
            
           <!-- <form id="registroForm">-->
                <div class="form-group">
                    <label for="nombreLista">Nombre de la Lista</label>
                    <input type="text" class="form-control" name="nombreLista" id="nombreLista" placeholder="Ingrese el nombre de la lista">
                </div>
                <div class="form-group">
                    <label for="descripcionLista">Descripción de la Lista</label>
                    <textarea class="form-control" name="descripcionLista" id="descripcionLista" rows="3" placeholder="Ingrese la descripción de la lista"></textarea>
                </div>
                <div class="form-group">
                    <label for="tipoLista">Tipo de Lista</label>
                    <select class="form-control" id="tipoLista" name="tipoLista">
                        <option value="1">Pública</option>
                        <option value="2">Privada</option>
                    </select>
                </div>
                <input type="submit" class="button" name="RegisterLista" id="RegisterLista" value="Agregar Lista">
                <!--<button type="submit" class="btn btn-primary">Crear Lista</button>-->
              
            </form>
        </div>
    </div>
</div>

<script src="CrearLista.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
