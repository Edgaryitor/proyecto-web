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

// Manejar la actualización de datos  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario  
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $nueva_contraseña = $_POST['nueva_contraseña'];

    // Verificar si el correo o el teléfono ya existen en la base de datos  
    $stmt_check = $conn->prepare("SELECT * FROM Usuario WHERE (Correo_e_U = ? OR Teléfono_U = ?) AND Id_Usuario != ?");
    $stmt_check->bind_param("ssi", $correo, $telefono, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    $error_message = ""; // Variable para almacenar el mensaje de error  

    if ($result_check->num_rows > 0) {
        // Comprobar si el correo ya está en uso  
        $row = $result_check->fetch_assoc();
        if ($row['Correo_e_U'] === $correo) {
            echo "<script>alert('El correo electrónico ya están en uso.');</script>";
        }
        // Comprobar si el teléfono ya está en uso  
        if ($row['Teléfono_U'] === $telefono) {
            echo "<script>alert('El número de teléfono ya están en uso.');</script>";
        }
    } else {
        // Manejar la carga de la foto de perfil
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $foto_tmp = $_FILES['foto_perfil']['tmp_name'];
            $foto_nombre = $user_id . '.' . pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            $foto_destino = 'uploads/' . $foto_nombre;

            // Eliminar la foto anterior si existe
            if (file_exists($user['Foto_U']) && $user['Foto_U'] !== 'img/default_profile.png') {
                unlink($user['Foto_U']);
            }

            // Mover el archivo subido a la carpeta de destino
            if (move_uploaded_file($foto_tmp, $foto_destino)) {
                // Actualizar la ruta de la foto en la base de datos
                $update_stmt = $conn->prepare("UPDATE Usuario SET Foto_U = ? WHERE Id_Usuario = ?");
                $update_stmt->bind_param("si", $foto_destino, $user_id);
                $update_stmt->execute();
                $update_stmt->close();
            } else {
                echo "<script>alert('Error al subir la foto de perfil.');</script>";
            }
        }

        // Actualizar los campos en la base de datos  
        $update_stmt = $conn->prepare("UPDATE Usuario SET Correo_e_U = ?, Teléfono_U = ? WHERE Id_Usuario = ?");
        $update_stmt->bind_param("ssi", $correo, $telefono, $user_id);

        // Si se proporciona una nueva contraseña, actualizarla  
        if (!empty($nueva_contraseña)) {
            $hashed_password = password_hash($nueva_contraseña, PASSWORD_DEFAULT); // Asegúrate de usar un hash seguro  
            $update_stmt = $conn->prepare("UPDATE Usuario SET Correo_e_U = ?, Teléfono_U = ?, Contraseña_U = ? WHERE Id_Usuario = ?");
            $update_stmt->bind_param("ssss", $correo, $telefono, $hashed_password, $user_id);
        }

        // Ejecutar la actualización  
        if ($update_stmt->execute()) {
            echo "<script>alert('Datos actualizados correctamente.'); window.location.href = 'Perfil.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar los datos.');</script>";
        }

        $update_stmt->close();
    }

    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="css/Perfil.css">
    <link rel="stylesheet" href="css/Navegación.css">
</head>

<body>

    <!-- Encabezado con navegación -->
    <header>
        <nav>
            <a href="Perfil.php" class="logo-perfil">
                <img src="img/icono-perfil.png" alt="Perfil">Perfil
            </a>
            <a href="Inicio.php">Inicio</a>
            <a href="Información.html">Acerca de nosotros</a>
            <a href="Productos.php">Productos</a>
            <a href="Servicios.php">Servicios disponibles</a>
            <a href="Presupuesto.php">Presupuesto</a>
        </nav>
    </header>

    <!-- Contenedor principal de perfil -->
    <div class="profile-container">
        <div class="profile-form">
            <h2>Puedes cambiar algunos datos si lo deseas</h2>

            <form action="Perfil.php" method="POST" enctype="multipart/form-data"> <!-- Asegúrate de que el formulario permita la carga de archivos -->
                <label>Nombre completo <span class="note">* Imposible cambiar</span></label>
                <input type="text" class="readonly" value="<?php echo htmlspecialchars($user['Nombre_U']); ?>" readonly>

                <label>Correo electrónico</label>
                <input type="email" name="correo" value="<?php echo htmlspecialchars($user['Correo_e_U']); ?>" required>

                <label>Número de teléfono</label>
                <input type="tel" name="telefono" value="<?php echo htmlspecialchars($user['Teléfono_U']); ?>" required>

                <label>Contraseña</label>
                <input type="password" name="nueva_contraseña" placeholder="Escribe tu nueva contraseña (vacío para no cambiar nada)">

                <label>Fecha de nacimiento <span class="note">* Imposible cambiar</span></label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" class="readonly" value="<?php echo date('d', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 60px;">
                    <input type="text" class="readonly" value="<?php echo date('m', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 60px;">
                    <input type="text" class="readonly" value="<?php echo date('Y', strtotime($user['Fecha_n_U'])); ?>" readonly style="width: 80px;">
                </div>

                <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*" style="display: none;">
                <button type="submit" class="confirm-btn">Confirmar</button>
            </form>
        </div>

        <div class="profile-photo">
            <label>Foto de perfil</label>
            <img src="<?php echo htmlspecialchars($user['Foto_U']); ?>" alt="Foto de perfil">
            <button type="button" class="change-photo-btn" onclick="document.getElementById('foto_perfil').click();">Cambiar foto</button>
        </div>
    </div>

    <!-- Logo en la esquina inferior izquierda -->
    <div class="logo-container">
        <img src="img/logo.png" alt="Logo">
    </div>

</body>

</html>