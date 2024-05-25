<?php 
  session_start();
  include_once "../db.php";
 
  if(!isset($_SESSION['id'])){
    
  }
  if(!isset($_SESSION['rol'])){ //nuevo 11
    
  }
  if(!isset($_SESSION['Privacidad'])){//nuevo 11
    
  }





?>








<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="Login.css">
</head>
<body>

  <!-- Formulario de inicio de sesión -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="text-center mb-4">
            <img src="../logo_minimarket.png" alt="Logo" width="80" height="80">
          </div>
          <div class="card-header">
            Iniciar sesión
          </div>
      
    
          <div class="card-body">
       <!--   <header>Login</header>-->
            <form name= "form" autocomplete="off"  method="POST" action="api_sesion.php" id="loginForm">

           <!--    <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input name='email' type="email" class="form-control" id="email" placeholder="Ingrese su correo electrónico" required>
              </div>-->
              <div class="form-group">
                <label for="username">Nombre de usuario</label>
                <input name ="usuario" type="text" class="form-control" id="username"   placeholder="Ingrese su nombre de usuario" required>
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input name= "password" type="password" class="form-control" id="password"  placeholder="Ingrese su contraseña" required>


              </div>
              
              <input type="submit" onclick="login()" class="button" name="login" value="Entrar">
             <!-- <button type="submit" onclick="login()" name= 'ingresar'class="btn btn-primary text-center" id="continueBtn">Continuar</button>
             <button type="submit" class="btn btn-primary  text-center">Continuar</button>-->
              <br> 
           
              <div class="registro">
                
                <p class="text-center mt-2">¿Eres nuevo en Mi tienda?</p>
                <a href="../Registro.php" class="btn btn-link btn-lg text-center">Registrate</a>
                
              </div>

              
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="../login.js"></script>
  
</body>
</html>
