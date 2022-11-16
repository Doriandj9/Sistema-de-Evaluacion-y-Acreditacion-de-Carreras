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
        if(ArchivosTransformar::transformarDeBase64aArchivo($fileName,$fileABase64)){
            echo 'Se guardo Correctament';
        }else{
            echo 'Mal guardado';
        }
        die;
    }
}