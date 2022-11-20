<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Servicios\Email\EnviarEmail;
use App\backend\Application\Utilidades\EmailMensajes;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\Evidencias;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Responsabilidades;
use App\backend\Models\UsuariosDocente;
use App\backend\Models\UsuariosResponsabilidad;

class Responsable implements Controller
{
    private PeriodoAcademico $periodo;
    private Responsabilidades $responsabilidades;
    private Evidencias $evidencias;
    private Docente $docentes;
    private Carreras $carreras;
    private UsuariosResponsabilidad $usuariosResponsabilidad;
    private UsuariosDocente $usuariosDocente;
    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->responsabilidades = new Responsabilidades;
        $this->docentes = new Docente;
        $this->carreras = new Carreras;
        $this->evidencias = new Evidencias;
        $this->usuariosDocente = new UsuariosDocente;
        $this->usuariosResponsabilidad = new UsuariosResponsabilidad;
    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodo->select(true,'id','desc');
        $variables['periodos'] = $periodos;
        return [
            'title' => 'Administrar Responsables',
            'template' => 'coordinadores/responsables.html.php',
            'variables' => $variables
        ];
    }

    public function listarResponsables() {
        if(isset($_GET['periodo'])){
            try{

                $responsables = $this->usuariosResponsabilidad->obtenerResponsables(
                    trim($_SESSION['carrera']),
                    trim($_GET['periodo'])
                );
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'responsables' => $responsables
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

    public function registar() {
        $id_docente = trim($_POST['docente']);
        $responsabilidades  = $_POST['responsabilidades'];
        $errores = [];
        $respuestEmail = new \stdClass();
        // Revisamos que el docente se encuentre como usuario de la carrera
        $docente = UsuariosDocente::whereRaw(
            'id_usuarios = ? and id_carrera = ? and id_docentes = ?',
            [Docente::DOCENTES,trim($_SESSION['carrera']),$id_docente]
        )->get()->count();
        if($docente <= 0){
            $periodo = $this->periodo->selectFromColumn('id',trim($_POST['periodo']))->first();
            $correo = $this->docentes->selectFromColumn('id',$id_docente)->first()->correo;
            $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
            $datos_usuarios_docentes = [
                'id_usuarios' => Docente::DOCENTES,
                'id_docentes' => $id_docente,
                'id_carrera' => trim($_SESSION['carrera']),
                'fecha_inicial' => $periodo->fecha_inicial,
                'fecha_final' => $periodo->fecha_final,
                'estado' => 'activo'
            ];
            try{
                $this->usuariosDocente->insert($datos_usuarios_docentes);
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'errores' => $e->getMessage()
                    ]
                    ));
            }
           $respuestEmail = EmailMensajes::docentes(
            $_ENV['MAIL_DIRECCION'],
            $correo,
            [$carrera,$periodo->fecha_inicial,$periodo->fecha_final],
            true,
            $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
           );
        }

        foreach($responsabilidades as $responsabilidad){
            $data_usuarios_responsabilidad = [
                'id_usuarios' => Docente::DOCENTES,
                'id_docentes' => $id_docente,
                'id_responsabilidad' => intval($responsabilidad),
                'id_carrera' => trim($_SESSION['carrera']),
                'id_periodo_academico' => trim($_POST['periodo'])
            ];
            try{
                $this->usuariosResponsabilidad->insert($data_usuarios_responsabilidad);
            }catch(\PDOException $e){
                array_push($errores,$e->getMessage());
            }
        }

        if(count($errores) >= 1){
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'errores' => $errores
                ]
                ));
        }

        Http::responseJson(json_encode(
            [
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente la responsabilidad al usuario',
                'identEmail' => $respuestEmail->ident ?? 2,
                'email' => $responsabilidad->mensaje ?? 'No es necesario enviar correo'
            ]
            ));
    }

    public function listarResponsabilidades() {
       $responsabilidades = $this->responsabilidades->select();
       $docentes = $this->carreras->getDatosDocentes(trim($_SESSION['carrera']));
       Http::responseJson(json_encode(
        [
            'ident' => 1,
            'responsabilidades' => $responsabilidades,
            'docentes' => $docentes
        ]
        ));
    }

    public function detalleEvidencia() {
        if(isset($_GET['id'])){
            $evidencia = $this->evidencias->obtenrDetalleEvidencia(trim($_GET['id']),$_SESSION['carrera']);
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'evidencia' => $evidencia
                ]
                ));
        }
    }
}