function mostrarVentana(idProducto) {
    const productos = [
        {
            titulo: "Laptop HP 240 G9",
            descripcion: "Laptop con procesador Intel Celeron, 8GB RAM y 256GB SSD.",
            precio: "$5,299",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        },
        {
            titulo: "Laptop Dell XPS 13",
            descripcion: "Laptop premium con Intel i7, 16GB RAM y 512GB SSD.",
            precio: "$9,999",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        },
        {
            titulo: "Laptop Lenovo IdeaPad",
            descripcion: "Laptop con Intel Core i5, 8GB RAM y 512GB SSD.",
            precio: "$6,499",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        },
        {
            titulo: "Laptop Acer Aspire 5",
            descripcion: "Laptop con AMD Ryzen 5, 8GB RAM y 256GB SSD.",
            precio: "$5,799",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        },
        {
            titulo: "Laptop HP Pavilion",
            descripcion: "Laptop con Intel i5, 8GB RAM y 1TB HDD.",
            precio: "$7,199",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        },
        {
            titulo: "Laptop Dell Inspiron 15",
            descripcion: "Laptop con Intel i3, 4GB RAM y 500GB HDD.",
            precio: "$4,999",
            categoria: "Computadoras Portátiles",
            disponibilidad: "En Stock"
        }
    ];

    const producto = productos[idProducto - 1];
    document.getElementById('productoTitulo').textContent = producto.titulo;
    document.getElementById('productoDescripcion').textContent = producto.descripcion;
    document.getElementById('productoPrecio').textContent = producto.precio;
    document.getElementById('productoCategoria').textContent = producto.categoria;
    document.getElementById('productoDisponibilidad').textContent = producto.disponibilidad;
    
    document.getElementById('ventanaEmergente').style.display = 'flex';
}

function cerrarVentana() {
    document.getElementById('ventanaEmergente').style.display = 'none';
}
