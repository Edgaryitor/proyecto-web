<?php  
include 'db.php';  

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
    $nombre = $_POST['full_name'];  
    $email = $_POST['email'];  
    $telefono = $_POST['phone'];  
    $contraseña = password_hash($_POST['password'], PASSWORD_BCRYPT);  
    $fecha_nacimiento = $_POST['day'] . '-' . $_POST['month'] . '-' . $_POST['year'];  

    try {  
        $stmt = $conn->prepare("INSERT INTO Usuario (Nombre_U, Correo_e_U, Teléfono_U, Contraseña_U, Fecha_n_U) VALUES (?, ?, ?, ?, ?)");  
        $stmt->bind_param("sssss", $nombre, $email, $telefono, $contraseña, $fecha_nacimiento);  
        $stmt->execute();  

        // Si todo es correcto, redirigir con mensaje de éxito  
        session_start();  
        $_SESSION['message'] = "Registro exitoso";  
        header("Location: ../Inicio de sesión.php");  
        exit();  
    } catch (mysqli_sql_exception $e) {  
        if (strpos($e->getMessage(), "Correo_e_U") !== false) {  
            echo "<script>
                alert('El correo electrónico ya está en uso. Por favor, usa otro.');
                window.history.back();
            </script>";  
        } elseif (strpos($e->getMessage(), "Teléfono_U") !== false) {  
            echo "<script>
                alert('El número de teléfono ya está en uso. Por favor, usa otro.');
                window.history.back();
            </script>";  
        } else {  
            echo "<script>
                alert('Ha ocurrido un error inesperado. Inténtalo nuevamente.');
                window.history.back();
            </script>";  
        }  
    }  

    $stmt->close();  
}  
$conn->close();  
?>
