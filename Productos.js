





document.getElementById('Modificar').addEventListener('click', function() {
    
    var idProducto = $('#idProductoModificar').val();
    var nombreProducto = $('#nombrePro').val();
    var descripcionProducto = $('#descripcionPro').val();
    var tipoProducto = $('#tipo').val();
    var cantidadProducto = $('#cantidadPro').val();
    var categoriaProducto = $('#categoriaSelect').val();
    var precioProducto = $('#precioPro').val();
    var materialProducto = $('#materialCot').val();
    var medidasProducto = $('#medidasCot').val();


    console.log(idProducto);
    console.log(nombreProducto);
    console.log(descripcionProducto);
    console.log(tipoProducto);
    console.log(cantidadProducto);
    console.log(categoriaProducto);
    console.log(precioProducto);
    console.log(materialProducto);
    console.log(medidasProducto);

    $.ajax({
        url: 'db/modificar_Producto.php', 
        method: 'POST',
        data: {
            idProducto: idProducto,
            nombrePro: nombreProducto,
            descripcionPro: descripcionProducto,
            tipo: tipoProducto,
            cantidadPro: cantidadProducto,
            categoriaSelect: categoriaProducto,
            precioPro: precioProducto,
            materialCot: materialProducto,
            medidasCot: medidasProducto
        },
        dataType: 'json',
        success: function (response) {
            console.log(response);

            if (response.success) {
                alert("Producto modificado con éxito");
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            } else {
                alert("Error al modificar el producto: " + response.message);
            }
        },
        error: function (error) {
            console.error('Error en la solicitud AJAX:', error);
        }
    });
});

// ...
document.getElementById('Eliminar').addEventListener('click', function() {
    var idProducto = $('#idProductoModificar').val();

    var confirmacion = confirm("¿Estás seguro de que quieres eliminar este producto?");

    if (confirmacion) {
        eliminarProducto(idProducto);
    } else {
        console.log('Operación de eliminación cancelada por el usuario.');
    }
});

function eliminarProducto(idProducto) {
    $.ajax({
        url: 'db/Eliminar_Producto.php',
        method: 'POST',
        data: { idProducto: idProducto },
        success: function (response) {
            console.log('Producto eliminado con éxito:', response);
            alert("Producto eliminado con éxito");
            setTimeout(function() {
                window.location.reload();
            }, 500);
        },
        error: function (error) {
            console.error('Error al eliminar el producto:', error);
            alert("Error al eliminar el producto");
        }
    });
}
