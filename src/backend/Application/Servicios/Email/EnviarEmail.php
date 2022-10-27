<?php

namespace App\backend\Application\Servicios\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EnviarEmail {

    static public function enviar(
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
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $_ENV['HOST_MAIL'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['MAIL_DIRECCION'];
            $mail->Password = $_ENV['MAIL_PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = intval($_ENV['MAIL_PUERTO']);

            //destinatario
            $mail->setFrom($emailEmisor ?? $_ENV['MAIL_DIRECCION'],$cargo);
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
}