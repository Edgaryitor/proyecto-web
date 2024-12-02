<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Inicio de sesión.php");
    exit();
}
include '../funcionalidades_php/db.php'; // Incluye el archivo de conexión a la base de datos

// Lógica para añadir productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    // Manejar la subida de la imagen
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_filename = $target_dir . $nombre . ".jpg";

    // Verificar si el archivo es una imagen real
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $new_filename)) {
            $imagen = "uploads/" . $nombre . ".jpg";

            $stmt = $conn->prepare("INSERT INTO Producto (Nombre_P, Descripción_P, Precio_P, Categoría_P, Disponibilidad_P, Imagen_P, Id_Administrador) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsisi", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $imagen, $_SESSION['admin_id']);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "El archivo no es una imagen.";
    }
}

// Lógica para eliminar productos
if (isset($_GET['delete'])) {
    $id_producto = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM Producto WHERE Id_Producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $stmt->close();
}

// Lógica para editar productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $categoria = $_POST['categoria'];
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0;

    // Manejar la subida de la imagen
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["imagen"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $new_filename = $target_dir . $nombre . ".jpg";

    // Verificar si el archivo es una imagen real
    $check = getimagesize($_FILES["imagen"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $new_filename)) {
            $imagen = "uploads/" . $nombre . ".jpg";

            $stmt = $conn->prepare("UPDATE Producto SET Nombre_P = ?, Descripción_P = ?, Precio_P = ?, Categoría_P = ?, Disponibilidad_P = ?, Imagen_P = ? WHERE Id_Producto = ?");
            $stmt->bind_param("ssdsisi", $nombre, $descripcion, $precio, $categoria, $disponibilidad, $imagen, $id_producto);
            $stmt->execute();
            $stmt->close();
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "El archivo no es una imagen.";
    }
}

// Consultar productos
$result = $conn->query("SELECT * FROM Producto");
$productos = $result->fetch_all(MYSQLI_ASSOC);
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>
    <link rel="stylesheet" href="../css/Admin.css">
    <script>
        function confirmarEliminacion(nombre, id) {
            if (confirm(`¿Seguro que quieres eliminar el producto ${nombre}?`)) {
                window.location.href = `gestionar_productos.php?delete=${id}`;
            }
        }
    </script>
</head>

<body>
    <header>
        <h1>Gestionar Productos</h1>
        <nav>
            <a href="../admin_dashboard.php">Volver al Panel</a>
            <a href="logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Productos</h2>

        <!-- Formulario para añadir productos -->
        <form action="gestionar_productos.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_product" value="1">
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
            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" name="imagen" required>
            <button type="submit">Añadir Producto</button>
        </form>

        <!-- Tabla para mostrar productos -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Disponibilidad</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($producto['Id_Producto']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Nombre_P']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Descripción_P']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Precio_P']); ?></td>
                        <td><?php echo htmlspecialchars($producto['Categoría_P']); ?></td>
                        <td><?php echo $producto['Disponibilidad_P'] ? 'Sí' : 'No'; ?></td>
                        <td><img src="../<?php echo htmlspecialchars($producto['Imagen_P']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre_P']); ?>" style="max-width: 100px; height: auto;"></td>
                        <td>
                            <a href="javascript:void(0);" onclick="confirmarEliminacion('<?php echo htmlspecialchars($producto['Nombre_P']); ?>', <?php echo $producto['Id_Producto']; ?>)">Eliminar</a>
                            <a href="editar_producto.php?id=<?php echo $producto['Id_Producto']; ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>