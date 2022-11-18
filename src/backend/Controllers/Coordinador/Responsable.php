<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\Evidencias;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Responsabilidades;

class Responsable implements Controller
{
    private PeriodoAcademico $periodo;
    private Responsabilidades $responsabilidades;
    private Evidencias $evidencias;
    private Docente $docentes;
    private Carreras $carreras;
    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->responsabilidades = new Responsabilidades;
        $this->docentes = new Docente;
        $this->carreras = new Carreras;
        $this->evidencias = new Evidencias;
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

    }

    public function registar() {

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