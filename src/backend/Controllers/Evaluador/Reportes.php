<?php

namespace App\backend\Controllers\Evaluador;

use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Reportes as ModelsReportes;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\backend\Application\Utilidades\Http;
use App\backend\Models\Carreras;

class Reportes implements Controller
{
    private PeriodoAcademico $periodo;
    private ModelsReportes $reportes;
    private Carreras $carrera;

    public function __construct()
    {
        $this->periodo = new PeriodoAcademico;
        $this->reportes = new ModelsReportes;
        $this->carrera = new Carreras;
    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodo->select(true,'id','desc');
        $variables['periodos'] = $periodos;
        return [
            'title' => 'Reportes | Evaluadores',
            'template' => 'evaluadores/reportes.html.php',
            'variables' => $variables
        ];
    }

    public function generar() {
        if(!isset($_GET['periodo'])){
        Http::redirect('/evaluador/reportes');
        }

        $evidencias = $this->reportes->obtenerDatosReporteEvaluador(
            $_SESSION['ci'],
            $_SESSION['carrera'],
            $_GET['periodo'],
        );
        $this->mostrarReporte($evidencias);
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
        if($totalDatos === 0){
            Http::redirect('/');
        }
        $total = round($suma / $totalDatos,2) * 10;
        $body .='<tr>
        <td style="text-align: end;" colspan="3"><strong>TOTAL</strong></td>
        <td>'. $total . '/10' .'</td>
        </tr>';
        $carrera = $this->carrera->selectFromColumn('id',$_SESSION['carrera'])->first();
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