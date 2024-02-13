<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la librería de PHPMailer
require 'path/to/PHPMailer/src/Exception.php';
require 'path/to/PHPMailer/src/PHPMailer.php';
require 'path/to/PHPMailer/src/SMTP.php';

// Recoger los datos del formulario
$nombre = $_POST['name'];
$correo = $_POST['email'];
$telefono = $_POST['phone']; // Corregir aquí
$mensaje = $_POST['message'];

// Configurar el servidor SMTP de Zoho Mail
$mail = new PHPMailer(true);
try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.zoho.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'contacto@zrcarlos20.xyz';
    $mail->Password = 'ItS.qg9f';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('contacto@zrcarlos20.xyz', 'Remitente');
    $mail->addAddress($correo); // Usar el correo ingresado en el formulario como destinatario
    $mail->addReplyTo($correo, $nombre);

    // Contenido del correo
    $mail->isHTML(true);
    $mail->Subject = 'Nuevo mensaje desde el formulario de contacto';
    $mail->Body    = "Nombre: $nombre <br> Correo: $correo <br> Teléfono: $telefono <br> Mensaje: $mensaje";

    // Enviar el correo
    $mail->send();
    echo 'El mensaje ha sido enviado correctamente';
} catch (Exception $e) {
    echo "Hubo un error al enviar el mensaje: {$mail->ErrorInfo}";
}
?>