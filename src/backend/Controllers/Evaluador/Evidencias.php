<?php

namespace App\backend\Controllers\Evaluador;

use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico;
use App\backend\Application\Utilidades\Http;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Application\Utilidades\FilePDF;

class Evidencias implements Controller
{
    private PeriodoAcademico $periodo;

    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;

    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodo->select(true,'id','desc');
        $variables['periodos'] = $periodos;
        return [
            'title' => 'Evalución de Documentos de Información',
            'template' => 'evaluadores/evaluacion.html.php',
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
}