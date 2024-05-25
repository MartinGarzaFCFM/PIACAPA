document.getElementById("Pago").addEventListener("click", function() {
    window.location.href = "Pago.php";
  });
  //document.getElementById("Carrito").addEventListener("click", function() {
   // window.location.href = "carrito.php";
  //});

/*
  // Obtener elementos del DOM
  const listaButton = document.getElementById('Lista');
  const listaModal = document.getElementById('listaModal');
  const agregarAListaButton = document.getElementById('agregarALista');

  
  listaButton.addEventListener('click', () => {
      // Mostrar el modal
      listaModal.style.display = 'block';
  });
/*
/*
  agregarAListaButton.addEventListener('click', () => {
      // Obtener la lista seleccionada
      const selectedList = document.querySelector('.lista-item.active');
      
      if (selectedList) {
          //  lógica para agregar el producto a la lista seleccionada
          const listName = selectedList.getAttribute('data-listname');
          alert(`Producto agregado a la lista: ${listName}`);
          
          // Cerrar el modal
          listaModal.style.display = 'none';
      } else {
          alert('Por favor, selecciona una lista antes de agregar el producto.');
      }
  });*/
/*
  const listaItems = document.querySelectorAll('.lista-item');
  listaItems.forEach(item => {
      item.addEventListener('click', () => {
          listaItems.forEach(otherItem => {
              otherItem.classList.remove('active');
          });
          item.classList.add('active');
      });
  });*/