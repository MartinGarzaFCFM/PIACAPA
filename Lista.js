





document.getElementById('Modificar').addEventListener('click', function() {
   
    var idLista = $('#idListaModificar').val();
    var nombreLista = $('#nombreListaCompra').val();
    var descripcionLista = $('#descripcionListaCompra').val();
    var tipoLista = $('#tipoListaCompra').val();

    $.ajax({
        url: 'db/modificar_lista.php', // Ruta al script PHP que maneja la actualización
        method: 'POST',
        data: {
            ID_LISTA: idLista,
            LIST_NOMBRE: nombreLista,
            LIST_DESCRIPCION: descripcionLista,
            LIST_PRIVACIDAD: tipoLista
        },
        dataType: 'json',
        success: function (response) {
            console.log('Lista actualizada con éxito:', response);
            alert("Lista actualizada con éxito");
            // Puedes realizar acciones adicionales después de actualizar la lista, si es necesario
             // Recargar la página después de un breve retraso (1 segundo en este caso)
             setTimeout(function() {
                window.location.reload();
            }, 500);
        },
        error: function (error) {
            console.error('Error al actualizar la lista:', error);
            alert("Error al actualizar la lista");
        }
    });
    
});
// ...
document.getElementById('Eliminar').addEventListener('click', function() {
    var idLista = $('#idListaModificar').val(); // Obtén el ID de la lista
    eliminarLista(idLista); // Llama a la función para eliminar la lista
});
// ...

function eliminarLista(idLista) {
    $.ajax({
        url: 'db/Eliminar_lista.php', // Ruta al script PHP que maneja la eliminación
        method: 'POST',
        data: { ID_LISTA: idLista },
        dataType: 'json',
        success: function (response) {
            console.log('Lista eliminada con éxito:', response);
            alert("Lista eliminada con éxito");
            // Puedes realizar acciones adicionales después de eliminar la lista, si es necesario
            // Recargar la página después de un breve retraso (1 segundo en este caso)
            setTimeout(function() {
                window.location.reload();
            }, 500);
        },
        error: function (error) {
            console.error('Error al eliminar la lista:', error);
            alert("Error al eliminar la lista");
        }
    });
}

$('#contenidoListaCompras').on('click', '#Eliminar2', function (event) {
    event.preventDefault();

    // Encuentra el elemento padre (li) del botón clicado
    var listItem = $(this).closest('li');
    var idLista = $('#idListaModificar').val(); // Obtén el ID de la lista
    // Obtiene el ID_PRODUCTO desde el atributo de datos
    var idProducto = $(this).data('id-producto');

    // Ahora puedes usar el idProducto para realizar la operación de eliminación
    console.log('Eliminar producto con ID:', idProducto);
    eliminarProductoDeLista(idLista, idProducto); // Llama a la función para eliminar el producto de la lista
});


function eliminarProductoDeLista(idLista, idProducto) {
    $.ajax({
        url: 'db/Eliminar_Producto_Lista.php', // Ruta al script PHP que maneja la eliminación del producto de la lista
        method: 'POST',
        data: { ID_LISTA: idLista, ID_PRODUCTO: idProducto },
        dataType: 'json',
        success: function (response) {
            console.log('Producto eliminado con éxito:', response);
            alert("Producto eliminado de la lista con éxito");
            // Puedes realizar acciones adicionales después de eliminar el producto de la lista, si es necesario
            // Recargar la página después de un breve retraso (1 segundo en este caso)
            setTimeout(function() {
                window.location.reload();
            }, 500);
        },
        error: function (error) {
            console.error('Error al eliminar el producto de la lista:', error);
            alert("Error al eliminar el producto de la lista");
        }
    });
}


document.getElementById('carrito').addEventListener('click', function() {
    window.location.href = "carrito.html";
});

/*
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('mostrarContenidoLista').addEventListener('click', function (event) {
        event.preventDefault();
        document.getElementById('contenidoLista').style.display = 'block';
    });

    const listaItems = document.querySelectorAll('.lista-item');
    const listaCompras = document.getElementById('listaCompras');
    const contenidoLista = document.getElementById('contenidoLista');

    listaItems.forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            listaCompras.style.display = 'block';
            contenidoLista.style.display = 'block';
        });
    });
});
*/