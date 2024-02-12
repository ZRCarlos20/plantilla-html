<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar los campos del formulario
    if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(500);
        exit();
    }

    // Obtener datos del formulario y sanearlos
    $name = strip_tags(htmlspecialchars($_POST['name']));
    $email = strip_tags(htmlspecialchars($_POST['email']));
    $phone = strip_tags(htmlspecialchars($_POST['phone']));
    $message = strip_tags(htmlspecialchars($_POST['message']));

    // Configuración del destinatario (tu correo de Zoho)
    $to_zoho = "contacto@zrcarlos20.xyz"; // Cambia este correo al de tu cuenta de Zoho
    $subject_zoho = "Mensaje de contacto: $name";
    $body_zoho = "Has recibido un nuevo mensaje desde el formulario de contacto de tu sitio web.\n\n" . "Detalles:\n\nNombre: $name\n\nEmail: $email\n\nTeléfono: $phone\n\nMensaje: $message";

    // Configuración de PHPMailer para Zoho
    $mail_zoho = new PHPMailer(true);
    $mail_zoho->SMTPDebug = SMTP::DEBUG_SERVER; // Puedes usar SMTP::DEBUG_OFF para desactivar la depuración
    $mail_zoho->isSMTP();
    $mail_zoho->Host       = "smtp.zoho.com";
    $mail_zoho->SMTPAuth   = true;
    $mail_zoho->Username   = "contacto@zrcarlos20.xyz";
    $mail_zoho->Password   = "ItS.qg9f"; // Aquí debes colocar tu contraseña de Zoho
    $mail_zoho->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail_zoho->Port       = 587;

    // Configurar el remitente y destinatario para Zoho
    $mail_zoho->setFrom("contacto@zrcarlos20.xyz", $name);
    $mail_zoho->addAddress($to_zoho);

    // Configurar el contenido del mensaje para Zoho
    $mail_zoho->isHTML(true);
    $mail_zoho->Subject = $subject_zoho;
    $mail_zoho->Body    = $body_zoho;

    // Intentar enviar el mensaje a Zoho
    try {
        $mail_zoho->send();
    } catch (Exception $e) {
        http_response_code(500);
        exit();
    }

    // Enviar correo a la dirección ingresada por el usuario
    $subject_user = "Gracias por ponerte en contacto, $name";
    $body_user = "¡Gracias por ponerte en contacto con nosotros, $name!\n\nHemos recibido tu mensaje y nos pondremos en contacto contigo pronto.\n\nDetalles:\n\nNombre: $name\n\nEmail: $email\n\nTeléfono: $phone\n\nMensaje: $message";

    // Configuración de PHPMailer para el usuario
    $mail_user = new PHPMailer(true);
    $mail_user->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail_user->isSMTP();
    $mail_user->Host       = "smtp.zoho.com";
    $mail_user->SMTPAuth   = true;
    $mail_user->Username   = "contacto@zrcarlos20.xyz";
    $mail_user->Password   = "ItS.qg9f"; // Aquí debes colocar tu contraseña de Zoho
    $mail_user->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail_user->Port       = 587;

    // Configurar el remitente y destinatario para el usuario
    $mail_user->setFrom("contacto@zrcarlos20.xyz", $name);
    $mail_user->addAddress($email);

    // Configurar el contenido del mensaje para el usuario
    $mail_user->isHTML(true);
    $mail_user->Subject = $subject_user;
    $mail_user->Body    = $body_user;

    // Intentar enviar el mensaje al usuario
    try {
        $mail_user->send();
    } catch (Exception $e) {
        http_response_code(500);
        exit();
    }
}
?>
