<?php
session_start();
include 'db.php'; // Incluye el archivo de conexión a la base de datos

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit();
}

$id_usuario = $_SESSION['user_id'];

// Obtener el presupuesto del usuario
$sql = "SELECT Id_Presupuesto FROM Presupuesto WHERE Id_Usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$presupuesto = $result->fetch_assoc();

if (!$presupuesto) {
    echo "No se encontró el presupuesto.";
    exit();
}

$id_presupuesto = $presupuesto['Id_Presupuesto'];

// Actualizar la fecha del presupuesto
$sql_update = "UPDATE Presupuesto SET Fecha_c_P = NOW() WHERE Id_Presupuesto = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("i", $id_presupuesto);
$stmt_update->execute();

// Obtener detalles del presupuesto y los productos
$sql_detalles = "
    SELECT p.Fecha_c_P, p.Cantidad_a_P, p.Total_P, u.Correo_e_U, prod.Nombre_P, prod.Precio_P
    FROM Presupuesto p
    JOIN Usuario u ON p.Id_Usuario = u.Id_Usuario
    JOIN Incluye inc ON p.Id_Presupuesto = inc.Id_Presupuesto
    JOIN Producto prod ON inc.Id_Producto = prod.Id_Producto
    WHERE p.Id_Presupuesto = ?
";
$stmt_detalles = $conn->prepare($sql_detalles);
$stmt_detalles->bind_param("i", $id_presupuesto);
$stmt_detalles->execute();
$result_detalles = $stmt_detalles->get_result();
$detalles = $result_detalles->fetch_all(MYSQLI_ASSOC);

// Preparar el contenido del correo
$correo_usuario = $detalles[0]['Correo_e_U'];
$contenido_correo = "Detalles del presupuesto:\n\n";
$contenido_correo .= "Fecha: " . $detalles[0]['Fecha_c_P'] . "\n";
$contenido_correo .= "Cantidad de productos: " . $detalles[0]['Cantidad_a_P'] . "\n";
$contenido_correo .= "Total: $" . number_format($detalles[0]['Total_P'], 2) . "\n\n";
$contenido_correo .= "Productos:\n";

foreach ($detalles as $detalle) {
    $contenido_correo .= "- " . $detalle['Nombre_P'] . ": $" . number_format($detalle['Precio_P'], 2) . "\n";
}

// Enviar el correo
$asunto = "Detalles de tu presupuesto";
$headers = "From: no-reply@tu-dominio.com\r\n";
mail($correo_usuario, $asunto, $contenido_correo, $headers);

echo "Presupuesto guardado y notificación enviada!";
?>