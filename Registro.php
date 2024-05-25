
<?php

//include 'api.php';

	//$obj = new nombres();


?>




<!-- Registro.html -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Cuenta</title>
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
            Crear Cuenta
          </div>
          <div class="card-body">

        <!--    <header>Registro</header>-->
            <form name="form" method="POST" action="./db/api.php" id="signupForm" onsubmit="return registro();" enctype="multipart/form-data">  
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" class="form-control" name= "email" id="email" placeholder="Ingrese su correo electrónico" required
                title="único">
              </div>
              <div class="form-group">
                <label for="username">Nombre de usuario</label>
                <input type="text" class="form-control" name= "username" id="username" placeholder="Ingrese su nombre de usuario" required
                title="Minimo 3 caracteres, único">
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" name= "password" id="password" placeholder="Ingrese su contraseña" required 
                title="La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.">
              </div>
              <div class="form-group">
                <label for="password-confirm">Confirmar Contraseña</label>
                <input type="password" class="form-control" name= "password-confirm" id="password-confirm" placeholder="Confirme su contraseña" required>
            </div>
            
              <div class="form-group">
                <label for="role">Rol de usuario</label>
                <select class="form-control" id="role"  name="rol" required>
                  <option value="" disabled selected>Seleccione un rol</option>
                  <option value="Vendedor">Vendedor</option>
                  <option value="Cliente">Cliente</option>
                <!-- <option value="admin">Administrador</option>--> 
                </select>
                
              </div>
              <label for="privacidad">Privacidad:</label>
              <select id="Privacidad" name="Privacidad" required>
              <option value="" disabled selected>Selecciona tu privacidad</option>
              <option value="0">Público</option>
              <option value="1">Privado</option>
              </select>
              <div class="form-group">
                <label for="avatar">Imagen tipo avatar</label>
                <input type="file" class="form-control-file" name= "avatar" id="avatar" accept="image/*">
              </div>
              <div class="form-group">
                <label for="fullname">Nombre Completo</label>
                <input type="text" class="form-control"name= "fullname" id="fullname" placeholder="Ingrese su nombre completo" required>
              </div>
              <div class="form-group">
                <label for="birthdate">Fecha de nacimiento</label>
                <input type="date" class="form-control" name= "birthdate" id="birthdate" required>
              </div>
              <div class="form-group">
                <label for="gender">Sexo</label>
                <select class="form-control"  id="gender" name="gender" required>
                  <option value="" disabled selected>Seleccione su sexo</option>
                  <option value="Masculino">Masculino</option>
                  <option value="Femenino">Femenino</option>
                 
                </select>
              </div>
              <!--<input type="submit"onclick="registro()" class="button" name="registro" value="Registrarse">-->
             
              <!--<input type="button" class="button" name="registro" value="Registrarse" id="registroBtn">-->

            <!-- <button type="submit" class="button" name="registro" value="Registrarse"  id="continueBtn">Continuar</button>-->
            <input type="submit" class="button" name="registro" value="Registrarse">
             
            </form>



            <div class="signup">
          <span class="signup">¿Ya tienes una cuenta?
           <a href='db/Login.php' for="check">Iniciar sesion</a>
        </div>




          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!--<script src="Registro.js"></script>-->
  
<script src="login.js"></script>
    
</body>
</html>
