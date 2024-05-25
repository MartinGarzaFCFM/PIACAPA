
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Land Page</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="Landpage.css">
</head>
<body>
<!-- Barra superior -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="Landpage.php">
        <img src="logo_minimarket.png" alt="Logo" width="40" height="40">
      </a>
     
      <div class="ml-auto">
        <a class="btn btn-outline-light mx-2" href="db/Login.php">Inicio sesion</a>
      
      </div>
    </div>

  </nav>
    <!-- Contenido principal -->
    <div class="container text-center mt-5">
      <div id="imageCarousel" class="carousel slide" data-ride="carousel" class="carousel-container">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="tienda-en-linea.png" class="d-block w-100 carousel-image" alt="Imagen 1">
          </div>
          <div class="carousel-item">
            <img src="imagen2.jpg" class="d-block w-100 carousel-image" alt="Imagen 2">
          </div>
          <div class="carousel-item">
            <img src="imagen3.jpeg" class="d-block w-100 carousel-image" alt="Imagen 3">
          </div>
          <!-- Agrega más imágenes según sea necesario -->
        </div>
        <!-- Controles de navegación -->
        <a class="carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>
      </div>
    </div>
    <div class="container text-center content-container">
      <h1 class="mt-4">¡Bienvenido a Nuestra Tienda en Línea!</h1>
      <p>Explora nuestra amplia selección de productos.</p>
      <a href="db/Login.php" class="btn btn-primary">Iniciar sesión o registrarse</a>
    </div>
   
    
    <br>
<!-- Footer -->
<footer>
  <div class="container text-center">
      <p>Derechos de autor © 2023 Mi Tienda en Línea. Todos los derechos reservados.</p>
  </div>
</footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
