<?php
include 'db.php';
session_start(); // Inicia la sesión para manejar los mensajes  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario es un administrador
    $stmt = $conn->prepare("SELECT * FROM Administrador WHERE Correo_e_A = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['Contraseña_A'])) {
        // Iniciar sesión como administrador
        $_SESSION['admin_id'] = $admin['Id_Administrador'];
        $_SESSION['admin_name'] = $admin['Nombre_A'];
        header("Location: ../admin_dashboard.php");
        exit();
    } else {
        // Verificar si el usuario es un usuario regular
        $stmt = $conn->prepare("SELECT * FROM Usuario WHERE Correo_e_U = ?");
        $stmt->bind_param("s", $email); // "s" indica que el parámetro es una cadena  
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verifica la contraseña  
            if (password_verify($password, $row['Contraseña_U'])) {
                // Aquí se realiza la sesión  
                $_SESSION['user_id'] = $row['Id_Usuario'];
                $_SESSION['full_name'] = $row['Nombre_U']; // Almacenar el nombre completo  
                $_SESSION['email'] = $row['Correo_e_U']; // Almacenar el correo electrónico  
                $_SESSION['phone'] = $row['Teléfono_U']; // Almacenar el número de teléfono  
                $_SESSION['birth_date'] = $row['Fecha_n_U']; // Almacenar la fecha de nacimiento  

                header("Location: ../Inicio.php"); // Redirige al usuario  
                exit(); // Asegúrate de salir después de redirigir  
            } else {
                $_SESSION['error'] = "Contraseña incorrecta";
            }
        } else {
            $_SESSION['error'] = "No existe usuario con ese email";
        }
        $stmt->close(); // Cierra la declaración  
    }
}
$conn->close();

header("Location: ../Inicio de sesión.php"); // Redirige de vuelta al formulario de inicio  
exit();
?>