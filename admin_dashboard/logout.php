<?php
session_start();
session_destroy();
header("Location: ../Inicio de sesión.php");
exit();
?>
