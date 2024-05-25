
function login(){
  if($('#username').val().trim()==""){ //el input id
      alert('Insertar datos');
     return;
  }
  else if($('#password').val().trim()==""){
      alert('Insertar datos');
      return;
  }

  //window.location.href="index.php";
};
//var contrasena = /(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
var contrasena ='^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?=.{8,})';
var soloLetras = /^[A-Za-z ]+$/;
//var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
var emailPattern = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/




function registro() {
  // Obtén los valores de los campos
  const fullname = $('#fullname').val().trim();
  const username = $('#username').val().trim();
  const email = $('#email').val().trim();
  const password = $('#password').val().trim();
  const avatar = $('#avatar').prop('files')[0];
  const birthdate = $('#birthdate').val().trim();

  // Valida el campo "fullname"
  if (fullname === "") {
    alert('Ingrese su nombre completo');
    return false;
  }
  if (!soloLetras.test(fullname)) {
    alert(' Nombre solo letras');
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

  // Valida el campo "avatar"
  if (!avatar) {
    alert('Seleccione una imagen de avatar');
    return  false;
  }
  // Valida el campo "email"
  if (birthdate === "") {
    alert('Ingrese fecha');
    return false;
  }
  // Valida el campo "birthdate"
  //if (!birthdate || isNaN(Date.parse(birthdate))) {
   // alert('Ingrese una fecha de nacimiento válida');
    //return;
 // }
 // Convierte la fecha de "DD/MM/AAAA" a "AAAA-MM-DD"
 const formattedBirthdate = birthdate.split('/').reverse().join('-');
// Valida el campo "birthdate"
if (!formattedBirthdate || !/^\d{4}-\d{2}-\d{2}$/.test(formattedBirthdate)) {
  alert('Ingrese una fecha de nacimiento válida en el formato AAAA-MM-DD');
  return  false;
}
  // Si todas las validaciones pasan, muestra un mensaje de registro exitoso
  alert('Registrado correctamente');
  return false;
}
















/*var contrasena = /(?=^.{8,}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/;
var soloLetras = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$/;




function registro(){
  if($('#fullname').val().trim()==""||$('#username').val().trim()=="" || $('#email').val().trim()==""
  ||$('#password').val().trim()=="" || $('#avatar').val().trim()=="" || $('#birthdate').val().trim()==""){

      alert('Insertar datos');
      return;
  }
  if (!soloLetras.test($('#fullname').val().trim())){

     alert('Solo letras');
      return;
  }

  
  if(!contrasena.test($('#password').val().trim())){
      alert('Contraseña con un mínimo de 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.');
      return;
  }



  alert('Registrado correctamente')
};*/



