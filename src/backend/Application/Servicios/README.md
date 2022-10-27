# Servicios que necesita el Sistema de Evaluacion y Acreditacion de las Carreras

## Servicio de correo electronicos
Este servicio es utilizado para enviar correos electronicos dentro del sistema utiliza la libreria `PHPMailer`.
### Como funciona
El servicio utiliza un servidor `smt` que cada entidad lo tiene en especifico este proyecto utiliza el servicio de google mail el cual contiene las siguientes caracteristicas:
- Limites de envios: 2000 mensajes al día.
- Nombre del dominio:  smtp.gmail.com.
- Puertos: 465 (se requiere SSL),  587 (se requiere TLS).
#### Autentificación
Para autentificar el proceso para el envio de correos electronicos en la raiz del proyecto en la carpeta `config/.env` se encuentra las siguientes variables:
- HOST_MAIL: Es el dominio del servidor en el caso de google(smtp.gmail.com.)
- MAIL_DIRECCION: Es el correo electronico del usuario que va enviar los diferentes correos
- MAIL_PASSWORD: Es la clave que puede sacar en la configuracion de google en seguiridad como contraseñas de aplicacion
- MAIL_PUERTO= Es el puerto en el que se encuentra escuchando el servidor smtp
Si por otra sircuntancia desea activar la OAuth Autentification puede escribir el codigo en la clase EnviarEmail.php.
### Puesta en marcha
Para poder usar el envio de correos tiene que asegurarse que los campos de las variables anteriormente mensionados se encuentren correctamente ingresados, si esta en pruebas debe estar habilitado la opcion de debuger y ya esta en produccion el valor debe ser `0` todo esto se encuetra especificado en la clase EnviarEmail ubicado en el directorio actual en la carpeta `Email/EnviarEmail.php`.
```php
// En modo local
try {
            //Configuracion del servidor
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
```
```php
// En produccion
try {
            //Configuracion del servidor
            $mail->SMTPDebug = 0;
```

## ----------