<?php
// Incluimos los archivos de PHPMailer utilizando rutas relativas
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Verificamos si se han enviado los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturamos los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Creamos una instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuramos el servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.zoho.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contacto@zrcarlos20.xyz';  // Reemplaza con tu nombre de usuario SMTP de Zoho
        $mail->Password = '06082003Jc#';  // Reemplaza con tu contraseña SMTP de Zoho
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configuramos el remitente y el destinatario
        $mail->setFrom('contacto@zrcarlos20.xyz', 'ZR les desea buen dia');
        $mail->addAddress($email); // Usamos la dirección de correo electrónico proporcionada en el formulario

        // Asunto y cuerpo del mensaje
        $mail->Subject = 'FormularioS ZR';
        $mail->Body    = "Nombre: $nombre\r\nEmail: $email\r\nMensaje: $mensaje";

        // Habilitamos la depuración para obtener más información
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Intentamos enviar el correo
        if ($mail->send()) {
            // Redireccionamos al usuario a la página de confirmación
            header("Location: confirmacion.html");
            exit; // Aseguramos que el código posterior no se ejecute después de la redirección
        } else {
            echo "Error al enviar el correo: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo "Error al enviar el correo: " . $e->getMessage();
    }
} else {
    // Si no se han enviado los datos por POST, redirigimos o mostramos un mensaje de error
    echo "Error: Los datos del formulario no fueron enviados correctamente.";
}
?>
