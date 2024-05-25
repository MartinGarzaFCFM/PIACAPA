<?php

session_start();
// Verifica si la sesión está configurada y si las claves existen en el array
if (isset($_SESSION['usuario']) && isset($_SESSION['usuario']['rol']) && isset($_SESSION['usuario']['Privacidad'])) {
  // Accede a los valores de rol y Privacidad de manera segura
  $rol = $_SESSION['usuario']['rol'];
  $privacidad = $_SESSION['usuario']['Privacidad'];
  

  echo "Rol: $rol";
  echo "Privacidad: $privacidad";
} else {
 
  //echo "Los datos de usuario no están disponibles.";
}

?>

<!-- Registro.html -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modificar</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<link rel="stylesheet" href="Registro.css">
</head>
<body>

  <!-- Formulario de creación de cuenta -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="text-center mb-4">
            <img src="logo_minimarket.png" alt="Logo" width="80" height="80">
          </div>
          <div class="card-header">
            Modificar Perfil
          </div>
          <div class="card-body">

        <!--    <header>Registro</header>-->
            <form  name= "form" method="POST" action="./db/api.php" id="signupForm" onsubmit="return validarModificacion()">
              <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" name= "emailP" id="emailP" value="<?php echo $_SESSION['usuario']['correo'];?>" placeholder="Ingrese su correo electrónico" required
                title="único">
              </div>
              <div class="form-group">
                <label for="username">Nombre de usuario</label>
                <input type="text" class="form-control" name= "usernameP" id="usernameP"  value="<?php echo $_SESSION['usuario']['usuario'];?>" placeholder="Ingrese su nombre de usuario" required
                title="Minimo 3 caracteres, único">
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name= "passwordP" id="passwordP" value="<?php echo $_SESSION['usuario']['contrasena'];?>" placeholder="Ingrese su contraseña" required 
                title="La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.">
              </div>
              <div class="form-group">
                <label for="password-confirm">Confirmar Contraseña</label>
                <input type="password" class="form-control" name= "password-confirmP" id="password-confirmP" placeholder="Confirme su contraseña" required>
            </div>
            
              
              <!--   <div class="form-group">
                <label for="avatar">Imagen tipo avatar</label>
                <input type="file" class="form-control-file" name= "avatarP" id="avatarP" accept="image/*">
              </div>-->
              <div class="form-group">
                <label for="fullname">Nombre Completo</label>
                <input type="text" class="form-control"name= "fullnameP" id="fullnameP"  value="<?php echo $_SESSION['usuario']['Nombre'];?>" placeholder="Ingrese su nombre completo" required>
              </div>
              <div class="form-group">
                <label for="birthdate">Fecha de nacimiento</label>
                <input type="date" class="form-control" name= "birthdateP" id="birthdateP" value="<?php echo $_SESSION['usuario']['nacimiento'];?>"  required>
              </div>
              
              <input type="submit" class="button" id="modificar" name="modificar" value="Editar">
            
            </form>



            




          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!--<script src="Registro.js"></script>-->
  
<script src="PerfilModificar.js"></script>
    
</body>
</html>
