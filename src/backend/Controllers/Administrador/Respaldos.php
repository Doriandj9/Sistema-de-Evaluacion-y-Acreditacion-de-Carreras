<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\CarrerasEvidencias;
use App\backend\Models\CarrerasPeriodoAcademico;
use App\backend\Models\ComponenteElementoFundamental;
use App\backend\Models\Criterios;
use App\backend\Models\Docente;
use App\backend\Models\DocentesCarreras;
use App\backend\Models\ElementoFundamental;
use App\backend\Models\Estandar;
use App\backend\Models\Evaluacion;
use App\backend\Models\EvaluacionDocentes;
use App\backend\Models\EvidenciaComponenteElementoFundamental;
use App\backend\Models\Evidencias;
use App\backend\Models\EvidenciasEvaluacion;
use App\backend\Models\Facultad;
use App\backend\Models\Notificaciones;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\Responsabilidades;
use App\backend\Models\Titulos;
use App\backend\Models\Usuarios;
use App\backend\Models\UsuariosDocente;
use App\backend\Models\UsuariosResponsabilidad;

class Respaldos implements Controller
{
    private Carreras $carreras;
    private CarrerasEvidencias $carrerasEvidencias;
    private CarrerasPeriodoAcademico $carrerasPeriodoAcademico;
    private ComponenteElementoFundamental $componenteElementoFundamental;
    private Criterios $criterios;
    private Docente $docentes;
    private DocentesCarreras $docentesCarreras;
    private ElementoFundamental $elementoFundamental;
    private Estandar $estandares;
    private Evaluacion $evaluacion;
    private EvaluacionDocentes $evaluacionDocentes;
    private EvidenciaComponenteElementoFundamental $evidenciasComponetesElementosFundamentales;
    private Evidencias $evidencias;
    private EvidenciasEvaluacion $evidenciasEvaluacion;
    private Facultad $facultad;
    private Notificaciones $notificaciones;
    private PeriodoAcademico $periodoAcademico;
    private Responsabilidades $responsabilidades;
    private Titulos $titulos;
    private Usuarios $usuarios;
    private UsuariosDocente $usuariosDocentes;
    private UsuariosResponsabilidad $usuariosResponsabilidad;

    public function __construct()
    {
        $this->carreras = new Carreras;
        $this->carrerasEvidencias = new CarrerasEvidencias;
        $this->carrerasPeriodoAcademico = new CarrerasPeriodoAcademico;
        $this->componenteElementoFundamental = new ComponenteElementoFundamental;
        $this->criterios = new Criterios;
        $this->docentes = new Docente;
        $this->docentesCarreras = new DocentesCarreras;
        $this->elementoFundamental = new ElementoFundamental;
        $this->estandares = new Estandar;
        $this->evaluacion = new Evaluacion;
        $this->evaluacionDocentes = new EvaluacionDocentes;
        $this->evidenciasComponetesElementosFundamentales = new EvidenciaComponenteElementoFundamental;
        $this->evidencias = new Evidencias;
        $this->evidenciasEvaluacion = new EvidenciasEvaluacion;
        $this->facultad = new Facultad;
        $this->notificaciones = new Notificaciones;
        $this->periodoAcademico = new PeriodoAcademico;
        $this->responsabilidades = new Responsabilidades;
        $this->titulos = new Titulos;
        $this->usuarios = new Usuarios;
        $this->usuariosDocentes = new UsuariosDocente;
        $this->usuariosResponsabilidad = new UsuariosResponsabilidad;
    }
    public function vista($variables = []): array
    {
        return [
            'title' => 'Respaldos de la base de datos',
            'template' => 'administrador/respaldos.html.php'
        ];
    }

    public function generar(){
        // plantilla de sql
        $plantillaSql = file_get_contents(__DIR__ . '/../../datos/sistema/plantilla.sql');
        $carreras = $this->carreras->select();
        $carrerasEvidencias = $this->carrerasEvidencias->select();
        $carrerasPeriodoAcademico = $this->carrerasPeriodoAcademico->select();
        $componenteElementoFundamental = $this->componenteElementoFundamental->select();
        $criterios = $this->criterios->select();
        $docentes = $this->docentes->select();
        $docentesCarreras = $this->docentesCarreras->select();
        $elementoFundamental = $this->elementoFundamental->select();
        $estandares = $this->estandares->select();
        $evaluacion = $this->evaluacion->select();
        $evaluacionDocentes = $this->evaluacionDocentes->select();
        $evidenciasComponetesElementosFundamentales = $this->evidenciasComponetesElementosFundamentales->select();
        $evidencias = $this->evidencias->select();
        $evidenciasEvaluacion = $this->evidenciasEvaluacion->select();
        $facultad = $this->facultad->select();
        $notificaciones = $this->notificaciones->select();
        $periodoAcademico = $this->periodoAcademico->select();
        $responsabilidades = $this->responsabilidades->select();
        $titulos = $this->titulos->select();
        $usuarios = $this->usuarios->select();
        $usuariosDocentes = $this->usuariosDocentes->select();
        $usuariosResponsabilidad = $this->usuariosResponsabilidad->select();

        // remplazamos los datos en la plantilla sql
        $datosCarreras = '';
        foreach($carreras as $carrera) {
            foreach($carrera as $dato) {
                $datosCarreras .= trim($dato) . '   ';
            }
            $datosCarreras = rtrim($datosCarreras);
            $datosCarreras .= "\n";
        }
        $datosCarreras = trim($datosCarreras);
        $plantillaSql = preg_replace('/%carreras%/',$datosCarreras,$plantillaSql);


        $datosCarrerasEvidencias = '';
        foreach($carrerasEvidencias as $carrera) {
            foreach($carrera as $dato) {
                $datosCarrerasEvidencias .= trim($dato) . '   ';
            }
            $datosCarrerasEvidencias = rtrim($datosCarrerasEvidencias);
            $datosCarrerasEvidencias .= "\n";
        }
        $datosCarrerasEvidencias = trim($datosCarrerasEvidencias);
        $plantillaSql = preg_replace('/%'. CarrerasEvidencias::TABLE .'%/',$datosCarrerasEvidencias,$plantillaSql);
        
        $datosCarrerasPeriodoAcademico = '';
        foreach($carrerasPeriodoAcademico as $carrera) {
            foreach($carrera as $dato) {
                $datosCarrerasPeriodoAcademico .= trim($dato) . '   ';
            }
            $datosCarrerasPeriodoAcademico = rtrim($datosCarrerasPeriodoAcademico);
            $datosCarrerasPeriodoAcademico .= "\n";
        }
        $datosCarrerasPeriodoAcademico = trim($datosCarrerasPeriodoAcademico);
        $plantillaSql = preg_replace('/%'. CarrerasPeriodoAcademico::TABLE .'%/',$datosCarrerasPeriodoAcademico,$plantillaSql);
        

        $datosComponentesElementosFundamental = '';
        foreach($componenteElementoFundamental as $componentes) {
            foreach($componentes as $dato) {
                $datosComponentesElementosFundamental .= trim($dato) . '   ';
            }
            $datosComponentesElementosFundamental = rtrim($datosComponentesElementosFundamental);
            $datosComponentesElementosFundamental .= "\n";
        }
        $datosComponentesElementosFundamental = trim($datosComponentesElementosFundamental);
        $plantillaSql = preg_replace('/%'. ComponenteElementoFundamental::TABLE .'%/',$datosComponentesElementosFundamental,$plantillaSql);
        

        $datosCriterios = '';
        foreach($criterios as $datos) {
            foreach($datos as $dato) {
                $datosCriterios .= trim($dato) . '   ';
            }
            $datosCriterios = rtrim($datosCriterios);
            $datosCriterios .= "\n";
        }
        $datosCriterios = trim($datosCriterios);
        $plantillaSql = preg_replace('/%'. Criterios::TABLE .'%/',$datosCriterios,$plantillaSql);


        $datosDocentes = '';
        foreach($docentes as $datos) {
            foreach($datos as $dato) {
                $datosDocentes .= trim($dato) . '   ';
            }
            $datosDocentes = rtrim($datosDocentes);
            $datosDocentes .= "\n";
        }
        $datosDocentes = trim($datosDocentes);
        $plantillaSql = preg_replace('/%'. Docente::TABLE .'%/',$datosDocentes,$plantillaSql);
        

        $datosDocentesCarreras = '';
        foreach($docentesCarreras as $datos) {
            foreach($datos as $dato) {
                $datosDocentesCarreras .= trim($dato) . '   ';
            }
            $datosDocentesCarreras = rtrim($datosDocentesCarreras);
            $datosDocentesCarreras .= "\n";
        }
        $datosDocentesCarreras = trim($datosDocentesCarreras);
        $plantillaSql = preg_replace('/%'. DocentesCarreras::TABLE .'%/',$datosDocentesCarreras,$plantillaSql);

        $datosElementosFundamental = '';
        foreach($elementoFundamental as $datos) {
            foreach($datos as $dato) {
                $datosElementosFundamental .= trim($dato) . '   ';
            }
            $datosElementosFundamental = rtrim($datosElementosFundamental);
            $datosElementosFundamental .= "\n";
        }
        $datosElementosFundamental = trim($datosElementosFundamental);
        $plantillaSql = preg_replace('/%'. ElementoFundamental::TABLE .'%/',$datosElementosFundamental,$plantillaSql);



        $datosEstandares = '';
        foreach($estandares as $datos) {
            foreach($datos as $dato) {
                $datosEstandares .= trim($dato) . '   ';
            }
            $datosEstandares = rtrim($datosEstandares);
            $datosEstandares .= "\n";
        }
        $datosEstandares = trim($datosEstandares);
        $plantillaSql = preg_replace('/%'. Estandar::TABLE .'%/',$datosEstandares,$plantillaSql);


        $datosEvaluacion = '';
        foreach($evaluacion as $datos) {
            foreach($datos as $dato) {
                $datosEvaluacion .= trim($dato) . '   ';
            }
            $datosEvaluacion = rtrim($datosEvaluacion);
            $datosEvaluacion .= "\n";
        }
        $datosEvaluacion = trim($datosEvaluacion);
        $plantillaSql = preg_replace('/%'. Evaluacion::TABLE .'%/',$datosEvaluacion,$plantillaSql);



        $datosEvaluacionDocentes = '';
        foreach($evaluacionDocentes as $datos) {
            foreach($datos as $dato) {
                $datosEvaluacionDocentes .= trim($dato) . '   ';
            }
            $datosEvaluacionDocentes = rtrim($datosEvaluacionDocentes);
            $datosEvaluacionDocentes .= "\n";
        }
        $datosEvaluacionDocentes = trim($datosEvaluacionDocentes);
        $plantillaSql = preg_replace('/%'. EvaluacionDocentes::TABLE .'%/',$datosEvaluacionDocentes,$plantillaSql);



        $datosEvidenciasComponentes = '';
        foreach($evidenciasComponetesElementosFundamentales as $datos) {
            foreach($datos as $dato) {
                $datosEvidenciasComponentes .= trim($dato) . '   ';
            }
            $datosEvidenciasComponentes = rtrim($datosEvidenciasComponentes);
            $datosEvidenciasComponentes .= "\n";
        }
        $datosEvidenciasComponentes = trim($datosEvidenciasComponentes);
        $plantillaSql = preg_replace('/%'. EvidenciaComponenteElementoFundamental::TABLE .'%/',$datosEvidenciasComponentes,$plantillaSql);


        $datosEvidencias = '';
        foreach($evidencias as $datos) {
            foreach($datos as $dato) {
                $datosEvidencias .= trim($datosEvidencias) . '   ';
            }
            $datosEvidencias = rtrim($datosEvidencias);
            $datosEvidencias .= "\n";
        }
        $datosEvidencias = trim($datosEvidencias);
        $plantillaSql = preg_replace('/%'. Evidencias::TABLE .'%/',$datosEvidencias,$plantillaSql);





        $datosEvidenciasEvaluacion = '';
        foreach($evidenciasEvaluacion as $datos) {
            foreach($datos as $dato) {
                $datosEvidenciasEvaluacion .= trim($dato) . '   ';
            }
            $datosEvidenciasEvaluacion = rtrim($datosEvidenciasEvaluacion);
            $datosEvidenciasEvaluacion .= "\n";
        }
        $datosEvidenciasEvaluacion = trim($datosEvidenciasEvaluacion);
        $plantillaSql = preg_replace('/%'. EvidenciasEvaluacion::TABLE .'%/',$datosEvidenciasEvaluacion,$plantillaSql);

        
        $datosFacultad = '';
        foreach($facultad as $datos) {
            foreach($datos as $dato) {
                $datosFacultad .= trim($dato) . '   ';
            }
            $datosFacultad = rtrim($datosFacultad);
            $datosFacultad .= "\n";
        }
        $datosFacultad = trim($datosFacultad);
        $plantillaSql = preg_replace('/%'. Facultad::TABLE .'%/',$datosFacultad,$plantillaSql);


        $datosNotificaciones = '';
        foreach($notificaciones as $datos) {
            foreach($datos as $dato) {
                $datosNotificaciones .= trim($dato) . '   ';
            }
            $datosNotificaciones = rtrim($datosNotificaciones);
            $datosNotificaciones .= "\n";
        }
        $datosNotificaciones = trim($datosNotificaciones);
        $plantillaSql = preg_replace('/%'. Notificaciones::TABLE .'%/',$datosNotificaciones,$plantillaSql);


        $datosPeriodoAcademico = '';
        foreach($periodoAcademico as $datos) {
            foreach($datos as $dato) {
                $datosPeriodoAcademico .= trim($dato) . '   ';
            }
            $datosPeriodoAcademico = rtrim($datosPeriodoAcademico);
            $datosPeriodoAcademico .= "\n";
        }
        $datosPeriodoAcademico = trim($datosPeriodoAcademico);
        $plantillaSql = preg_replace('/%'. PeriodoAcademico::TABLE .'%/',$datosPeriodoAcademico,$plantillaSql);


        $datosResponsabilidad = '';
        foreach($responsabilidades as $datos) {
            foreach($datos as $dato) {
                $datosResponsabilidad .= trim($dato) . '   ';
            }
            $datosResponsabilidad = rtrim($datosResponsabilidad);
            $datosResponsabilidad .= "\n";
        }
        $datosResponsabilidad = trim($datosResponsabilidad);
        $plantillaSql = preg_replace('/%'. Responsabilidades::TABLE .'%/',$datosResponsabilidad,$plantillaSql);


        $datosTitulos = '';
        foreach($titulos as $datos) {
            foreach($datos as $dato) {
                $datosTitulos .= trim($dato) . '   ';
            }
            $datosTitulos = rtrim($datosTitulos);
            $datosTitulos .= "\n";
        }
        $datosTitulos = trim($datosTitulos);
        $plantillaSql = preg_replace('/%'. Titulos::TABLE .'%/',$datosTitulos,$plantillaSql);


        $datosUsuarios = '';
        foreach($usuarios as $datos) {
            foreach($datos as $dato) {
                $datosUsuarios .= trim($dato) . '   ';
            }
            $datosUsuarios = rtrim($datosUsuarios);
            $datosUsuarios .= "\n";
        }
        $datosUsuarios = trim($datosUsuarios);
        $plantillaSql = preg_replace('/%'. Usuarios::TABLE .'%/',$datosUsuarios,$plantillaSql);


        $datosUsuariosDcoentes = '';
        foreach($usuariosDocentes as $datos) {
            foreach($datos as $dato) {
                $datosUsuariosDcoentes .= trim($dato) . '   ';
            }
            $datosUsuariosDcoentes = rtrim($datosUsuariosDcoentes);
            $datosUsuariosDcoentes .= "\n";
        }
        $datosUsuariosDcoentes = trim($datosUsuariosDcoentes);
        $plantillaSql = preg_replace('/%'. UsuariosDocente::TABLE .'%/',$datosUsuariosDcoentes,$plantillaSql);


        $datosUsuariosResponsabilidad = '';
        foreach($usuariosResponsabilidad as $datos) {
            foreach($datos as $dato) {
                $datosUsuariosResponsabilidad .= trim($dato) . '   ';
            }
            $datosUsuariosResponsabilidad = rtrim($datosUsuariosResponsabilidad);
            $datosUsuariosResponsabilidad .= "\n";
        }
        $datosUsuariosResponsabilidad = trim($datosUsuariosResponsabilidad);
        $plantillaSql = preg_replace('/%'. UsuariosResponsabilidad::TABLE .'%/',$datosUsuariosResponsabilidad,$plantillaSql);
        file_put_contents('./public/backup.sql',$plantillaSql);
        header('location: /public/backup.sql');
        die;
    }
}