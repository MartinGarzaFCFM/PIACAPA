document.getElementById('registroForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const nombreLista = document.getElementById('nombreLista').value;
    var descripcionLista = document.getElementById('descripcionLista').value;
    var tipoLista = document.getElementById('tipoLista').value;
    if (nombreLista && descripcionLista && tipoLista) {
        // Todos los campos están completos, redirigir a la lista
        window.location.href = `lista.html?nombre=${nombreLista}`;
      } else {
        alert("Completa todos los campos antes de continuar.");
      }
    
});