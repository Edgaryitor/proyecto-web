<?php
session_start();
include 'db.php';

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Usuario no autenticado.";
    exit();
}

// Obtener el ID del producto desde la solicitud POST
$idProducto = $_POST['idProducto'];

// Obtener el ID del usuario desde la sesión
$idUsuario = $_SESSION['user_id'];

// Verificar si ya existe un presupuesto para el usuario
$query = "SELECT Id_Presupuesto FROM Presupuesto WHERE Id_Usuario = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si ya existe un presupuesto, obtener su ID
    $row = $result->fetch_assoc();
    $idPresupuesto = $row['Id_Presupuesto'];
} else {
    echo "No se encontró el presupuesto.";
    exit();
}

// Eliminar el producto del presupuesto
$query = "DELETE FROM Incluye WHERE Id_Presupuesto = ? AND Id_Producto = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $idPresupuesto, $idProducto);
if (!$stmt->execute()) {
    echo "Error al eliminar el producto del presupuesto: " . $stmt->error;
    exit();
}

// Actualizar la cantidad y el total del presupuesto
$query = "UPDATE Presupuesto SET Cantidad_a_P = Cantidad_a_P - 1, Total_P = Total_P - (SELECT Precio_P FROM Producto WHERE Id_Producto = ?) WHERE Id_Presupuesto = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $idProducto, $idPresupuesto);
if (!$stmt->execute()) {
    echo "Error al actualizar el presupuesto: " . $stmt->error;
    exit();
}

$conn->close();
echo "Producto eliminado del presupuesto exitosamente!";
?>