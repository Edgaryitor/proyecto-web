<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function enviarCorreo($destinatario, $asunto, $mensaje)
{
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'webtask32@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'xsmb ylau jmza fnim'; // Contraseña o app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Configuración del correo
        $mail->setFrom('webtask32@gmail.com', 'Web Task32');
        $mail->addAddress($destinatario); // Correo del destinatario

        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->AltBody = strip_tags($mensaje); // Contenido en texto plano

        $mail->send();
        echo 'Correo enviado correctamente';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
?>
