<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\FileExcel;
use App\backend\Application\Utilidades\FilePDF;
use App\backend\Application\Utilidades\FileWord;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\CarrerasEvidencias;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Models\Notificaciones;
use App\backend\Models\PeriodoAcademico;

class Evidencias implements Controller
{
    private PeriodoAcademico $periodoAcademico;
    private ModelsEvidencias $evidenciasModel;
    private CarrerasEvidencias $carrerasEvidencias;
    private Notificaciones $notificaciones;

    public function __construct()
    {
        $this->periodoAcademico = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;
        $this->carrerasEvidencias = new CarrerasEvidencias;
        $this->notificaciones = new Notificaciones;

    }
    public function vista($variables = []): array
    {
        $periodoAcademicos = $this->periodoAcademico->select(true,'id','desc');
        $variables['periodos'] = $periodoAcademicos;
        return [
            'title' => 'Evidencias del Coordinador',
            'template' => 'coordinadores/evidencias.html.php',
            'variables' => $variables
        ];
    }

    public function listarEvidenciasPorPeriodo(){
        if(!isset($_GET['periodo'])){
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error: No ingrese el campo periodo en la solicitud'
                ]
                ));
        }

        $evidencias = $this->evidenciasModel->obtenerEvidenciasPorPeriodo(
            trim($_GET['periodo']),
            trim($_SESSION['carrera'])
        );

        Http::responseJson(json_encode(
            [
                'ident' => 1,
                'evidencias' => $evidencias
            ]
            ));
    }

    public function registrar(){
        $fileName = $_FILES['file']['name'];
        $tipo = $_FILES['file']['type'];
        $fileTemporal = $_FILES['file']['tmp_name'];
        $file = file_get_contents($fileTemporal);
        $fileABase64 = base64_encode($file);
        $datosReferentes = [
            'periodo' => trim($_POST['periodo']),
            'idEvidencia' => trim($_POST['cod_evidencia']),
            'archivoBase64' => $fileABase64,
            'nombre_archivo' => $fileName
        ];
        $tiposArchivosGuardar = [
            'application/pdf' => function($datos) {
                $this->guardarArchivo('pdf',$datos);
            },
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => function($datos) {
                $this->guardarArchivo('word',$datos);
            },
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => function($datos) {
                $this->guardarArchivo('excel',$datos);
            }
        ];

        if(!isset($tiposArchivosGuardar[$tipo])){
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error: No se permite el tipo de arvhivo ' . $tipo
                 ] 
            ));
            }

        $tiposArchivosGuardar[$tipo]($datosReferentes);
        
    }

    private function guardarArchivo(string $tipo , array $datos) {
        date_default_timezone_set('America/Guayaquil');
        $fecha_registro = new \DateTime();
        $data_guardar = [
            $tipo => $datos['archivoBase64'],
            'fecha_registro' => $fecha_registro->format('Y-m-d'),
            'id_responsable' => trim($_SESSION['ci']),
            'estado' => 'Almacenado',
            'nombre_documento' => $datos['nombre_archivo']
        ];
        try{
            $result = $this->evidenciasModel->guardarEvidencia(
                trim($_SESSION['carrera']),
                $datos['periodo'],
                $datos['idEvidencia'],
                $data_guardar
            );
            if(!$result) {
                throw new \PDOException('Error al guardar el archivo');
            }
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se almaceno exitosamente el documento'
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
   
    public function returnWord() {
        if(isset($_GET['periodo']) &&
           isset($_GET['evidencia']) 
    ) {
        $evidencia = $this->evidenciasModel->obtenerEvidenciaUnica(
            trim($_SESSION['carrera']),
            trim($_GET['periodo']),
            trim($_GET['evidencia'])
        )->first();
        $file = new FileWord(); 
        $file->retornarFile($evidencia);
    }
    die;
    }
    public function returnExcel() {
        if(isset($_GET['periodo']) &&
           isset($_GET['evidencia']) 
    ) {
        $evidencia = $this->evidenciasModel->obtenerEvidenciaUnica(
            trim($_SESSION['carrera']),
            trim($_GET['periodo']),
            trim($_GET['evidencia'])
        )->first();
        $file = new FileExcel();
       $file->retornarFile($evidencia);
    }
    die;
       
    }
    public function returnPDF() {  
        if(isset($_GET['periodo']) &&
           isset($_GET['evidencia']) 
    ) {
        $evidencia = $this->evidenciasModel->obtenerEvidenciaUnica(
            trim($_SESSION['carrera']),
            trim($_GET['periodo']),
            trim($_GET['evidencia'])
        )->first();
        $file = new FilePDF();
       $file->retornarFile($evidencia);
    }
    die;
    }


    public function verificacion(){
        $periodos = $this->periodoAcademico->select(true,'id','desc');
        return [
            'title' => 'Verificación de Evidencias',
            'template' => 'coordinadores/verificacion-evidencias.html.php',
            'variables' => [
                'periodos' => $periodos
            ]
        ];
    }

    public function evidenciasPorPeriodoVerificar(){
        if(!isset($_GET['periodo'])){
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error no existe el parametro periodo en la consulta.'
                ]
                ));
        }
        $evidencias = $this->carrerasEvidencias->obtenerEvidenciasPorPeriodo(
            trim($_GET['periodo']),
            trim($_SESSION['carrera'])
        );
    Http::responseJson(json_encode(
        [
            'ident' => 1,
            'evidencias' => $evidencias
        ]
        ));
    }

    public function registarVerificacion() {
        date_default_timezone_set('America/Guayaquil');
        $data_verificacion =  [
            'verificada' => trim($_POST['verificar']) === '1' ? false : true,
            'valoracion' => trim($_POST['valoracion']),
            'comentario' => trim($_POST['comentario'])
        ];
        $date = new \DateTime();
        $data_notificacion = [
            'remitente' => trim($_SESSION['ci']),
            'receptor' => trim($_POST['receptor']),
            'mensaje' => trim($_POST['comentario']),
            'id_carrera' => trim($_SESSION['carrera']),
            'fecha' => $date->format('Y-m-d H:i:s'),
            'leido' => false
        ];
        try{
            $this->evidenciasModel->guardarEvidencia(
                trim($_SESSION['carrera']),
                trim($_POST['periodo']),
                trim($_POST['id_evidencia']),
                $data_verificacion
            );
            $this->notificaciones->insert($data_notificacion);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente su verificación'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }
}