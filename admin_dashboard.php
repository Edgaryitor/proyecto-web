<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../Inicio de sesión.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="css/Admin.css">
</head>

<body>
    <header>
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_name']); ?></h1>
        <nav>
            <a href="admin_dashboard/gestionar_productos.php">Gestionar Productos</a>
            <a href="admin_dashboard/gestionar_servicios.php">Gestionar Servicios</a>
            <a href="admin_dashboard/logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    <main>
        <h2>Panel de Administración</h2>
        <p>Desde aquí puedes gestionar productos y servicios.</p>
    </main>
</body>

</html>