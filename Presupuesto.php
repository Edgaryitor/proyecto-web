<?php  
session_start();  
include 'funcionalidades_php/db.php';   

// Verifica si el ID de usuario está definido en la sesión  
if (!isset($_SESSION['user_id'])) {  
    echo "Por favor, inicia sesión para ver tu presupuesto.";  
    exit(); // Detener la ejecución si no hay usuario logueado  
}  

$id_usuario = $_SESSION['user_id'];   

// Obtener el presupuesto del usuario  
$sql = "  
    SELECT p.Id_Presupuesto,   
           COALESCE(SUM(prod.Precio_P), 0) as Total,   
           COUNT(inc.Id_Producto) as Cantidad  
    FROM Presupuesto p  
    LEFT JOIN Incluye inc ON p.Id_Presupuesto = inc.Id_Presupuesto  
    LEFT JOIN Producto prod ON inc.Id_Producto = prod.Id_Producto  
    WHERE p.Id_Usuario = ?   
    GROUP BY p.Id_Presupuesto  
";  

$stmt = $conn->prepare($sql);  
$stmt->bind_param("i", $id_usuario); // Asegúrate de enlazar correctamente el parámetro  
$stmt->execute();  
$presupuesto = $stmt->get_result()->fetch_assoc(); // Cambia a get_result() para obtener el resultado correctamente  

// Verifica si el presupuesto existe  
if (!$presupuesto) {  
    echo "<h1>No has generado un presupuesto aún.</h1>";  
    exit();  
}  

// Obtener detalles de los productos en el presupuesto  
$sql_productos = "  
    SELECT prod.Nombre_P,   
           prod.Precio_P  
    FROM Incluye inc  
    JOIN Producto prod ON inc.Id_Producto = prod.Id_Producto  
    WHERE inc.Id_Presupuesto = ?  
";  

$stmt_productos = $conn->prepare($sql_productos);  
$stmt_productos->bind_param("i", $presupuesto['Id_Presupuesto']); // Asegúrate de enlazar correctamente el parámetro  
$stmt_productos->execute();  
$productos = $stmt_productos->get_result()->fetch_all(MYSQLI_ASSOC); // Cambia a get_result() para obtener todos los resultados  

?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <title>Presupuesto</title>  
    <link rel="stylesheet" href="css/Presupuesto.css">  
</head>  
<body>  
    <h1>Presupuesto</h1>  
    <div class="presupuesto">  
        <p>Productos (<?php echo htmlspecialchars($presupuesto['Cantidad']); ?>)</p>  
        <p>Total: $<?php echo number_format($presupuesto['Total'], 2); ?></p>  
        
        <div class="productos-lista">  
            <?php if (empty($productos)): ?>  
                <p>No tienes productos en tu presupuesto.</p>  
            <?php else: ?>  
                <?php foreach ($productos as $producto): ?>  
                <div class="producto">  
                    <h3><?php echo htmlspecialchars($producto['Nombre_P']); ?></h3>  
                    <p>$<?php echo number_format($producto['Precio_P'], 2); ?></p>  
                </div>  
                <?php endforeach; ?>  
            <?php endif; ?>  
        </div>  
    </div>  
</body>  
</html>