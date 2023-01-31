<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Servicios\Email\EnviarEmail;
use App\backend\Application\Utilidades\EmailMensajes;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\DocentesCarreras;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\UsuariosDocente;

class Docentes implements Controller
{
    private Carreras $carreras;
    private Docente $docentes;
    private DocentesCarreras $docentesCarreras;
    private UsuariosDocente $usuariosDocentes;
    private PeriodoAcademico $periodo;
    public function __construct()
    {
        $this->carreras = new Carreras;
        $this->docentes = new Docente;
        $this->docentesCarreras = new DocentesCarreras;
        $this->usuariosDocentes = new UsuariosDocente;
        $this->periodo = new PeriodoAcademico;

    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodo->select(true,'id','desc');
        $variables['periodos'] = $periodos;
        return [
            'title' => 'Administracióm de Docentes',
            'template' => 'coordinadores/docentes.html.php',
            'variables' => $variables
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
        $periodo = $this->periodo->selectFromColumn('id',trim($_POST['periodo']))->first();
        $fecha_inicial = $periodo->fecha_inicial;
        $fecha_final = $periodo->fecha_final;
        $datos_usuarios_docentes = [
            'id_usuarios' => Docente::DOCENTES,
            'id_docentes' => trim($_POST['cedula']),
            'id_carrera' => trim($_SESSION['carrera']),
            'fecha_inicial' => $fecha_inicial,
            'fecha_final' => $fecha_final,
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
                        'fecha_inicial' => $fecha_inicial,
                        'fecha_final' => $fecha_final,
                        'estado' => 'activo'
                    ]
                );
                $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
                $respuestaEmail = EmailMensajes::docentes(
                    $_ENV['MAIL_DIRECCION'],
                    trim($_POST['correo']),
                    [$carrera,$fecha_inicial,$fecha_final],
                    true,
                    $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
                        // El protcolo de red si tiene ssl ser https caso contratio http
                        // esto se encuentra definido en el /index.php 
                        // por ultimo se concatena todo quedando algo asi https://example.com  
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
                $respuestaEmail = EmailMensajes::docentes(
                    $_ENV['MAIL_DIRECCION'],
                    trim($_POST['correo']),
                    [$carrera,$fecha_inicial,$fecha_final],
                    true,
                    $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
                        // El protcolo de red si tiene ssl ser https caso contratio http
                        // esto se encuentra definido en el /index.php 
                        // por ultimo se concatena todo quedando algo asi https://example.com  
                );
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se registro correctamente al docente',
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