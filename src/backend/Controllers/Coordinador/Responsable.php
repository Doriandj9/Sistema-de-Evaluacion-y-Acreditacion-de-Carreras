<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\EmailMensajes;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\Evidencias;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Reportes;
use App\backend\Models\Responsabilidades;
use App\backend\Models\UsuariosDocente;
use App\backend\Models\UsuariosResponsabilidad;
use Dompdf\Dompdf;
use Dompdf\Options;

class Responsable implements Controller
{
    private PeriodoAcademico $periodo;
    private Responsabilidades $responsabilidades;
    private Evidencias $evidencias;
    private Docente $docentes;
    private Carreras $carreras;
    private UsuariosResponsabilidad $usuariosResponsabilidad;
    private UsuariosDocente $usuariosDocente;
    private Reportes $reportes;
    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->responsabilidades = new Responsabilidades;
        $this->docentes = new Docente;
        $this->carreras = new Carreras;
        $this->evidencias = new Evidencias;
        $this->usuariosDocente = new UsuariosDocente;
        $this->usuariosResponsabilidad = new UsuariosResponsabilidad;
        $this->reportes = new Reportes;
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
            $correo = $this->docentes->selectFromColumn('id',$id_docente)->first()->correo;
            $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
            $datos_usuarios_docentes = [
                'id_usuarios' => Docente::DOCENTES,
                'id_docentes' => $id_docente,
                'id_carrera' => trim($_SESSION['carrera']),
                'fecha_inicial' => trim($_POST['f_i']),
                'fecha_final' => trim($_POST['f_f']),
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
            [$carrera,trim($_POST['f_i']),trim($_POST['f_f'])],
            true,
            $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
           );
        }else {
            $correo = $this->docentes->selectFromColumn('id',$id_docente)->first()->correo;
            $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first()->nombre;
            $datos_usuarios_docentes = [
                'fecha_inicial' => trim($_POST['f_i']),
                'fecha_final' => trim($_POST['f_f']),
                'estado' => 'activo'
            ];
            try{
                $this->usuariosDocente->updateUsuarioCarrera(
                    Docente::DOCENTES,
                    $id_docente,
                    trim($_SESSION['carrera']),
                    $datos_usuarios_docentes
                );
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
                [$carrera,trim($_POST['f_i']),trim($_POST['f_f'])],
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
                'id_periodo_academico' => trim($_POST['periodo']),
                'fecha_inicial' => trim($_POST['f_i']),
                'fecha_final' => trim($_POST['f_f']),
            ];
            $responsabilidad = UsuariosResponsabilidad::whereRaw(
                'id_usuarios = ? and id_responsabilidad = ? and id_docentes = ?
                and id_carrera = ? and id_periodo_academico = ?',
                [Docente::DOCENTES,intval($responsabilidad),$id_docente,trim($_SESSION['carrera']),trim($_POST['periodo'])]
            )->get()->count();
            if($responsabilidad >= 0){
                continue;
            }
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

    public function registarEvaluadores() {
        $periodo = $this->periodo->selectFromColumn('id',trim($_POST['periodo']))->first();
        $data_evaluadores = [
            'id_usuarios' => Docente::EVALUADORES,
            'id_docentes' => trim($_POST['docente']),
            'id_carrera' => trim($_SESSION['carrera']),
            'fecha_inicial' => $periodo->fecha_inicial,
            'fecha_final' => $periodo->fecha_final,
            'estado' => 'activo',
            'carrera' => trim($_SESSION['carrera'])
        ];
        $usuarioEvaludor = UsuariosDocente::where('id_usuarios',Docente::EVALUADORES)
        ->where('id_docentes',trim($_POST['docente']))
        ->where('id_carrera',trim($_SESSION['carrera']))
        ->get();
        $docente = $this->docentes->selectFromColumn('id',trim($_POST['docente']))->first();
        $carrera = $this->carreras->selectFromColumn('id',trim($_SESSION['carrera']))->first();
        $respuestEmail = new \stdClass;
        if($usuarioEvaludor->count() >= 1){
            try{
                $this->usuariosDocente->updateUsuarioCompleto(
                    Docente::EVALUADORES,
                    trim($_POST['docente']),
                    trim($_SESSION['carrera']),
                    [
                        'fecha_inicial' => $periodo->fecha_inicial,
                        'fecha_final' => $periodo->fecha_final,
                        'carrera' => $_SESSION['carrera']
                    ]
                );
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }
        }else {
            try{
                $this->usuariosDocente->insert($data_evaluadores);
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }
        }
        $respuestEmail = EmailMensajes::evluador(
            $_ENV['MAIL_DIRECCION'],
            $docente->correo,
            [$carrera->nombre],
            true,
            $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
        );

        Http::responseJson(json_encode([
            'ident' => 1,
            'mensaje' => 'Se ingreso correctamente el evaluador',
            'identEmail' => $respuestEmail->ident === 1 ? 1 : 0,
            'email' => $respuestEmail->mensaje ?? 'undefined'
        ]));
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

    public function listarEvaluadores() {
        $evaluadores = $this->usuariosDocente->listarEvaluadores(trim($_SESSION['carrera']));
        Http::responseJson(json_encode([
            'ident' => 1,
            'evaluadores' => $evaluadores
        ]));
    }

    public function reporte(){
        if(!isset($_GET['periodo'])){
        Http::redirect('/coordinador/responsables');
        }

        $responsables = $this->reportes->datosCrononogramaResponsables(
            trim($_SESSION['carrera']),
            trim($_GET['periodo'])
        );
        $this->mostrarReporte($responsables);
    }

    private function mostrarReporte($datos){
        date_default_timezone_set('America/Guayaquil');
        $html = file_get_contents('./src/backend/Views/templates/layout_reporte_responsables.html');
        $body = '';
        foreach($datos  as $dato) {
            $cedula = array_unique(preg_split('/---/',$dato->id_docente));
            $apellido = array_unique(preg_split('/---/',$dato->apellido));
            $correo = array_unique(preg_split('/---/',$dato->correo));
            $criterios = array_unique(preg_split('/---/',$dato->nombre_criterio));
            $f_i = array_unique(preg_split('/---/',$dato->fecha_inicial));
            $f_f = array_unique(preg_split('/---/',$dato->fecha_final));
            $body .= '<tr>
                <td>'. $cedula[0] .'</td>
                <td>'. $dato->nombre_docente . ' ' . preg_split('/ /',$apellido[0])[0] .'</td>
                <td>'. $correo[0] .'</td>
                <td>'. implode(',',$f_i) .'</td>
                <td>'. implode(',',$f_f) .'</td>
                <td>'. implode(', ',$criterios) .'</td>
                ';
            $body .= '</tr>';
        }

        $carrera = $this->carreras->selectFromColumn('id',$_SESSION['carrera'])->first();
        $fecha = new \DateTime(); 
        $html = preg_replace('/%content-tbody%/',$body,$html);
        $html = preg_replace('/%carrera%/',strtoupper($carrera->nombre),$html);
        $html = preg_replace('/%title%/','Reporte de evidencias almacenadas',$html);
        $html = preg_replace('/%fecha%/',$fecha->format('Y/m/d'),$html);
        $html = preg_replace('/%hora%/',$fecha->format('H:i'),$html);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $pdf = new Dompdf($options);
        $pdf->setPaper('A4','landscape');
        $pdf->loadHtml($html);
        $pdf->render();
        header('Content-Type: application/pdf');
        // $pdf->stream('reporteComplet.pdf',['compress' => 1]);
        header("Content-Disposition: inline; filename= Reporte de Cronograma.pdf");
        echo $pdf->output(['compress'=>1]);
    }
}