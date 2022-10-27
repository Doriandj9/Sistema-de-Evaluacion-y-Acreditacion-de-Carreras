<?php

namespace App\backend\Application\Servicios\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EnviarEmail
{

    public static function enviar(
        string $cargo,
        string $emailEmisor,
        string $emailReceptor,
        string $tema,
        string $cuerpo,
    ): \stdClass {
        $respuesta = new \stdClass;
        $mail = new PHPMailer(true);
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        try {
            //Configuracion del servidor
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $_ENV['HOST_MAIL'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_DIRECCION'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = intval($_ENV['MAIL_PUERTO']);

            //destinatario
            $mail->setFrom($emailEmisor ?? $_ENV['MAIL_DIRECCION'], $cargo);
            $mail->addAddress($emailReceptor);

            //contenido
            $mail->isHTML(true);
            $mail->Subject = $tema;
            $mail->Body = $cuerpo;

            //envio
            $mail->send();

            //respuesta
            $respuesta->ident = 1;
            $respuesta->mensaje = 'Correo enviado con exito';
            return $respuesta;
        } catch (Exception $e) {
            //error respuesta
            $respuesta->ident = 0;
            $respuesta->mensaje = $e->errorMessage();
            return $respuesta;
        }
    }

    public static function html(
        string $html = null,
        string $titulo = 'Titulo Predeterminado',
        string $mensaje = 'No hay mensaje',
        bool $redireccion = false,
        string $dir = ''
    ) {
        if ($html) {
            return $html;
        }

        $htmlTemplate = file_get_contents('./public/templates/mail.html');
        $htmlTemplate = str_replace('%titulo%', $titulo, $htmlTemplate);
        $htmlTemplate = str_replace('%mensaje%', $mensaje, $htmlTemplate);

        if ($redireccion) {
            $htmlTemplate = str_replace('% hidden %', ' ', $htmlTemplate);
            $htmlTemplate = str_replace('%dir%', $dir, $htmlTemplate);
        }

        return $htmlTemplate;
    }
}
