
<?php
session_start();

include_once "consulta.php"; // Asegúrate de que la ruta sea correcta

if (!isset($_SESSION['id'])) {
    // Haz algo si no existe una sesió
}

if (!isset($_SESSION['rol'])) {
    // Haz algo si no existe el rol en la sesión
}

if (!isset($_SESSION['Privacidad'])) {
    // Haz algo si no existe la privacidad en la sesión
    
}

// Comprobar si se envió el formulario de inicio de sesión
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $consulta = new consulta();
    $usuarioDB = $consulta->VerificarCredenciales($usuario, $password);

    if ($usuarioDB) {
        // Verificar si el usuario está marcado como eliminado
        if ($usuarioDB['estado'] == 0) {
            // El usuario está autenticado y no está marcado como eliminado

            // Aquí podrías llamar a la función que valida la contraseña si lo deseas
            // $resultadoContrasena = $consulta->validarContrasena($password);

            // Si la contraseña cumple con tus requisitos, procedes
            // if ($resultadoContrasena === "Contraseña válida") {
            $_SESSION['usuario'] = $usuarioDB;
            $_SESSION['user_id'] = $usuarioDB['id'];
            $_SESSION['user_rol'] = $usuarioDB['rol'];
            $_SESSION['user_priv'] = $usuarioDB['Privacidad'];
         
            header("Location: ../Home.php");
            exit();
            // } else {
            //     echo "<script language='JavaScript'>
            //     alert('$resultadoContrasena');
            //     location.assign('Login.php');
            //     </script>";
            // }
        } else {
            // Usuario eliminado, no permitir el inicio de sesión
            echo "<script language='JavaScript'>
              alert('El usuario ha sido eliminado y no puede iniciar sesión.');
              location.assign('Login.php');
              </script>";
        }
    } else {
        // Las credenciales son incorrectas
        echo "<script language='JavaScript'>
              alert('Credenciales incorrectas');
              location.assign('Login.php');
              </script>";
        session_destroy();
    }
}
?>



















<!--include_once 'consulta.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

class nombres {
    function iniciarSesion($usuario, $contrasena) {
        $consulta = new consulta();
        echo "Usuario: $usuario, Contraseña: $contrasena"; 
        $usuarioDB = $consulta->verificarCredenciales($usuario, $contrasena);
        var_dump($usuarioDB);
        if ($usuarioDB) {
           
            session_start();
            $_SESSION['usuario'] = $usuarioDB['usuario'];
            $_SESSION['id'] = $usuarioDB['id'];
            header('Location: ../Home.php'); 
            exit();
        } else {
            
            echo " <script language='JavaScript'>
            alert('Credenciales incorrectas');
            location.assign('Login.php'); 
            </script>";
        }
    }
}-->
