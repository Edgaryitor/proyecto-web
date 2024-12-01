<?php  
session_start();  
include 'funcionalidades_php/db.php'; 

// Verificar que el usuario esté autenticado  
if (!isset($_SESSION['user_id'])) {  
    header("Location: Inicio de sesión.php"); // Redirigir si no está autenticado  
    exit();  
}  

// Consulta para obtener 12 productos al azar
$query = "SELECT * FROM Producto WHERE Disponibilidad_P = 1 ORDER BY RAND() LIMIT 12";  
$result = $conn->query($query);  
$productos = [];  

if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $productos[] = $row; // Almacena cada producto en el array  
    }  
} else {  
    echo "No hay productos disponibles.";  
}  

$conn->close(); // Cierra la conexión a la base de datos  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Página de Inicio</title>  
    <link rel="stylesheet" href="css/Inicio.css">  
</head>  
<body>  

    <!-- Encabezado con logotipo y barra de búsqueda -->  
    <header>  
        <h1>Prepárate para Navidad este 2024</h1>  
        <marquee width="100" scrollamount="10">JO JO JO!</marquee>  
        <div class="logo">  
            <img src="img/logo.png" alt="Logotipo">  
        </div>  
    </header>  

    <div class="search-bar">
        <div class="search-container">
            <form action="resultados_busqueda.php" method="GET">
                <input type="text" name="query" placeholder="¿Buscas algo en específico?">
                <button type="submit">
                    <img src="img/lupa.png" alt="Buscar" width="20">
                </button> 
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

    <!-- Grid de productos -->
    <div class="product-grid">
        <?php foreach ($productos as $producto): ?>  
        <div class="product-card">  
            <img src="<?php echo htmlspecialchars($producto['Imagen_P']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre_P']); ?>">  
            <p class="product-title"><?php echo htmlspecialchars($producto['Nombre_P']); ?></p>  
            <p class="product-price">$<?php echo number_format($producto['Precio_P'], 2); ?></p>  
        </div>  
        <?php endforeach; ?>  
    </div>

</body>  
</html>
