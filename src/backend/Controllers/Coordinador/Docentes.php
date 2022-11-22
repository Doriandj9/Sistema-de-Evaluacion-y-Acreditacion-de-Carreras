<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Servicios\Email\EnviarEmail;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\DocentesCarreras;
use App\backend\Models\UsuariosDocente;

class Docentes implements Controller
{
    private Carreras $carreras;
    private Docente $docentes;
    private DocentesCarreras $docentesCarreras;
    private UsuariosDocente $usuariosDocentes;
    public function __construct()
    {
        $this->carreras = new Carreras;
        $this->docentes = new Docente;
        $this->docentesCarreras = new DocentesCarreras;
        $this->usuariosDocentes = new UsuariosDocente;

    }

    public function vista($variables = []): array
    {
        return [
            'title' => 'Administracióm de Docentes',
            'template' => 'coordinadores/docentes.html.php'
        ];
    }

    public function listarDocentes() {
        try{
            $docentes = $this->docentes->getDocentesDeCarrera($_SESSION['carrera']);
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'docentes' => $docentes
                ]
                ));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $e->getMessage()
                ]
                ));
        }
    }

    public function registar() {
        $datos_usuarios_docentes = [
            'id_usuarios' => Docente::DOCENTES,
            'id_docentes' => trim($_POST['cedula']),
            'id_carrera' => trim($_SESSION['carrera']),
            'fecha_inicial' => trim($_POST['f_i']),
            'fecha_final' => trim($_POST['f_f']),
            'estado' => 'activo'
        ];
        $datos_docentes = [
            'id' => trim($_POST['cedula']),
            'nombre' => trim($_POST['nombres']),
            'apellido' => trim($_POST['apellidos']),
            'correo' => trim($_POST['correo']),
            'clave' => trim(password_hash(trim($_POST['cedula']),PASSWORD_DEFAULT)),
            'cambio_clave' => true
        ];
        $datos_docentes_carrera = [
            'id_carreras' => trim($_SESSION['carrera']),
            'id_docentes' => trim($_POST['cedula'])
        ];

        $docenteUsuario = UsuariosDocente::whereRaw(
            'id_usuarios = ? and id_docentes = ? and id_carrera = ?',
            [Docente::DOCENTES,trim($_POST['cedula']),trim($_SESSION['carrera'])]
        )->get();

        if(count($docenteUsuario) >= 1) {
            try{
                $this->usuariosDocentes->updateUsuarioCarrera(
                    Docente::DOCENTES,
                    trim($_POST['cedula']),
                    $_SESSION['carrera'],
                    [
                        'fecha_inicial' => trim($_POST['f_i']),
                        'fecha_final' => trim($_POST['f_f']),
                        'estado' => 'activo'
                    ]
                );
                $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
                $respuestaEmail = EnviarEmail::enviar(
                    'Docente de la carrera ' . $carrera,
                    $_ENV['MAIL_DIRECCION'],
                    trim($_POST['correo']),
                    'Sistema de Evaluacion y Acreditacion de Carreras',
                    EnviarEmail::html(
                        null,
                        'Habilitado para usar el sistema',
                        'Estimado docente ud ha sido notificado para utilizar la plataforma SEAC 
                        en la carrera <strong>' . $carrera . '</strong> se habilitado el acceso a partir
                        de la fecha <strong>' . $_POST['f_i'] . '</strong> hasta <strong>' . $_POST['f_f']
                        . '</strong> para el ingreso al servicio debe utilizar su correo institucional y 
                        la contraseña provicional sera su numero de cédula se le recomienda cambiar la misma
                        para brindarle una mayor seguridad',
                        true,
                        $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
                    // El protcolo de red si tiene ssl ser https caso contratio http
                    // esto se encuentra definido en el /index.php 
                    // por ultimo se concatena todo quedando algo asi https://example.com  
                    )
                );
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se actualizaron las fechas de acceso al sistema',
                        'identEmail' => $respuestaEmail->ident,
                        'email' => $respuestaEmail->mensaje
                    ]
                    ));
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }
        }
        $docente = $this->docentes->selectFromColumn('id',trim($_POST['cedula']));
        if(!count($docente) >= 1) {
            try{
                $this->docentes->insert($datos_docentes);
            }catch(\PDOException $e){
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }
        }
        $docenteCarrera = DocentesCarreras::whereRaw(
            'id_docentes = ? and id_carreras = ?',
            [trim($_POST['cedula']),trim($_SESSION['carrera'])]
        )->get();

        if(!count($docenteCarrera) >= 1){
            try{
                $this->docentesCarreras->insert($datos_docentes_carrera);
            }catch(\PDOException $e){
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }
        }
        // Si no existe el docente como usuario de la carrera de agrega
        try{
            $this->usuariosDocentes->insert($datos_usuarios_docentes);
            $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
                $respuestaEmail = EnviarEmail::enviar(
                    'Docente de la carrera ' . $carrera,
                    $_ENV['MAIL_DIRECCION'],
                    trim($_POST['correo']),
                    'Sistema de Evaluacion y Acreditacion de Carreras',
                    EnviarEmail::html(
                        null,
                        'Habilitado para usar el sistema',
                        'Estimado docente ud ha sido notificado para utilizar la plataforma SEAC 
                        en la carrera <strong>' . $carrera . '</strong> se habilitado el acceso a partir
                        de la fecha <strong>' . $_POST['f_i'] . '</strong> hasta <strong>' . $_POST['f_f']
                        . '</strong> para el ingreso al servicio debe utilizar su correo institucional y 
                        la contraseña provicional sera su numero de cédula se le recomienda cambiar la misma
                        para brindarle una mayor seguridad',
                        true,
                        $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
                    // El protcolo de red si tiene ssl ser https caso contratio http
                    // esto se encuentra definido en el /index.php 
                    // por ultimo se concatena todo quedando algo asi https://example.com  
                    )
                );
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se registro correctamen al docente',
                    'identEmail' => $respuestaEmail->ident,
                    'email' => $respuestaEmail->mensaje
                ]
                ));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $e->getMessage()
                ]
                ));
        }

    }
    
}