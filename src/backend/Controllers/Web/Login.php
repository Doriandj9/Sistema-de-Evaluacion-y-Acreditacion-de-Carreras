<?php

declare(strict_types=1);

namespace App\backend\Controllers\Web;

use App\backend\Application\Servicios\Email\EnviarEmail;
use App\backend\Application\Utilidades\Http;
use App\backend\Application\Utilidades\Jwt;
use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Docente;
use App\backend\Models\UsuariosDocente;

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
                Docente::DIRECTOR_PLANEAMIENTO => function () {
                    Http::redirect('/director-planeamiento');
                },
                Docente::COORDINADORES => function () {
                    Http::redirect('/coordinador');
                },
                Docente::EVALUADORES => function () {
                    Http::redirect('/evaluador');
                },
                'inicio' => function () {
                    Http::redirect('/salir');
                }
            ];
            try {
                if (isset($_SESSION['opciones']) && !$_SESSION['opciones']) {
                    Http::redirect('/opciones');
                }
                $redirecionarHacia[$_SESSION['permiso']??'inicio']();
            } catch (\ErrorException $th) {
                throw new \Error('Error no se encontro una redireccion para este usuario');
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
            $usuario->ident = 1;
            $usuario->token = $_SESSION['token'];
            $tokenDecode = Jwt::decodificadorToken($usuario->token);
            if (count(array_filter($tokenDecode->permisos, function ($permiso) {
                return $permiso === Docente::ADMIN;
            })) >= 1) {
                $usuarioDocenteModelo = new UsuariosDocente;
                $docenteModelo = new Docente;
                $usuarioD = $usuarioDocenteModelo->selectFromColumnsUsuarios(
                    'id_usuarios',
                    'id_docentes',
                    Docente::ADMIN,
                    $tokenDecode->id_usuario
                );
                // actualizamos el estado en activo o inactivo
                list($verificado, $errores) = $docenteModelo->verificacionEstado($usuarioD);

                $usuario->estado = $verificado[0]->estado;
            }
            if (count(array_filter($tokenDecode->permisos, function ($permiso) {
                return $permiso === Docente::DIRECTOR_PLANEAMIENTO;
            })) >= 1) {
                $usuarioDocenteModelo = new UsuariosDocente;
                $docenteModelo = new Docente;
                $usuarioD = $usuarioDocenteModelo->selectFromColumnsUsuarios(
                    'id_usuarios',
                    'id_docentes',
                    Docente::DIRECTOR_PLANEAMIENTO,
                    $tokenDecode->id_usuario
                );
                // actualizamos el estado en activo o inactivo
                list($verificado, $errores) = $docenteModelo->verificacionEstado($usuarioD);

                $usuario->estado = $verificado[0]->estado;
            }
            if (isset($usuario->estado) && $usuario->estado !== 'activo') {
                $error = [
                    'ident' => 0,
                    'error' => 'El usuario ingresado se encuentra inactivo, 
                    por favor comuniquese con el administrador del sistema'
                ];
                Http::responseJson(json_encode($error));
            }

            Http::responseJson(json_encode($usuario));
        } else {
            $error = [
                'ident' => 0,
                'error' => 'Usuario, email o contraseña incorrectos, intentalo nuevamente'
            ];
            Http::responseJson(json_encode($error));
        }
    }

    public function opcionesLuegoSession(): array
    {
        $usuario = $this->autentificacion->getUsuario();
        if (!$usuario) {
            http::redirect('/');
        }
        if (Docente::tienePermisos(Docente::ADMIN)) {
            http::redirect('/admin');
        }
        if (Docente::tienePermisos(Docente::DIRECTOR_PLANEAMIENTO)) {
            Http::redirect('/director-planeamiento');
        }
        if (isset($_SESSION['opciones']) && $_SESSION['opciones']) {
            http::redirect('/');
        }
        $_SESSION['opciones'] = false;
        return [
            'title' => 'FACULTAD DE CIENCIAS ADMINISTRATIVAS GESTION EMPRESARIAL E INFORMATICA - UEB',
            'template' => 'ui/opciones.html.php',
            'variables' => [
                'usuario' => $usuario
            ]
        ];
    }
    public function recuperarClave() {
        return [
            'title' => 'Recuperar Contraseña',
            'template' => 'ui/recuperar-clave.html.php'
        ];
    }
    public function enviarClaveTemporalCorreo() {
        $cedula = $_POST['cedula'];
        $usuarioTable = new Docente;
        $usuario = $usuarioTable->selectFromColumn('id',$cedula)->first();
        if(!$usuario) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => 'Error, no existe el usuario con la cédula ' . $cedula
            ]));
        }
        $pwd = uniqid('Seac');
        $pwdTem = password_hash($pwd,PASSWORD_DEFAULT);
        $data_clave_temporal = [
            'clave' => $pwdTem,
            'cambio_clave' => true
        ];
        try{
            $usuarioTable->updateValues($usuario->id,$data_clave_temporal);
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
        $html = EnviarEmail::html(null,
        'Contraseña Temporal',
        'Estimado docente, su contraseña temporal es <strong>' . $pwd .
        '</strong> , la misma que debe ser cambiada una vez que ingrese al sistema.'
        );
        $respE = EnviarEmail::enviar(
            'Docente',
            $_ENV['MAIL_DIRECCION'],
            $usuario->correo,
            'Recuperar la Clave',
            $html
        );
        if(!$respE->ident){
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $respE->mensaje
            ]));
        }

        Http::responseJson(json_encode([
            'ident' => 1,
            'mensaje' => 'Acabamos de enviar una contraseña temporal a tu correo electrónico para que
            puedas acceder a tu cuenta. Por favor, verifica tu bandeja de entrada y sigue las instrucciones 
            para establecer una contraseña segura y única.'
        ]));
    }
    public function cerrarSesion(): void
    {
        unset($_SESSION);
        session_destroy();
        Http::redirect('/');
    }
}
