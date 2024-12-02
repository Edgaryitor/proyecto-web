<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Inicio de sesión.php");
    exit();
}
include '../funcionalidades_php/db.php'; // Incluye el archivo de conexión a la base de datos

// Lógica para añadir servicios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO Servicio (Nombre_S, Descripción_S, Precio_S, Categoría_S, Disponibilidad_S, Id_Administrador) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $_SESSION['admin_id']);
    $stmt->execute();
    $stmt->close();
}

// Lógica para eliminar servicios
if (isset($_GET['delete'])) {
    $id_servicio = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Servicio WHERE Id_Servicio = ?");
    $stmt->bind_param("i", $id_servicio);
    $stmt->execute();
    $stmt->close();
}

// Lógica para editar servicios
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_service'])) {
    $id_servicio = $_POST['id_servicio'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE Servicio SET Nombre_S = ?, Descripción_S = ?, Precio_S = ?, Categoría_S = ?, Disponibilidad_S = ? WHERE Id_Servicio = ?");
    $stmt->bind_param("ssdsii", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $id_servicio);
    $stmt->execute();
    $stmt->close();
}

// Consultar servicios
$result = $conn->query("SELECT * FROM Servicio");
$servicios = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Servicios</title>
    <link rel="stylesheet" href="../css/Admin.css">
    <script>
        function confirmarEliminacion(nombre, id) {
            if (confirm(`¿Seguro que quieres eliminar el servicio ${nombre}?`)) {
                window.location.href = `gestionar_servicios.php?delete=${id}`;
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Gestionar Servicios</h1>
        <nav>
            <a href="../admin_dashboard.php">Volver al Panel</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Servicios</h2>

        <!-- Formulario para añadir servicios -->
        <form action="gestionar_servicios.php" method="POST">
            <input type="hidden" name="add_service" value="1">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required></textarea>
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" required>
            <label for="categoria">Categoría:</label>
            <input type="text" id="categoria" name="categoria" required>
            <label for="disponibilidad">Disponibilidad:</label>
            <input type="checkbox" id="disponibilidad" name="disponibilidad">
            <button type="submit">Añadir Servicio</button>
        </form>

        <!-- Tabla para mostrar servicios -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Disponibilidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($servicios as $servicio): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($servicio['Id_Servicio']); ?></td>
                        <td><?php echo htmlspecialchars($servicio['Nombre_S']); ?></td>
                        <td><?php echo htmlspecialchars($servicio['Descripción_S']); ?></td>
                        <td><?php echo htmlspecialchars($servicio['Precio_S']); ?></td>
                        <td><?php echo htmlspecialchars($servicio['Categoría_S']); ?></td>
                        <td><?php echo $servicio['Disponibilidad_S'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars($servicio['Nombre_S']); ?>', <?php echo $servicio['Id_Servicio']; ?>)">Eliminar</a>
                            <a href="editar_servicio.php?id=<?php echo $servicio['Id_Servicio']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>