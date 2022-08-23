<?php

declare(strict_types=1);

namespace App\backend\Frame;

use App\backend\Application\Utilidades\Jwt;
use App\backend\Models\Docente;

use function PHPSTORM_META\type;

/**
 * Esta clase se encarga de verificar que el usuario
 * existe dentro de la base de datos y tipio bien su
 * contraseña
 *
 * @author Dorian Armijos
 * @link <>
 */
class Autentification
{
    private $email;
    private $clave;
    private $usuarios;

    public function __construct(
        string $email,
        string $clave,
        Docente $usuarios
    ) {
        if (session_status() <= 1) {
            session_start();
        }
        $this->email = $email;
        $this->clave = $clave;
        $this->usuarios = $usuarios;
    }

    public function verificacionCredenciales(string $email, string $clave): \stdClass|bool
    {
        $usuario = $this->usuarios->selectFromColumn($this->email, strtolower(trim($email)));
        if ($usuario && password_verify($clave, trim($usuario[0]->{$this->clave}))) {
            session_regenerate_id();
            $_SESSION['email'] = $usuario[0]->{$this->email};
            $_SESSION['clave'] = $usuario[0]->{$this->clave};
            // Creamos un token con json web token de firebase
            // que sea unico por cada inicio de session
            date_default_timezone_set('America/Guayaquil');
            $fecha = new \DateTime();
            $datos = [
                'tiempo' => $fecha->getTimestamp(),
                'usuario' => $usuario[0]->{$this->email}
            ];
            $token = Jwt::crearToken($datos);
            $_SESSION['token'] = $token;
            $usuario = $this->usuarios->getUsuario($usuario[0]->{$this->email});
            return $usuario[0];
        }
        return false;
    }

    public function comprobacionSesion(): Docente|bool
    {
        if (empty($_SESSION['email'])) {
            return false;
        }

        $usuario = $this->usuarios->selectFromColumn($this->email, $_SESSION['email']);
        if ($usuario && $_SESSION['clave'] === $usuario[0]->{$this->clave}) {
            return $usuario[0];
        }
    }

    public function getUsuario()
    {
        $result = $this->comprobacionSesion();
        if ($result) {
            return $result;
        }
    }
}
