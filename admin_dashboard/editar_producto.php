<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Inicio de sesión.php");
    exit();
}
include '../funcionalidades_php/db.php'; // Incluye el archivo de conexión a la base de datos

// Obtener el ID del producto a editar
$id_producto = $_GET['id'];

// Obtener los detalles del producto
$sql = "SELECT * FROM Producto WHERE Id_Producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();
$producto = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    // Actualizar los detalles del producto
    $sql_update = "UPDATE Producto SET Nombre_P = ?, Descripción_P = ?, Precio_P = ?, Categoría_P = ?, Disponibilidad_P = ? WHERE Id_Producto = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $id_producto);
    $stmt_update->execute();

    header("Location: gestionar_productos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/Admin.css">
</head>

<body>
    <header>
        <h1>Editar Producto</h1>
        <nav>
            <a href="gestionar_productos.php">Volver a Gestionar Productos</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Editar Producto</h2>
        <form action="editar_producto.php?id=<?php echo $id_producto; ?>" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['Nombre_P']); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($producto['Descripción_P']); ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($producto['Precio_P']); ?>" step="0.01" required>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($producto['Categoría_P']); ?>" required>

            <label for="disponibilidad">Disponibilidad:</label>
            <input type="checkbox" id="disponibilidad" name="disponibilidad" <?php if ($producto['Disponibilidad_P']) echo 'checked'; ?>>

            <button type="submit">Guardar Cambios</button>
        </form>
    </main>
</body>

</html>