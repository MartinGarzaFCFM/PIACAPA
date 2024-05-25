
// Supongamos que obtienes el rol del usuario y lo almacenas en una variable llamada 'rolUsuario'
var rolUsuario = 'cliente'; // Cambia esto según el rol del usuario

// Función para mostrar u ocultar elementos del menú según el rol
function actualizarMenuSegunRol() {
  // Ocultar todos los elementos del menú
  document.querySelectorAll('.dropdown-item').forEach(function (elemento) {
    elemento.style.display = 'none';
  });

  // Mostrar elementos del menú específicos según el rol
  if (rolUsuario === 'cliente') {
    document.querySelectorAll('.cliente-menu').forEach(function (elemento) {
      elemento.style.display = 'block';
    });
  } else if (rolUsuario === 'vendedor') {
    document.querySelectorAll('.vendedor-menu').forEach(function (elemento) {
      elemento.style.display = 'block';
    });
  } else if (rolUsuario === 'administrador') {
    document.querySelectorAll('.admin-menu').forEach(function (elemento) {
      elemento.style.display = 'block';
    });
  }
}

// Llama a la función para actualizar el menú cuando la página esté lista
document.addEventListener('DOMContentLoaded', function () {
  actualizarMenuSegunRol();
});

//nolo utilizooooooooo