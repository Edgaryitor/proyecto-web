function eliminarDelPresupuesto(idProducto) {
    // Crear una solicitud AJAX para enviar los datos al servidor
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "funcionalidades_php/eliminar_presupuesto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Producto eliminado del presupuesto exitosamente!");
            location.reload(); // Recargar la página para actualizar la lista de productos
        }
    };

    // Enviar los datos del producto al servidor
    xhr.send("idProducto=" + idProducto);
}

function guardarPresupuesto() {
    // Crear una solicitud AJAX para enviar los datos al servidor
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "funcionalidades_php/guardar_presupuesto.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Manejar la respuesta del servidor
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert("Presupuesto guardado y notificación enviada!");
        }
    };

    // Enviar la solicitud al servidor
    xhr.send();
}
