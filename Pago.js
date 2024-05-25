document.getElementById("Pago").addEventListener("click", function() {
   
    
    var cardType = document.getElementById("cardType").value;
    var cardNumber = document.getElementById("cardNumber").value;
    var cardName= document.getElementById("cardName").value;
    var expiryDate = document.getElementById("expiryDate").value;

    
    if(cardType && cardNumber && cardName && expiryDate ){
        realizarPago();
    }else{
        alert("Faltan campos por llenar")
    }
    
});

document.getElementById("cardType").addEventListener("change", function() {
    var selectedValue = this.value;
    var cvvGroup = document.getElementById("cvvGroup");

    // Mostrar el campo CVV solo si se selecciona "credito"
    if (selectedValue === "credito") {
        cvvGroup.style.display = "block";
    } else {
        cvvGroup.style.display = "none";
    }
});


function realizarPago() {
   
    // mostraremos un mensaje de pago exitoso.
    alert("Pago exitoso. ¡Gracias por su compra!");
  
}