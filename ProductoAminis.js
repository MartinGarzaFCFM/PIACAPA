document.addEventListener('DOMContentLoaded', function() {
    // Tu código aquí
    $('.btn-aprobar').click(function () {
        var idCoti = $(this).data('id');
        console.log('ID del producto a aprobar:', idCoti); // Agrega esta línea
        aprobarProducto(idCoti);
    });

    function aprobarProducto(idCoti) {
        console.log('Enviando solicitud para aprobar producto con ID:', idCoti); // Agrega esta línea
        $.ajax({
            type: 'POST',
            url: 'db/aprobar_producto.php',
            data: { idCoti: idCoti },
            success: function (response) {
                console.log(response);
                alert("Producto aprobado");
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            },
            error: function (error) {
                console.error('Error en la solicitud Ajax: ', error);
            }
        });
    }

    $('.btn-rechazar').click(function () {
        var idCoti = $(this).data('id');
        console.log('ID del producto a rechazar:', idCoti); // Agrega esta línea
        rechazarProducto(idCoti);
    });

    function rechazarProducto(idCoti) {
        console.log('Enviando solicitud para rechazar producto con ID:', idCoti); // Agrega esta línea
        $.ajax({
            type: 'POST',
            url: 'db/rechazar_producto.php', // Nombre del archivo que manejará la lógica de rechazar
            data: { idCoti: idCoti },
            success: function (response) {
                console.log(response);
                alert("Producto rechazado");
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            },
            error: function (error) {
                console.error('Error en la solicitud Ajax: ', error);
            }
        });
    }
});

function verDetalles(producto) {
    // Rellena la información del producto en el modal
    $('#nombreProductoModal').text(producto.PRO_NOMBRE);
    $('#descripcionProductoModal').text(producto.PRO_DESCRIPCION);
    $('#categoriaProductoModal').text(producto.PRO_CATEGORIA);
    $('#tipoProductoModal').text(producto.PRO_TIPO);
    $('#precioProductoModal').text(producto.PRO_PRECIOTOTAL);
    $('#cantidadProductoModal').text(producto.PRO_CANTIDAD);
    $('#usuarioProductoModal').text(producto.Usuario);

    // Rellena la imagen (si existe)
    if (producto.Imagen) {
        $('#imagenProductoModal').attr('src', 'data:image/jpeg;base64,' + producto.Imagen);
    } else {
        // Puedes ocultar la imagen si no hay ninguna
        $('#imagenProductoModal').hide();
    }

    // Abre el modal para mostrar los detalles
    $('#detallesProductoModal').modal('show');
}
