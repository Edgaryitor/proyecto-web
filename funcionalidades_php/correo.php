<?php
function enviarCorreo($destinatario, $asunto, $mensaje)
{
    $headers = "From: no-reply@tu-dominio.com\r\n";
    mail($destinatario, $asunto, $mensaje, $headers);
}
?>