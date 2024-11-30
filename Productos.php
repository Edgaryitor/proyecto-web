<?php  
session_start();  
include 'funcionalidades_php/db.php'; 

// Verificar que el usuario esté autenticado  
if (!isset($_SESSION['user_id'])) {  
    header("Location: Inicio de sesión.php"); // Redirigir si no está autenticado  
    exit();  
}  

// Consulta para obtener todos los productos  
$query = "SELECT * FROM Producto WHERE Disponibilidad_P = 1"; // Solo productos en stock  
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
    <title>Catálogo de productos</title>  
    <link rel="stylesheet" href="css/Productos.css">  
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
            <input type="text" placeholder="¿Buscas algo en específico?">  
            <button><img src="img/lupa.png" alt="Buscar" width="20"></button>  
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
        <a href="Inicio.html">Inicio</a>  
        <a href="Información.html">Acerca de nosotros</a>  
        <a href="Productos.php">Productos</a>  
        <a href="Servicios.php">Servicios disponibles</a>  
        <a href="Presupuesto.php">Presupuesto</a>  
    </nav>  

    <section class="productos">  
        <?php foreach ($productos as $producto): ?>  
        <div class="producto">  
            <img src="<?php echo htmlspecialchars($producto['Imagen_P']); ?>" alt="<?php echo htmlspecialchars($producto['Nombre_P']); ?>">  
            <h2><?php echo htmlspecialchars($producto['Nombre_P']); ?></h2>  
            <p><strong>Precio:</strong> $<?php echo number_format($producto['Precio_P'], 2); ?></p>   
            <button onclick="mostrarVentana(<?php echo $producto['Id_Producto']; ?>)">Ver más</button>  
        </div>  
        <?php endforeach; ?>  
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