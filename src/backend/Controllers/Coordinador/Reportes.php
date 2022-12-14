<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Reportes as ModelsReportes;
use App\backend\Models\UsuariosResponsabilidad;
use Dompdf\Dompdf;
use Dompdf\Options;

class Reportes implements Controller
{
    private PeriodoAcademico $periodos;
    private ModelsReportes $reportes;
    private Carreras $carrera;
    private Docente $docentes;
    public function __construct()
    {
        $this->periodos = new PeriodoAcademico;
        $this->reportes = new ModelsReportes;
        $this->carrera = new Carreras;
        $this->docentes = new Docente;
    }
    public function vista($variables = []): array
    {
        $periodos = $this->periodos->select(true,'id','desc');
        $variables['periodos'] = $periodos;
        return [
            'title' => 'Reportes del Coordinador',
            'template' => 'coordinadores/reportes.html.php',
            'variables' => $variables
        ];
    }

    public function generar() {
        $opcion = trim($_GET['tipo']);
        $periodo = trim($_GET['periodo']);
        $opcionesReportes = [
            '1' => function ($periodo){$this->reporteEvidenciasAlmacenadas($periodo);},
            '2' => function ($periodo){$this->reporteDocentesEncargado($periodo);},
            '3' => function ($periodo){$this->reporteAutoevaluacion($periodo);}
        ];
        if(!isset($opcionesReportes[$opcion])){
           Http::redirect('/');
        }
        $func = $opcionesReportes[$opcion];
        $func($periodo);
        die;
    }

    private function reporteEvidenciasAlmacenadas($periodo){
       $evidencias = $this->reportes->obtenerDatosReporteCoordinadorEvidenciasAlmacenadas(
        trim($_SESSION['carrera']),
        $periodo,
        trim($_SESSION['ci'])
       );
       $this->mostrarReporte1($evidencias);
    }

    private function reporteDocentesEncargado($periodo){
        $evidencias = $this->reportes->obtenerDatosReporteCoordinadorDocentesEvidencias(
            trim($_SESSION['carrera']),
            $periodo,
            trim($_SESSION['ci'])
        );
        
       $this->mostrarReporte2($evidencias,$periodo);
    }

    private function reporteAutoevaluacion($periodo) {
        echo '3';
    }

    private function mostrarReporte1($datos){
        $html = file_get_contents('./src/backend/Views/templates/loyout_reporte_coordinador_evidencias_almacenadas.html');
        $body = '';
        foreach($datos  as $dato) {
            $verificado = ($dato->verificada != true) ? 'No verificada' : 'Verificada';
            $body .= '<tr>
                <td>'. $dato->nombre_evidencia .'</td>
                <td>'. $dato->fecha_registro .'</td>                
                ';
                if($dato->almacenado){
                   $body .= '<td> Almacenado </td>';   
                }else {
                    $body .= '<td> No almacenado </td>';   
                }
            $body .= '<td>'. $verificado .'</td></tr>';
        }
        $carrera = $this->carrera->selectFromColumn('id',$_SESSION['carrera'])->first();
        $html = preg_replace('/%content-tbody%/',$body,$html);
        $html = preg_replace('/%carrera%/',strtoupper($carrera->nombre),$html);
        $html = preg_replace('/%title%/','Reporte de evidencias almacenadas',$html);

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
    private function mostrarReporte2($datos,$periodoCarrera){
        $html = file_get_contents('./src/backend/Views/templates/loyout_reporte_coordinador_evidencias_docentes.html');
        $body = '';
        $docentes = UsuariosResponsabilidad::whereRaw('id_carrera = ? and id_periodo_academico = ?'
        ,[$_SESSION['carrera'],$periodoCarrera]);
        foreach($datos  as $dato) {
            $verificado = ($dato->verificada != true) ? 'No verificada' : 'Verificada';
            $body .= '<tr>
                <td>'. 'Nombre del Docente' .'</td>
                <td>'. $dato->criterios .'</td>
                <td>'. $dato->indicador .'</td>
                <td>'. $dato->numero_estandar .'</td>
                <td>'. $dato->numero_elemento .'</td>
                <td>'. $dato->nombre_evidencia .'</td>
                <td>'. $dato->fecha_registro .'</td>                
                ';
                if($dato->almacenado){
                   $body .= '<td> Almacenado </td>';   
                }else {
                    $body .= '<td> No almacenado </td>';   
                }
            $body .= '<td>'. $verificado .'</td></tr>';
        }
        $carrera = $this->carrera->selectFromColumn('id',$_SESSION['carrera'])->first();
        $html = preg_replace('/%content-tbody%/',$body,$html);
        $html = preg_replace('/%carrera%/',strtoupper($carrera->nombre),$html);
        $html = preg_replace('/%title%/','Reporte de evidencias almacenadas',$html);
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