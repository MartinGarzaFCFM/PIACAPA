document.getElementById("RegisterProd").addEventListener("click", function() {
  var nombre = document.getElementById("nombre").value;
  var descripcion = document.getElementById("descripcion").value;
  var imagenesInput = document.getElementById("imagenes");
  var inputFiles = imagenesInput.files;
  var video = document.getElementById("video").value;
  var categoria = document.getElementById("categoria").value;
  var tipo = document.getElementById("tipo").value;
  var precio = document.getElementById("precio").value;
  var cantidad = document.getElementById("cantidad").value;

  if (inputFiles.length < 3) {
      alert("Agrega al menos 3 imágenes.");
  } else if (nombre && descripcion && video && categoria && tipo && precio && cantidad) {
      alert("Producto registrado.");
  } else {
      alert("Completa todos los campos antes de continuar.");
  }
});

document.getElementById("GestionarProd").addEventListener("click", function(event) {
    
    // Redirige a la página "Gestion_Productos.php"
    window.location.href = "Gestion_Productos.php";
});
