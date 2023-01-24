<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Administrador\PeriodoAcademico;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\CarrerasEvidencias;
use App\backend\Models\ComponenteElementoFundamental;
use App\backend\Models\Criterios;
use App\backend\Models\ElementoFundamental;
use App\backend\Models\Estandar;
use App\backend\Models\EvidenciaComponenteElementoFundamental;
use App\backend\Models\Evidencias;
use App\backend\Models\PeriodoAcademico as ModelsPeriodoAcademico;

class BaseIndicadores implements Controller
{
    private Criterios $criterios;
    private Estandar $estandares;
    private ElementoFundamental $elementosFundamentales;
    private ComponenteElementoFundamental $componentes;
    private Evidencias $evidencias;
    private EvidenciaComponenteElementoFundamental $evidenciasComponentes;
    private Carreras $carreras;
    private ModelsPeriodoAcademico $periodo;
    private CarrerasEvidencias $carrerasEvidencias;
    public function __construct()
    {
        $this->criterios = new Criterios;
        $this->estandares = new Estandar;
        $this->elementosFundamentales =  new ElementoFundamental;
        $this->componentes = new ComponenteElementoFundamental;
        $this->evidencias = new Evidencias;
        $this->evidenciasComponentes = new EvidenciaComponenteElementoFundamental;
        $this->carreras = new Carreras;
        $this->periodo = new ModelsPeriodoAcademico;
        $this->carrerasEvidencias = new CarrerasEvidencias;
    }

    public function vista($variables = []): array
    {
        return [
            'title' => 'Administración de Criterios | Estandares | Elementos
            Fundamentales | Componentes de Elementos Fundamentales | Fuentes de Información',
            'template' => 'director_planeamiento/base-indicadores.html.php'
        ];
    }

    public function listarCriterios() {
        try{
            $criterios = $this->criterios->select(true,'id');
            Http::responseJson(json_encode([
                'ident' => 1,
                'criterios' => $criterios
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }

    public function editarCriterios() {
        $data_criterios = [
            'id' => $_POST['id_editado'],
            'nombre' => $_POST['nombre']
        ];
        try{
            $this->criterios->updateValues(
                trim($_POST['id']),
                $data_criterios
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizaron los datos correctamente'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function insertarCriterios() {
        $data_criterios = [
            'id' => trim($_POST['id']),
            'nombre' => trim($_POST['nombre'])
        ];

        try{
            $this->criterios->insert($data_criterios);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente el criterio'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function listarEstandares() {
        try{
            $estandares = $this->estandares->obtenerConCriterios();
            Http::responseJson(json_encode([
                'ident' => 1,
                'estandares' => $estandares
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }
    public function editarEstandares() {
        $data_estandares = [
            'id' => $_POST['id_editado'],
            'nombre' => $_POST['nombre'],
            'descripcion' => trim($_POST['descripcion']),
            'tipo' => trim($_POST['tipo'])
        ];
        try{
            $this->estandares->updateValues(
                trim($_POST['id']),
                $data_estandares
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizaron los datos correctamente'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function insertarEstandares() {
        $data_estandares = [
            'id' => trim($_POST['id']),
            'nombre' => trim($_POST['nombre']),
            'descripcion' => trim($_POST['descripcion']),
            'tipo' => trim($_POST['tipo']),
            'id_criterio' => trim($_POST['criterio'])
        ];
        try{
            $this->estandares->insert($data_estandares);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente el estandar'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function listarElementosFundamentales() {
        try{
            $elementos = $this->elementosFundamentales->obtenerConEstandares();
            Http::responseJson(json_encode([
                'ident' => 1,
                'elementos' => $elementos
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }
    public function editarElementosFundamentales() {
        $data_elementos = [
            'id' => $_POST['id_editado'],
            'descripcion' => trim($_POST['descripcion']),
        ];
        try{
            $this->elementosFundamentales->updateValues(
                trim($_POST['id']),
                $data_elementos
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizaron los datos correctamente'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function insertarElementosFundamentales() {
        $data_elementos = [
            'id' => trim($_POST['id']),
            'descripcion' => trim($_POST['descripcion']),
            'id_estandar' => trim($_POST['estandar'])
        ];
        try{
            $this->elementosFundamentales->insert($data_elementos);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente el elemento fundamental.'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function listarComponentes() {
        try{
            $componentes = $this->componentes->obtenerConElementos();
            Http::responseJson(json_encode([
                'ident' => 1,
                'componentes' => $componentes
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }
    public function editarComponentes() {
        $data_componentes = [
            'id_elemento' => $_POST['id_elemento_editado'],
            'id_componente' => $_POST['id_componente_editado'],
            'descripcion' => trim($_POST['descripcion']),
        ];
        try{
            $this->componentes->updateValues(
                trim($_POST['id']),
                $data_componentes
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizaron los datos correctamente'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }
    public function insertarComponentes() {
        $data_componentes = [
            'id_componente' => trim($_POST['id_componente']),
            'id_elemento' => trim($_POST['elemento']),
            'descripcion' => trim($_POST['descripcion'])
        ];
        try{
            $this->componentes->insert($data_componentes);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente el compoenente de elemento fundamental'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function listarEvidencias() {
        try{
            $evidencias = $this->evidencias->obtenerConTodosDatos();
            Http::responseJson(json_encode([
                'ident' => 1,
                'evidencias' => $evidencias
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }

    public function editarEvidencias() {
        $data_evidencias = [
            'id' => $_POST['id_editado'],
            'nombre' => $_POST['nombre'],
        ];
        try{
            $this->evidencias->updateValues(
                trim($_POST['id']),
                $data_evidencias
            );
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se actualizaron los datos correctamente'
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    public function obtenerDatosEvidencias() {
        try{
            $datos = $this->evidencias->obtenerDatosComponentesElementos();
            Http::responseJson(json_encode([
                'ident' => 1,
                'datos' => $datos
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e
            ]));
        }
    }

    public function insertarEvidencias() {
        $componentes = $_POST['componentes'];
        $data_evidencias = [
            'id' => trim($_POST['id']),
            'nombre' => trim($_POST['nombre'])
        ];
        $errores = [];
        try{
           $this->evidencias->insert($data_evidencias);
            foreach($componentes as $id_componente) {
                $data_componentes_evidencias = [
                    'id_evidencias' => $_POST['id'],
                    'id_componente' => $id_componente
                ]; 
                try{
                    $this->evidenciasComponentes->insert($data_componentes_evidencias);
                }catch(\PDOException $e) {
                    array_push($errores,$e->getMessage());
                }
            }
            $carreras = $this->carreras->select(true,'id','asc',['id']);
            $periodo = $this->periodo->select(true,'id','asc')->last();
            $carrerasArray = [];
            foreach($carreras as $carrera) {
                array_push($carrerasArray,$carrera->id);
            }
            $this->habilitarEvidenciasACarreras($carrerasArray,$periodo->id,$_POST['id']);
            Http::responseJson(json_encode([
                'ident' => 1,
                'mensaje' => 'Se ingreso correctamente la fuente de información.',
                'errores' => $errores
            ]));
        }catch(\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]));
        }
    }

    private  function habilitarEvidenciasACarreras(array $carreras, string $id_periodo, string $id_evidencia) {
        $periodoVigente = $this->periodo->selectFromColumn('id',$id_periodo)->first();
        $carrerasEvidenciasData = [];
        foreach($carreras as $carrera) {
            $facultad = $this->carreras->selectFromColumn('id',$carrera,['id_facultad'])->first();
                $data_carreras_evidencias = [
                    'id_periodo_academico' => $id_periodo,
                    'id_evidencias' => $id_evidencia,
                    'id_carrera' => $carrera,
                    'cod_evidencia' => trim($facultad->id_facultad) . '-' .trim($carrera) . ' ' . trim($id_evidencia),
                    'fecha_inicial' => $periodoVigente->fecha_inicial,
                    'fecha_final' => $periodoVigente->fecha_final
                ];
                array_push($carrerasEvidenciasData,$data_carreras_evidencias);
            
        }
        $this->carrerasEvidencias->insertMasivo($carrerasEvidenciasData,[
            'id_periodo_academico',
            'id_evidencias',
            'id_carrera',
            'cod_evidencia',
            'fecha_inicial',
            'fecha_final'
        ]);
    }
}