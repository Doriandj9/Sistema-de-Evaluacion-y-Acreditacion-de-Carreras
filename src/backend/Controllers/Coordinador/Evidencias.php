<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\ArchivosTransformar;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Models\PeriodoAcademico;

class Evidencias implements Controller
{
    private PeriodoAcademico $periodoAcademico;
    private ModelsEvidencias $evidenciasModel;

    public function __construct()
    {
        $this->periodoAcademico = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;
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
            'archivoBase64' => $fileABase64
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
        $data_guardar = [
            $tipo => $datos['archivoBase64']
        ];
        try{
            $result = $this->evidenciasModel->guardarEvidencia(
                trim($_SESSION['carrera']) . '   ',
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
}