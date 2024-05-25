
function mostrarCamposAdicionales() {
    var tipoProducto = document.getElementById("tipo").value;
    var camposCotizables = document.getElementById("camposCotizables");

    // Si el tipo de producto es "Cotizar" (valor 1), muestra los campos adicionales
    if (tipoProducto === "1") {
        camposCotizables.style.display = "block";
    } else {
        // Si el tipo de producto es "Vender" (valor 2) u otra opción, oculta los campos adicionales
        camposCotizables.style.display = "none";
    }
}
