<?php  
session_start();  
include 'funcionalidades_php/db.php'; // Asegúrate de que la ruta sea correcta  

// Consulta para obtener todos los servicios que están disponibles  
$query = "SELECT * FROM Servicio WHERE Disponibilidad_S = 1";   
$result = $conn->query($query);  
$servicios = [];  

if ($result->num_rows > 0) {  
    while ($row = $result->fetch_assoc()) {  
        $servicios[] = $row; // Almacena cada servicio en el array  
    }  
} else {  
    echo "No hay servicios disponibles.";  
}  

$conn->close(); // Cierra la conexión a la base de datos  
?>  

<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Catálogo de Servicios</title>  
    <link rel="stylesheet" href="css/Servicios.css">  
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
        <a href="Inicio.php">Inicio</a>  
        <a href="Información.html">Acerca de nosotros</a>  
        <a href="Productos.php">Productos</a>  
        <a href="Servicios.php">Servicios disponibles</a>  
        <a href="Presupuesto.php">Presupuesto</a>  
    </nav>  

    <section class="servicios">  
        <?php foreach ($servicios as $servicio): ?>  
        <div class="servicio">  
            <h3><?php echo htmlspecialchars($servicio['Nombre_S']); ?></h3>  
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($servicio['Descripción_S']); ?></p>  
            <p><strong>Precio:</strong> $<?php echo number_format($servicio['Precio_S'], 2); ?></p>  
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($servicio['Categoría_S']); ?></p>  
        </div>  
        <?php endforeach; ?>  
    </section>  

</body>  
</html>