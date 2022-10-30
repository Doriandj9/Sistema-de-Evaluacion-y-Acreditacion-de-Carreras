<?php

declare(strict_types=1);

namespace App\backend\Frame;

use App\backend\Application\Utilidades\Http;
use App\backend\Application\Utilidades\Jwt;
use App\backend\Models\Docente;



/**
 * Esta clase se encarga de verificar que el usuario
 * existe dentro de la base de datos y tipo bien su
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
        try {
            $usuario = $this->usuarios->selectFromColumn($this->email, $email)
            ->first();
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'error' => 'Ocurrió un error con la conexión de la base de datos'
                ]
            ));
        }
        if ($usuario && password_verify($clave, trim($usuario->{$this->clave} ?? ''))) {
            session_regenerate_id();
            $_SESSION['email'] = $usuario->{$this->email};
            $_SESSION['clave'] = $usuario->{$this->clave};
            $permisos = $this->usuarios->getTodosPermisos($usuario->id);
            $permisosTok = [];
            foreach ($permisos as $permiso) {
                array_push($permisosTok, $permiso->permisos);
            }
            // Creamos un token con json web token de firebase
            // que sea único por cada inicio de session
            date_default_timezone_set('America/Guayaquil');
            $fecha = new \DateTime();
            $datos = [
                'id_usuario' => $usuario->id,
                'usuario' => $usuario->{$this->email},
                'tiempo' => $fecha->getTimestamp(),
                'permisos' => $permisosTok
            ];
            $token = Jwt::crearToken($datos);
            $_SESSION['token'] = $token;
            $usuario = Docente::getUsuario($email);
            return $usuario ?? false;
        }
        return false;
    }

    public function comprobacionSesion()
    {
        if (empty($_SESSION['email'])) {
            return false;
        }
        $usuario = $this->usuarios->selectFromColumn($this->email, $_SESSION['email'])->first();
        if ($usuario && trim($_SESSION['clave']) === trim($usuario->{$this->clave})) {
            return $usuario;
        } else {
            return false;
        }
    }

    public function getUsuario()
    {
        $result = $this->comprobacionSesion();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}
