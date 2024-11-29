<?php  
include 'db.php';  

session_start(); // Inicia la sesión para manejar los mensajes

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $email = $_POST['email'];  
    $password = $_POST['password'];  

    // Consulta de usuario usando sentencias preparadas  
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
            header("Location: ../Inicio.html"); // Redirige al usuario  
            exit(); // Asegúrate de salir después de redirigir  
        } else {  
            $_SESSION['error'] = "Contraseña incorrecta";  
        }  
    } else {  
        $_SESSION['error'] = "No existe usuario con ese email";  
    }  
    $stmt->close(); // Cierra la declaración  
}  
$conn->close();  

header("Location: ../Inicio de sesión.php"); // Redirige de vuelta al formulario de inicio
exit();  
?>
