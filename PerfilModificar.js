//var contrasena = /(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
var contrasena ='^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})';
var soloLetras = /^[A-Za-z ]+$/;
//var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
var emailPattern = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/


function validarModificacion() {
    // Obtén los valores de los campos que deseas validar
    const fullname = $('#fullnameP').val().trim();
    const username = $('#usernameP').val().trim();
    const email = $('#emailP').val().trim();
    const password = $('#passwordP').val().trim();
    const birthdate = $('#birthdateP').val().trim();
  
    // Valida el campo "fullname"
    if (fullname === "") {
      alert('Ingrese su nombre completo');
      return false;
    }
    if (!soloLetras.test(fullname)) {
      alert('Nombre solo letras');
      return false;
    }
  
    // Valida el campo "username"
    if (username === "" || username.length < 3) {
      alert('El nombre de usuario debe contener al menos 3 caracteres');
      return false;
    }
  
    // Valida el campo "email"
    if (email === "") {
      alert('Ingrese su dirección de correo electrónico');
      return false;
    }
    if (!emailPattern.test(email) || email.indexOf('.') === -1) {
      alert('Ingrese un correo electrónico válido');
      return false;
    }
  
    // Valida el campo "password"
  if (password === "") {
    alert('Ingrese su contraseña');
    return false;
  }
  if (!contrasena.test(password)) {
    alert('La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.');
    return false;
  }
 // Convierte la fecha de "DD/MM/AAAA" a "AAAA-MM-DD"
 const formattedBirthdate = birthdate.split('/').reverse().join('-');
// Valida el campo "birthdate"
if (!formattedBirthdate || !/^\d{4}-\d{2}-\d{2}$/.test(formattedBirthdate)) {
  alert('Ingrese una fecha de nacimiento válida en el formato AAAA-MM-DD');
  return  false;
}
    // Continúa con las validaciones específicas que necesitas para la modificación
  
    // Si todas las validaciones pasan, muestra un mensaje de modificación exitosa
    alert('Modificación exitosa');
    return false;
  }
  