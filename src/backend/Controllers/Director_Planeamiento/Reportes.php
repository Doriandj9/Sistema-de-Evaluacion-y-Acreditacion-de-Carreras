<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Reportes as ModelsReportes;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\backend\Application\Utilidades\Http;


class Reportes implements Controller
{
    private PeriodoAcademico $periodos;
    private Carreras $carreras;
    private ModelsReportes $reportes;
    public function __construct()
    {
        $this->periodos = new PeriodoAcademico;
        $this->carreras = new Carreras;
        $this->reportes = new ModelsReportes;
    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodos->select(true,'id','desc');
        $carreras = $this->carreras->select(true,'id');
        $variables['periodos'] = $periodos;
        $variables['carreras'] = $carreras;
        return [
            'title' => 'Reportes del Director de Planemiento | SEAC',
            'template' => 'director_planeamiento/reportes.html.php',
            'variables'=> $variables
        ];    
    }

    public function generar() {
        if(!isset($_GET['periodo']) || !isset($_GET['carrera'])){
        Http::redirect('/director-planeamiento/reportes');
        }
        $evidencias = $this->reportes->obtenerDatosReporteEvaluacionCarrera(
            $_GET['carrera'],
            $_GET['periodo'],
        );
        if($evidencias->count() >= 1){
            $this->mostrarReporte($evidencias);
        }else {
            echo 'No hay datos evaluados.';
            die;
        }
    }

    private function mostrarReporte($datos){
        $html = file_get_contents('./src/backend/Views/templates/layout_reporte_evaluador.html');
        $body = '';
        $totalDatos = count($datos);
        $suma = 0;
        foreach($datos  as $dato) {
            $body .= '<tr>
                <td>'. preg_split('/ /', $dato->nombre_docente)[0].
                 ' ' . preg_split('/ /',$dato->apellido_docente)[0] .'</td>
                <td>'. $dato->nombre_evidencia .'</td>
                <td>'. $dato->observacion .'</td>
                <td>'. $dato->calificacion .'</td>'
                ;
            $body .= '</tr>';
            $num = floatval(trim($dato->calificacion));
            $suma += $num;
        }
        $total = round($suma / $totalDatos,2) * 10;
        $body .='<tr>
        <td style="text-align: end;" colspan="3"><strong>TOTAL</strong></td>
        <td>'. $total . '/10' .'</td>
        </tr>';
        $carrera = $this->carreras->selectFromColumn('id',$_GET['carrera'])->first();
        $html = preg_replace('/%content-tbody%/',$body,$html);
        $html = preg_replace('/%carrera%/',strtoupper($carrera->nombre),$html);
        $html = preg_replace('/%title%/','Reporte de fuente de informacion evaluadas',$html);

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $pdf = new Dompdf($options);
        $pdf->setPaper('A4','landscape');
        $pdf->loadHtml($html);
        $pdf->render();
        header('Content-Type: application/pdf');
        // $pdf->stream('reporteComplet.pdf',['compress' => 1]);
        echo $pdf->output(['compress'=>1]);
    }
}