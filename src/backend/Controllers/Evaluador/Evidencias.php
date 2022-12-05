<?php

namespace App\backend\Controllers\Evaluador;

use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico;
use App\backend\Application\Utilidades\Http;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Application\Utilidades\FilePDF;
use App\backend\Models\Evaluacion;
use App\backend\Models\EvaluacionDocentes;
use App\backend\Models\EvidenciasEvaluacion;

class Evidencias implements Controller
{
    private PeriodoAcademico $periodo;
    private ModelsEvidencias $evidenciasModel;
    private Evaluacion $evaluacion;
    private EvidenciasEvaluacion $evidenciasEvaluacion;
    private EvaluacionDocentes $evaluacionDocentes;

    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;
        $this->evaluacion = new Evaluacion;
        $this->evidenciasEvaluacion = new EvidenciasEvaluacion;
        $this->evaluacionDocentes = new EvaluacionDocentes;

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

    public function registroCalificacion() {
        // Se utiliza la form tipica del ORM dado que son pocos campos
        // y se necesita el id con el que se guardar para ingresar en las siguientes tablas
        // evidencias_evaluacion y evaluacion_docentes
        $this->evaluacion->nota = trim($_POST['calificacion']);
        $this->evaluacion->observacion = strlen(trim($_POST['observacion'])) <= 0 ? 'Sin obsevaciones' :
        trim($_POST['observacion']);
        
        if(!$this->evaluacion->save()){
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => 'Ocurrio un error al guardar la calificación, intentelo mas tarde'
            ]));
        }

        //datos para la evualuacion docente
        $data_evaluacion_docente = [
            'id_evaluacion' => $this->evaluacion->id,
            'id_docente' => trim($_SESSION['ci'])
        ];
        try{
            $this->evaluacionDocentes->insert($data_evaluacion_docente);
        }catch(\PDOException  $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
        // datos para la evidencias evaluacion
        $data_evidencias_evaluacion = [
            'id_evidencia' => trim($_POST['id_evidencia']),
            'id_carrera' => trim($_SESSION['carrera']),
            'id_periodo' => trim($_POST['periodo']),
            'id_evaluacion' => $this->evaluacion->id
        ];
        
        try{
            $this->evidenciasEvaluacion->insert($data_evidencias_evaluacion);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente la calificación'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }
}