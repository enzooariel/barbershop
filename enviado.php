<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])) {
    // 1. Recibir y Sanear Datos
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellido = htmlspecialchars(trim($_POST['apellido']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $date = htmlspecialchars(trim($_POST['date']));

    // 2. Validar Campos Vacíos
    if (empty($nombre) || empty($apellido) || empty($email) || empty($date)) {
        echo "Todos los campos son obligatorios.";
        exit();
    }

    // 3. Validar Correo Electrónico
    if ($email) {
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'enzooarielok@gmail.com'; // Tu dirección de correo de Gmail
            $mail->Password = 'Guerra1997?'; // Tu contraseña de Gmail
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuración del correo
            $mail->setFrom('enzooarielok@gmail.com', 'Enzo Alcon');
            $mail->addAddress('enzooarielok@hotmail.com');

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = "Nuevo turno solicitado por $nombre $apellido";
            $mail->Body    = "
            <html>
            <body>
            <div style='background-color: aliceblue; border: 2px darkblue solid; padding: 1rem'>
                <p>Recibiste un mail de: $nombre $apellido</p>
                <p>Su email es: $email</p>
                <p>Turno solicitado el: $date</p>
            </div>
            </body>
            </html>
            ";

            // Enviar correo
            $mail->send();
            header("Location: enviado.html");
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo. Por favor, intenta nuevamente. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Dirección de correo electrónico no válida.";
    }
} else {
    echo "No se recibió ningún dato.";
}
?>
