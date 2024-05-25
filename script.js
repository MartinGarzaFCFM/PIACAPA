const chatBox = document.getElementById('chatBox');
const messageInput = document.getElementById('messageInput');
const sendButton = document.getElementById('sendButton');

sendButton.addEventListener('click', () => {
    const message = messageInput.value;
    if (message.trim() !== '') {
        // Envía el mensaje 
        sendMessageToServer(message);
        messageInput.value = '';
    }
});

// Función para mostrar mensajes en la ventana de chat
function displayMessage(message) {
    const messageElement = document.createElement('div');
    messageElement.classList.add('message');
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
}

// Función simulada para enviar mensajes al servidor
function sendMessageToServer(message) {
    // En una implementación real, esto se enviaría al servidor para procesar y distribuir a otros usuarios.
    displayMessage(`Tú: ${message}`);
  
}


document.getElementById("sendProductInfo").addEventListener("click", function() {
    
    var medida = document.getElementById("productMeasure").value;
    var materiales = document.getElementById("productMaterials").value;
    var requiereFlete = document.getElementById("productFlete").checked;

    //  enlace con la información del producto
    var enlacePago = "pago.html?medida=" + medida + "&materiales=" + materiales + "&flete=" + requiereFlete;

    // Simular el envío del enlace al cliente 
    alert("Se ha enviado el enlace al cliente: " + enlacePago);
});

//  (vendedor o cliente)
var userRole = "vendedor"; // rol  del usuario autenticado

//  secciones del chat
var chatSection = document.querySelector(".container-chat");
var productInfoSection = document.querySelector(".product-info");

// Verifica el rol y muestra/oculta las secciones 
if (userRole === "vendedor") {
    // Si el usuario es un vendedor, muestra la sección de información del producto
    chatSection.style.display = "block";
    productInfoSection.style.display = "block";
} else {
    // Si el usuario es un cliente, muestra solo la sección del chat
    chatSection.style.display = "block"; 
    productInfoSection.style.display = "none";
}