function mostrarVentana(idProducto) {  
    // Busca el producto por su Id  
    const producto = producto.find(p => p.Id_Producto === idProducto);  

    if (producto) {  
        document.getElementById('productoTitulo').textContent = producto.Nombre_P;  
        document.getElementById('productoDescripcion').textContent = producto.Descripción_P;  
        document.getElementById('productoPrecio').textContent = "$" + parseFloat(producto.Precio_P).toLocaleString();  
        document.getElementById('productoCategoria').textContent = producto.Categoría_P;  
        document.getElementById('productoDisponibilidad').textContent = producto.Disponibilidad_P ? "En Stock" : "Agotado";  

        // Mostrar la imagen del producto  
        const imgElemento = document.createElement('img');  
        imgElemento.src = producto.Imagen_P;  
        imgElemento.alt = producto.Nombre_P;  
        imgElemento.style.width = "100%"; // Ajusta el tamaño según sea necesario  
        imgElemento.style.height = "auto"; // Mantiene la proporción de la imagen  

        // Limpia la ventana y añade la imagen  
        const contenidoVentana = document.querySelector('.contenido');  
        contenidoVentana.appendChild(imgElemento);  

        document.getElementById('ventanaEmergente').style.display = 'flex';  
    }  
}  

function cerrarVentana() {  
    document.getElementById('ventanaEmergente').style.display = 'none';  
    // Limpia el contenido de la ventana emergente  
    const contenidoVentana = document.querySelector('.contenido');  
    contenidoVentana.removeChild(contenidoVentana.lastChild); // Elimina la imagen al cerrar  
}