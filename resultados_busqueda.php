<?php  
include 'funcionalidades_php/db.php'; 

// Obtener la consulta de búsqueda y los filtros
$query = $_GET['query'];
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 999999;
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Consulta para obtener los productos que coincidan con la palabra ingresada y los filtros
$sql = "SELECT * FROM Producto WHERE (Nombre_P LIKE ? OR Descripción_P LIKE ?) AND Precio_P BETWEEN ? AND ? ORDER BY Precio_P $order";
$stmt = $conn->prepare($sql);
$search_term = '%' . $query . '%';
$stmt->bind_param("ssdd", $search_term, $search_term, $min_price, $max_price);
$stmt->execute();
$result = $stmt->get_result();
$productos = [];

if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $productos[] = $row; // Almacena cada producto en el array  
    }  
} else {  
    echo "No se encontraron productos que coincidan con la búsqueda.";  
}  

$conn->close(); // Cierra la conexión a la base de datos  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Resultados de Búsqueda</title>  
    <link rel="stylesheet" href="css/ResultadosBusqueda.css">  
</head>  
<body>  
    <!-- Encabezado con logotipo y barra de búsqueda -->  
    <header>  
        <h1>Resultados de Búsqueda</h1>  
        <div class="logo">  
            <img src="img/logo.png" alt="Logotipo">  
        </div>  
    </header>  

    <div class="search-bar">  
        <div class="search-container">  
            <form action="resultados_busqueda.php" method="GET">
                <input type="text" name="query" placeholder="¿Buscas algo en específico?" value="<?php echo htmlspecialchars($query); ?>">
                <button type="submit"><img src="img/lupa.png" alt="Buscar" width="20"></button>
            </form>
        </div>  
        <div class="message">  
            <p>"Calidad y seguridad al mejor precio"</p>  
        </div>  
    </div>  
    
    <div class="linea-separadora"></div>  

    <!-- Barra de navegación -->  
    <nav>  
        <a href="Perfil.php" class="logo-perfil">  
            <img src="img/icono-perfil.png" alt="Perfil">  
            Perfil  
        </a>  
        <a href="Inicio.php">Inicio</a>  
        <a href="Información.html">Acerca de nosotros</a>  
        <a href="Productos.php">Productos</a>  
        <a href="Servicios.php">Servicios disponibles</a>  
        <a href="Presupuesto.php">Presupuesto</a>  
    </nav>  

    <!-- Filtros de búsqueda -->
    <div class="filtros">
        <form action="resultados_busqueda.php" method="GET">
            <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>">
            <label for="min_price">Precio mínimo:</label>
            <input type="number" name="min_price" id="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
            <label for="max_price">Precio máximo:</label>
            <input type="number" name="max_price" id="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
            <label for="order">Ordenar por precio:</label>
            <select name="order" id="order">
                <option value="asc" <?php if ($order == 'asc') echo 'selected'; ?>>Ascendente</option>
                <option value="desc" <?php if ($order == 'desc') echo 'selected'; ?>>Descendente</option>
            </select>
            <button type="submit">Aplicar filtros</button>
        </form>
    </div>

    <section class="productos">  
        <?php if (empty($productos)): ?>  
            <p>No se encontraron productos que coincidan con la búsqueda.</p>  
        <?php else: ?>  
            <?php foreach ($productos as $producto): ?>  
            <div class="producto">  
                <img src="<?php echo htmlspecialchars($producto['Imagen_P']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre_P']); ?>">  
                <h2><?php echo htmlspecialchars($producto['Nombre_P']); ?></h2>  
                <p><strong>Precio:</strong> $<?php echo number_format($producto['Precio_P'], 2); ?></p>   
                <button onclick="mostrarVentana(<?php echo $producto['Id_Producto']; ?>)">Ver más</button>  
            </div>  
            <?php endforeach; ?>  
        <?php endif; ?>  
    </section>  

    <!-- Ventana emergente -->  
    <div id="ventanaEmergente" class="ventana">  
        <div class="contenido">  
            <span class="cerrar" onclick="cerrarVentana()">&times;</span>  
            <img id="productoImagen" src="" alt="" style="max-width: 100%; height: auto;">  
            <h2 id="productoTitulo"></h2>  
            <p><strong>Descripción:</strong> <span id="productoDescripcion"></span></p>  
            <p><strong>Precio:</strong> <span id="productoPrecio"></span></p>  
            <p><strong>Categoría:</strong> <span id="productoCategoria"></span></p>  
            <p><strong>Disponibilidad:</strong> <span id="productoDisponibilidad"></span></p>  
            <button>Agregar al presupuesto</button>
        </div>  
    </div>

    <script>  
        const productos = <?php echo json_encode($productos); ?>;  
    </script>  
    <script src="js/script_ventana.js"></script>
</body>  
</html>
