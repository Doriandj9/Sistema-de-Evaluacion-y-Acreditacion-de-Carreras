<?php

namespace App\backend\Controllers\Docente;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Docente;
use App\backend\Models\Evidencias as ModelsEvidencias;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Reportes as ModelsReportes;
use Dompdf\Dompdf;
use Dompdf\Options;

class Reportes implements Controller
{
    private PeriodoAcademico $periodoAcademico;
    private ModelsEvidencias $evidenciasModel;
    private ModelsReportes $reportes;
    private Docente $docente;

    public function __construct()
    {
        $this->periodoAcademico = new PeriodoAcademico;
        $this->evidenciasModel = new ModelsEvidencias;
        $this->docente = new Docente;
        $this->reportes = new ModelsReportes;
    }

    public function vista($variables = []): array
    {
        $periodoAcademicos = $this->periodoAcademico->select(true,'id','desc');
        $variables['periodos'] = $periodoAcademicos;
        return [
            'title' => 'Docentes - Generación de Reportes',
            'template' => 'docentes/reportes.html.php',
            'variables' => $variables
        ];
    }
    public function generar() {
        if(!isset($_GET['periodo'])){
        Http::redirect('/docente/reportes');
        }

        $evidencias = $this->reportes->obtenerDatosReporteDocente(
            $_SESSION['carrera'],
            $_GET['periodo'],
            $_SESSION['ci']
        );
        $docente = $this->docente->selectFromColumn('id',$_SESSION['ci'])->first();
        $this->mostrarReporte($evidencias,$docente);
    }

    private function mostrarReporte($datos,$docente){
        $html = file_get_contents('./src/backend/Views/templates/layout_reporte.html');
        $html = preg_replace('/%content-tbody%/','',$html);
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $pdf = new Dompdf($options);
        $pdf->setPaper('A4','landscape');
        $pdf->loadHtml($html);
        $pdf->render();
        header('Content-Type: application/pdf');
        echo $pdf->output(['compress'=>1]);
    }
} 
