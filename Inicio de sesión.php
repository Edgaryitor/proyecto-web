<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="css/Inicio de sesión.css">
    <script>
        // Función para mostrar notificaciones emergentes
        function mostrarNotificacion(mensaje) {
            alert(mensaje);
        }
    </script>
</head>
<body>

    <!-- Logotipo en la parte superior izquierda -->
    <div class="logo">
        <img src="img/logo.png" alt="Logotipo">
    </div>

    <!-- Contenedor principal de inicio de sesión -->
    <div class="login-container">
        <h2>Bienvenido</h2>

        <!-- Mostrar mensaje de registro exitoso -->  
        <?php  
        session_start();  
        if (isset($_SESSION['message'])) {  
            echo "<script>mostrarNotificacion('" . $_SESSION['message'] . "');</script>";  
            unset($_SESSION['message']); // Limpiar el mensaje después de mostrarlo  
        }  
        if (isset($_SESSION['error'])) {  
            echo "<script>mostrarNotificacion('" . $_SESSION['error'] . "');</script>";  
            unset($_SESSION['error']); // Limpiar el mensaje después de mostrarlo  
        }  
        ?>  

        <!-- Formulario de inicio de sesión -->
        <form action="funcionalidades_php/login.php" method="POST">
            <!-- Campo de correo o teléfono -->
            <input type="email" name="email" placeholder="CORREO ELECTRÓNICO" required>

            <!-- Campo de contraseña -->
            <input type="password" name="password" placeholder="CONTRASEÑA" required>

            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <!-- Enlace de registro -->
        <div class="register-text">
            ¿Necesitas una cuenta? <a href="Registro.html">Regístrate</a>
        </div>
    </div>

</body>
</html>
