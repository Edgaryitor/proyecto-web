function mostrarVentana(idProducto) {  
    // Busca el producto por su Id  
    const producto = productos.find(p => Number(p.Id_Producto) === Number(idProducto)); // Busca el producto en la lista de productos de la base de datos  

    if (producto) {  
        document.getElementById('productoTitulo').textContent = producto.Nombre_P;  
        document.getElementById('productoDescripcion').textContent = producto.Descripción_P;  
        document.getElementById('productoPrecio').textContent = "$" + parseFloat(producto.Precio_P).toLocaleString();  
        document.getElementById('productoCategoria').textContent = producto.Categoría_P;  
        document.getElementById('productoDisponibilidad').textContent = producto.Disponibilidad_P ? "En Stock" : "Agotado";  

        // Establece la imagen del producto  
        document.getElementById('productoImagen').src = producto.Imagen_P; // Asegúrate de que el campo de imagen sea correcto  
        document.getElementById('productoImagen').alt = producto.Nombre_P; // Establece un texto alternativo para la imagen  

        // Actualiza el botón "Agregar al presupuesto" con el ID del producto correcto
        const agregarBtn = document.querySelector('#ventanaEmergente button');
        agregarBtn.setAttribute('onclick', `agregarAlPresupuesto(${idProducto})`);

        document.getElementById('ventanaEmergente').style.display = 'flex';  
    } else {  
        console.error("Producto no encontrado"); // Para depuración  
    }  
}

function cerrarVentana() {  
    document.getElementById('ventanaEmergente').style.display = 'none';  
}

function agregarAlPresupuesto(idProducto) {
    // Crear una solicitud AJAX para enviar los datos al servidor
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "funcionalidades_php/agregar_presupuesto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Producto agregado al presupuesto exitosamente!");
        }
    };

    // Enviar los datos del producto al servidor
    xhr.send("idProducto=" + idProducto);
}
