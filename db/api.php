<?php 
/////////////////////////

	include_once 'consulta.php';

	class nombres{

		function obtenerNombres()
		{
			$nombres = new consulta();
			$arrNombres = array();
			$arrNombres["Resultados"] = array();

		$res = $nombres->getNames($_POST['id']);



		if($res != NULL)
		{
			while($row = $res->fetch(PDO::FETCH_ASSOC))
			{
				$obj = array(
					"id" => $row['id'],
					"usuario"  => $row['usuario'],
					"correo" => $row['correo'],
					"Nombre" => $row['Nombre'],
					"nacimiento" => $row['nacimiento'],
					"sexo" => $row['sexo'],
					"creacion" => $row['creacion']
				); 
				array_push($arrNombres["Resultados"], $obj);
			}
			
			echo json_encode($arrNombres);
			
			
		}else
			{
				echo json_encode(array('mensaje' => 'No hay elementos'));
			}
		}



      // ... tu código existente ...

function registrarUsuario(){
    $nombres = new consulta();
    $arrNombres = array();
    $arrNombres["Resultados"] = array();

    // Verificar si se ha enviado un archivo
    if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        // Ruta donde se guardará la imagen (ajústala según tu estructura de carpetas)
        $rutaImagen = 'Imagenes/' . $_FILES['avatar']['name'];

        // Mover el archivo desde la ubicación temporal a la ruta deseada
        move_uploaded_file($_FILES['avatar']['tmp_name'], $rutaImagen);

        // Ahora $rutaImagen contiene la ruta donde se guarda la imagen, y puedes almacenar esta ruta en tu base de datos
        // Además, puedes realizar otras operaciones relacionadas con la base de datos
        $res = $nombres->registro(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $rutaImagen, // Guardar la ruta de la imagen en la base de datos
            $_POST['fullname'],
            $_POST['birthdate'],
            $_POST['gender'],
            $_POST['rol'],
            $_POST['Privacidad']
        );
    } else {
        // Manejar el caso en que no se ha enviado una imagen
        echo "Error: No se ha enviado una imagen.";
    }
}

// ... tu código existente ...




        function modificar(){

            $nombres = new consulta();
		
	

		$res = $nombres->modificar($_POST['usernameP'], $_POST['passwordP'], $_POST['emailP'],$_POST['birthdateP'], $_POST['fullnameP']);
        
		$arrdatos = array(
			"id" => $_SESSION['usuario']['id'],
			"Nombre" => $_POST['fullnameP'],
			"contrasena" => $_POST['passwordP'],
			"correo" => $_POST['emailP'],
			"sexo" => $_SESSION['usuario']['sexo'],
			"usuario" => $_POST['usernameP'],
			"nacimiento" => $_POST['birthdateP'],
			"creacion" => $_SESSION['usuario']['creacion'],
		);

		$_SESSION['usuario'] = $arrdatos;

		

        }


		function eliminarUsuario($id) {
			$nombres = new consulta();
			// Realiza una actualización en la base de datos para marcar al usuario como eliminado (estado = 1)
			$res = $nombres->eliminarUsuario($id);
		
			if ($res) {
				echo "Usuario eliminado exitosamente.";
			
			} else {
				echo "Error al eliminar el usuario.";
			}
		}
		







	}
	

	if (isset($_POST['registro'])) {
		$email = $_POST['email'];
		$username = $_POST['username'];
		$consulta = new consulta(); // Crea una instancia de la clase consulta
	
		// Verificar si el correo ya existe
		$correoExistente = $consulta->getCorreoExistente($email);
	
		// Verificar si el usuario ya existe
		$usuarioExistente = $consulta->getUsuarioExistente($username);
	
		if ($correoExistente) {
		
			echo "<script type='text/javascript'>alert('El correo ya está registrado. Por favor, utiliza otro correo.');</script>";
			echo "<script type='text/javascript'>window.location.href = '../Registro.php';</script>";
		} elseif ($usuarioExistente) {
			

			echo "<script type='text/javascript'>alert('El nombre de usuario ya está en uso. Por favor, elige otro nombre de usuario.');</script>";
			echo "<script type='text/javascript'>window.location.href = '../Registro.php';</script>";
		} else {
			// Si no existen registros con el mismo correo y usuario, procede con el registro
			$fullname = $_POST['fullname'];
			$password = $_POST['password'];
			$birthdate = $_POST['birthdate'];
	
			if (
				!filter_var($email, FILTER_VALIDATE_EMAIL) ||
				!preg_match('/^[A-Za-z ]+$/', $fullname) ||
				strlen($username) < 3 ||
				!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/', $password) ||
				empty($birthdate) ||
				!DateTime::createFromFormat('Y-m-d', $birthdate)
			) {
			
				echo "<script type='text/javascript'>alert('Error en los datos ingresados. Verifica la información.');</script>";
				echo "<script type='text/javascript'>window.location.href = '../Registro.php';</script>";
			} else {
				// Procede con el registro
				$obj = new nombres();
				$obj->registrarUsuario();
	
				echo "Registro exitoso. Redirigiendo a la página de inicio de sesión...";
				echo "<script type='text/javascript'>alert('Usuario registrado exitosamente.'); window.location.assign('login.php');</script>";
			}
		}
	}
	


	/*
	if (isset($_POST['registro'])) {
		

		$email = $_POST['email'];
		$fullname = $_POST['fullname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$birthdate = $_POST['birthdate'];
	
		if (
			!filter_var($email, FILTER_VALIDATE_EMAIL) || 
			!preg_match('/^[A-Za-z ]+$/', $fullname) || 
			strlen($username) < 3 || 
			!preg_match('/^(?=.*\d)(?=.*\W+)(?=.*[A-Z])(?=.*[a-z]).{8,}$/', $password) || 
			empty($birthdate) || 
			!DateTime::createFromFormat('Y-m-d', $birthdate)
			
		) {
			// Si alguna de las validaciones falla, no registr al usuario
			echo "Error en los datos ingresados. Verifica la información.";
		} else {
	
	$obj = new nombres();
	$obj->registrarUsuario();
			
			echo "Registro exitoso. Redirigiendo a la página de inicio de sesión...";
		
			echo "<script type='text/javascript'>alert('Usuario registrado exitosamente.'); window.location.assign('login.php');</script>";
		}
	}*/
	
	/*if (isset($_POST['modificar'])) {
		$email = $_POST['emailP'];
		$fullname = $_POST['fullnameP'];
		$username = $_POST['usernameP'];
		$password = $_POST['passwordP'];
		$birthdate = $_POST['birthdateP'];
		$_SESSION= ['id'];
 // Supongamos que guardas el ID del usuario en una sesión al iniciar sesión
	
		if (
			!filter_var($email, FILTER_VALIDATE_EMAIL) || 
			!preg_match('/^[A-Za-z ]+$/', $fullname) || 
			strlen($username) < 3 || 
			!preg_match('/^(?=.*\d)(?=.*\W+)(?=.*[A-Z])(?=.*[a-z]).{8,}$/', $password) || 
			empty($birthdate) || 
			!DateTime::createFromFormat('Y-m-d', $birthdate)
		) {
			// Muestra un mensaje de error y no modifica el perfil
			echo "<script type='text/javascript'>alert('Error en los datos ingresados. Verifica la información.');</script>";
			echo "<script type='text/javascript'>window.location.href = 'PerfilModificar.php';</script>";
		} else {
			$obj = new consulta();
	
			// Verificar si el correo ya existe en la base de datos, excluyendo al usuario actual
			if ($obj->getCorreoExistenteR($email, $user_id)) {
				echo "<script type='text/javascript'>alert('El correo ya está en uso.');</script>";
				echo "<script type='text/javascript'>window.location.href = 'PerfilModificar.php';</script>";
			}
	
			// Verificar si el nombre de usuario ya existe en la base de datos, excluyendo al usuario actual
			if ($obj->getUsuarioExistenteR($username, $user_id)) {
				echo "<script type='text/javascript'>alert('El nombre de usuario ya está en uso.');</script>";
				echo "<script type='text/javascript'>window.location.href = 'PerfilModificar.php';</script>";
			}
	
			// Si no existen duplicados, procede a modificar el perfil
			$obj->modificar();
	
			echo "Modificación exitosa. Redirigiendo a la página de perfil...";
			echo "<script type='text/javascript'>window.location.assign('../perfil.php');</script>";
		}
	}*/
	
	
	

	if (isset($_POST['modificar'])) {
		

		$email = $_POST['emailP'];
		$fullname = $_POST['fullnameP'];
		$username = $_POST['usernameP'];
		$password = $_POST['passwordP'];
		$birthdate = $_POST['birthdateP'];
	
		if (
			!filter_var($email, FILTER_VALIDATE_EMAIL) || 
			!preg_match('/^[A-Za-z ]+$/', $fullname) || 
			strlen($username) < 3 || 
			!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!]).{8,}$/', $password) || 
			empty($birthdate) || 
			!DateTime::createFromFormat('Y-m-d', $birthdate)
		) {
			//  muestra un mensaje de error y no registr al usuario
			
			echo "<script type='text/javascript'>alert('Error en los datos ingresados. Verifica la información.');</script>";
			echo "<script type='text/javascript'>window.location.href = 'PerfilModificar.php';</script>";
		} else {
				$obj = new nombres();
				$obj->modificar();
				
		
			echo "<script type='text/javascript'>alert('Modificacion de perfil exitosa.');</script>";
			echo "<script type='text/javascript'>window.location.assign('../perfil.php');</script>";
		}
	}


	// Verificar si se envió una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eliminar'])) {
        // Llamar a la función eliminarUsuario
        $nombres = new consulta();
        $res = $nombres->eliminarUsuario();
          // Destruir la sesión
		  session_start();
		  session_destroy();
		if ($res) {
			
			echo "Usuario eliminado exitosamente.";
			echo "<script type='text/javascript'>alert('Usuario eliminado exitosamente.'); window.location.assign('../Landpage.php');</script>";
			
		} else {
			echo "Error al eliminar el usuario.";
		}
    }
}
	
	

?>