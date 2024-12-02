<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Inicio de sesión.php");
    exit();
}
include '../funcionalidades_php/db.php'; // Incluye el archivo de conexión a la base de datos

// Obtener el ID del servicio a editar
$id_servicio = $_GET['id'];

// Obtener los detalles del servicio
$sql = "SELECT * FROM Servicio WHERE Id_Servicio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_servicio);
$stmt->execute();
$result = $stmt->get_result();
$servicio = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    // Actualizar los detalles del servicio
    $sql_update = "UPDATE Servicio SET Nombre_S = ?, Descripción_S = ?, Precio_S = ?, Categoría_S = ?, Disponibilidad_S = ? WHERE Id_Servicio = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $id_servicio);
    $stmt_update->execute();

    header("Location: gestionar_servicios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Servicio</title>
    <link rel="stylesheet" href="css/Admin.css">
</head>

<body>
    <header>
        <h1>Editar Servicio</h1>
        <nav>
            <a href="gestionar_servicios.php">Volver a Gestionar Servicios</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Editar Servicio</h2>
        <form action="editar_servicio.php?id=<?php echo $id_servicio; ?>" method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($servicio['Nombre_S']); ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($servicio['Descripción_S']); ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" value="<?php echo htmlspecialchars($servicio['Precio_S']); ?>" step="0.01" required>

            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo htmlspecialchars($servicio['Categoría_S']); ?>" required>

            <label for="disponibilidad">Disponibilidad:</label>
            <input type="checkbox" id="disponibilidad" name="disponibilidad" <?php if ($servicio['Disponibilidad_S']) echo 'checked'; ?>>

            <button type="submit">Guardar Cambios</button>
        </form>
    </main>
</body>

</html>