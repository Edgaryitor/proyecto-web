console.log(productos); // Muestra el contenido de la variable productos
function mostrarVentana(idProducto) {  
    // Busca el producto por su Id  
    const producto = productos.find(p => Number(p.Id_Producto) === idProducto); // Busca el producto en la lista de productos de la base de datos  

    if (producto) {  
        console.log(producto); // Verifica que tienes el producto correcto  
        document.getElementById('productoTitulo').textContent = producto.Nombre_P;  
        document.getElementById('productoDescripcion').textContent = producto.Descripción_P;  
        document.getElementById('productoPrecio').textContent = "$" + parseFloat(producto.Precio_P).toLocaleString();  
        document.getElementById('productoCategoria').textContent = producto.Categoría_P;  
        document.getElementById('productoDisponibilidad').textContent = producto.Disponibilidad_P ? "En Stock" : "Agotado";  

        document.getElementById('ventanaEmergente').style.display = 'flex';  
    } else {  
        console.error("Producto no encontrado"); // Para depuración  
    }  
}  

function cerrarVentana() {  
    document.getElementById('ventanaEmergente').style.display = 'none';  
}