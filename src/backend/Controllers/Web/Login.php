<?php

declare(strict_types=1);

namespace App\backend\Controllers\Web;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Docente;
use Error;

class Login implements Controller
{
    private $autentificacion;

    public function __construct(Autentification $autentificacion)
    {
        $this->autentificacion = $autentificacion;
    }
    public function vista($variables = []): array
    {
        if (isset($_SESSION['email'])) {
            $redirecionarHacia = [
                Docente::ADMIN => function () {
                    Http::redirect('/admin');
                },
                Docente::DOCENTES => function () {
                    Http::redirect('/docente');
                },
                Docente::SECRETARIAS => function () {
                    Http::redirect('/secretaria');
                },
                Docente::COORDINADORES => function () {
                    Http::redirect('/coordinador');
                },
                Docente::EVALUADORES => function () {
                    Http::redirect('/evaluador');
                }
            ];
            try {
                $redirecionarHacia[Docente::getUsuario($_SESSION['email'])->permisos]();
            } catch (\ErrorException $th) {
                throw new Error('Error no se encontro una redireccion para este usuario');
            }
        }
        return [
            'title' => 'Inicio de Sesion',
            'template' => 'ui/login.html.php'
        ];
    }


    public function verificarInicioSesion(): void
    {
        $usuario = $this->autentificacion->verificacionCredenciales($_POST['email'], $_POST['password']);
        if ($usuario) {
            $usuario->result = 1;
            $usuario->token = $_SESSION['token'];
            Http::responseJson(json_encode($usuario));
        } else {
            $error = ['result' => 0];
            Http::responseJson(json_encode($error));
        }
    }

    public function cerrarSesion(): void
    {
        unset($_SESSION);
        session_destroy();
        Http::redirect('/');
    }
}
