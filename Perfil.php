<?php  
session_start();  
include 'funcionalidades_php/db.php'; // Incluye el archivo de conexión a la base de datos  

// Verificar que el usuario esté autenticado  
if (!isset($_SESSION['user_id'])) {  
    header("Location: Inicio de sesión.php"); // Redirigir si no está autenticado  
    exit();  
}  

// Obtener información del usuario de la base de datos  
$user_id = $_SESSION['user_id'];  
$stmt = $conn->prepare("SELECT * FROM Usuario WHERE Id_Usuario = ?");  
$stmt->bind_param("i", $user_id);  
$stmt->execute();  
$result = $stmt->get_result();  

if ($result->num_rows > 0) {  
    $user = $result->fetch_assoc(); // Obtener la información del usuario  
} else {  
    echo "No se encontró información del usuario.";  
    exit();  
}  
$stmt->close();  
$conn->close();  
?>  

<!DOCTYPE html>   
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Perfil</title>  
    <link rel="stylesheet" href="css/Perfil.css">  
</head>  
<body>  

    <!-- Encabezado con navegación -->  
    <header>  
        <nav>  
            <a href="Perfil.php" class="logo-perfil">  
                <img src="img/icono-perfil.png" alt="Perfil">Perfil  
            </a>  
            <a href="Inicio.html">Inicio</a>  
            <a href="Información.html">Acerca de nosotros</a>  
            <a href="Productos.html">Productos</a>  
            <a href="Servicios.html">Servicios disponibles</a>  
            <a href="Presupuesto.html">Presupuesto</a>  
        </nav>  
    </header>  

    <!-- Contenedor principal de perfil -->  
    <div class="profile-container">  
        <div class="profile-form">  
            <h2>Puedes cambiar algunos datos si lo deseas</h2>  
            
            <label>Nombre completo <span class="note">* Imposible cambiar</span></label>  
            <input type="text" class="readonly" value="<?php echo htmlspecialchars($user['Nombre_U']); ?>" readonly>  

            <label>Correo electrónico</label>  
            <input type="email" value="<?php echo htmlspecialchars($user['Correo_e_U']); ?>" required>  

            <label>Número de teléfono</label>  
            <input type="tel" value="<?php echo htmlspecialchars($user['Teléfono_U']); ?>" required>  

            <label>Contraseña</label>  
            <input type="password" placeholder="Escribe tu nueva contraseña" required>  

            <label>Fecha de nacimiento <span class="note">* Imposible cambiar</span></label>  
            <div style="display: flex; gap: 10px;">  
                <input type="text" class="readonly" value="<?php echo date('d', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 60px;">  
                <input type="text" class="readonly" value="<?php echo date('m', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 60px;">  
                <input type="text" class="readonly" value="<?php echo date('Y', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 80px;">  
            </div>  

            <button class="confirm-btn">Confirmar</button>  
        </div>  

        <div class="profile-photo">  
            <img src="img/foto" alt="Foto de perfil">  
            <button>Cambiar foto</button>  
        </div>  
    </div>  

    <!-- Logo en la esquina inferior izquierda -->  
    <div class="logo-container">  
        <img src="img/logo.png" alt="Logo">  
    </div>  

</body>  
</html>