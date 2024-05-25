
var soloLetras = /^[A-Za-z ]+$/;

document.getElementById('Modificar').addEventListener('click', function() {
  var idCategoria = $('#idCategoriaModificar').val();
  var nuevoNombre = $('#nombrecat').val();
  var nuevaDescripcion = $('#descripcioncat').val();

  $.ajax({
      url: 'db/EditarCategoria.php', 
      method: 'POST',
      data: {
          c_cat_id: idCategoria,
          nuevo_nombre: nuevoNombre,
          nueva_descripcion: nuevaDescripcion
      },
      dataType: 'json',
      success: function (response) {
          console.log(response);

          if (response.success) {
              alert("Categoría modificada con éxito");
              setTimeout(function() {
                  window.location.href = 'GestionCategorias.php';
              }, 500);
          } else {
              alert("Error al modificar la categoría: " + response.message);
          }
      },
      error: function (error) {
          console.error('Error en la solicitud AJAX:', error);
      }
  });
});



document.getElementById('Eliminar').addEventListener('click', function() {
  // Obtén el ID de la categoría que deseas eliminar
  var idCategoria = $('#idCategoriaModificar').val();

  // Muestra una confirmación al usuario
  var confirmacion = confirm("¿Estás seguro de que quieres eliminar esta categoría?");

  // Si el usuario hace clic en "Aceptar", procede con la eliminación
  if (confirmacion) {
      eliminarCategoria(idCategoria);
  } else {
      // Si el usuario hace clic en "Cancelar" o cierra la ventana de confirmación, no hagas nada
      console.log('Operación de eliminación cancelada por el usuario.');
  }
});

function eliminarCategoria(idCategoria) {
  $.ajax({
      url: 'db/EliminarCategoria.php',
      method: 'POST',
      data: { idCategoria: idCategoria },
      success: function (response) {
          console.log('Categoría eliminada con éxito:', response);
          alert("Categoría eliminada con éxito");
          // Puedes realizar acciones adicionales después de eliminar la categoría, si es necesario
          // Redirigir a la página de categorías después de un breve retraso (1 segundo en este caso)
          setTimeout(function() {
              window.location.href = 'GestionCategorias.php';
          }, 500);
      },
      error: function (error) {
          console.error('Error al eliminar la categoría:', error);
          alert("Error al eliminar la categoría");
      }
  });
}


document.getElementById('Regresar').addEventListener('click', function() {
  // Cambia la ubicación del navegador a categoria.php
  window.location.href = 'categoria.php';
});

function registro() {
  // Obtén los valores de los campos
  const fullname = $('#fullname').val().trim();
  
  // Valida el campo "fullname"
  if (fullname === "") {
    alert('Ingrese su nombre completo');
    return false;
  }
  if (!soloLetras.test(fullname)) {
    alert(' Nombre solo letras');
    return false;
  }
  // Si todas las validaciones pasan, muestra un mensaje de registro exitoso
  alert('Registrado correctamente');
  return false;
}










