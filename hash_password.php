<?php
// Hashear la contraseña del administrador
$hashed_password = password_hash('contra', PASSWORD_BCRYPT);

// Mostrar el valor hasheado
echo $hashed_password;
?>
