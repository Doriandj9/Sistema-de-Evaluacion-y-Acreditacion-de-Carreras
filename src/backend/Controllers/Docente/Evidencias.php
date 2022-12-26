<?php

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;
use App\backend\Application\Utilidades\FileExcel;
use App\backend\Application\Utilidades\FilePDF;
use App\backend\Application\Utilidades\FileWord;
use App\backend\Application\Utilidades\Http;
use App\backend\Models\Docente;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Models\PeriodoAcademico;


class Evidencias implements Controller
{
    private PeriodoAcademico $periodoAcademico;
    private ModelsEvidencias $evidenciasModel;
    private Docente $docente;
    public function __construct()
    {
        $this->periodoAcademico = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;
        $this->docente = new Docente;
    }

    public function vista($variables = []): array
    {
        $periodoAcademicos = $this->periodoAcademico->select(true,'id','desc');
        $variables['periodos'] = $periodoAcademicos;
        return [
            'title' => 'Docente - Evidencias',
            'template' => 'docentes/evidencias.html.php',
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
        $docente = $this->docente->selectFromColumn('correo',trim($_SESSION['email']))->first();
        $evidencias = $this->evidenciasModel->obtenerEvidenciasPorPeriodoYResponsabilidades(
            trim($_GET['periodo']),
            trim($_SESSION['carrera']),
            $docente->id
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
            // redirecionamos al metodo gurdarArchivos 
            // como si : $this->guardarArchivo(tipo,datos);
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
    exit;
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
    exit;
       
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
    exit;
    }
}