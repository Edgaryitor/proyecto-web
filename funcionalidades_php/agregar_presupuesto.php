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
    // Si no existe un presupuesto, crear uno nuevo
    $query = "INSERT INTO Presupuesto (Fecha_c_P, Cantidad_a_P, Total_P, Id_Usuario) VALUES (NOW(), 0, 0, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idUsuario);
    if ($stmt->execute()) {
        $idPresupuesto = $stmt->insert_id;
    } else {
        echo "Error al crear el presupuesto: " . $stmt->error;
        exit;
    }
}

// Agregar el producto al presupuesto
$query = "INSERT INTO Incluye (Id_Presupuesto, Id_Producto) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $idPresupuesto, $idProducto);
if (!$stmt->execute()) {
    echo "Error al agregar el producto al presupuesto: " . $stmt->error;
    exit;
}

// Actualizar la cantidad y el total del presupuesto
$query = "UPDATE Presupuesto SET Cantidad_a_P = Cantidad_a_P + 1, Total_P = Total_P + (SELECT Precio_P FROM Producto WHERE Id_Producto = ?) WHERE Id_Presupuesto = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $idProducto, $idPresupuesto);
if (!$stmt->execute()) {
    echo "Error al actualizar el presupuesto: " . $stmt->error;
    exit;
}

$conn->close();
echo "Producto agregado al presupuesto exitosamente!";
?>