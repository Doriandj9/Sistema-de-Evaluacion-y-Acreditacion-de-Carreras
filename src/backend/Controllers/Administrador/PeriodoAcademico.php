<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\CarrerasEvidencias;
use App\backend\Models\CarrerasPeriodoAcademico;
use App\backend\Models\Evidencias;
use App\backend\Models\PeriodoAcademico as ModelsPeriodoAcademico;


class PeriodoAcademico implements Controller
{
    private $periodoAcademico;
    private CarrerasPeriodoAcademico $carrerasPeriodoAcademico;
    private Evidencias $evidencias;
    private CarrerasEvidencias $carrerasEvidencias;
    private Carreras $carreras;
    public function __construct()
    {
        $this->periodoAcademico = new ModelsPeriodoAcademico;
        $this->carrerasPeriodoAcademico = new CarrerasPeriodoAcademico;
        $this->evidencias = new Evidencias;
        $this->carreras = new Carreras;
        $this->carrerasEvidencias = new CarrerasEvidencias;
    }
    public function vista($variables = []): array
    {
        return [
            'title' => 'Agregar un Periodo Academico',
            'template' => 'administrador/agregar_periodo_academico.html.php'
        ];
    }


    public function agregarPeriodoAcademico(): void
    {
        $datos = [
            'id' => $_POST['periodo'],
            'fecha_inicial' => $_POST['fecha_inicial'],
            'fecha_final' => $_POST['fecha_final']
        ];

        try {
            $this->periodoAcademico->insert($datos);
            $respuesta = [
                'ident' => 1,
                'mensaje' => 'Se inserto correctamente'
            ];
            Http::responseJson(json_encode($respuesta));
        } catch (\PDOException $e) {
            $respuesta = [
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ];
            Http::responseJson(json_encode($respuesta));
        }
    }

    public function editarPeriodoAcademico()
    {
        $dataActualizar = [
            'fecha_inicial' => trim($_POST['fecha_inicial']),
            'fecha_final' => trim($_POST['fecha_final']),
            'id' => trim($_POST['id_editado'])
        ];
        try {
            if ($this->periodoAcademico->updateValues(trim($_POST['id']), $dataActualizar)) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se actualizo correctamente'
                    ]
                ));
            } else {
                throw new \PDOException('No se pudo actualizar');
            }
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $e->getMessage()
                ]
            ));
        }
    }

    public function guardarCarrerasHabilitadas()
    {
        $periodo = $_POST['periodo'];
        $id_carreras = $_POST['ids_carreras'];

        foreach ($id_carreras as $carrera) {
            $data_carreras_periodo_academico = [
                'id_carreras' => $carrera,
                'id_periodo_academico' => $periodo
            ];
            try {
                $result = $this->carrerasPeriodoAcademico->insert($data_carreras_periodo_academico);
                if (!$result) {
                    throw new \PDOException('Error: Ocurrio un problema inesperado intento mas tarde.');
                }
            } catch (\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                ));
            }
        }

        $this->habilitarEvidenciasACarreras($id_carreras,$periodo);
        Http::responseJson(json_encode(
            [
                'ident' => 1,
                'mensaje' => 'Se habilito correctamente las carreras'
            ]
        ));
    }

    private function habilitarEvidenciasACarreras(array $carreras, string $id_periodo) {
        $evidencias  = $this->evidencias->select();
        $periodoVigente = $this->periodoAcademico->selectFromColumn('id',$id_periodo)->first();
        $carrerasEvidenciasData = [];
        foreach($carreras as $carrera) {
            $facultad = $this->carreras->selectFromColumn('id',$carrera,['id_facultad'])->first();
            foreach($evidencias as $evidencia){
                $data_carreras_evidencias = [
                    'id_periodo_academico' => $id_periodo,
                    'id_evidencias' => $evidencia->id,
                    'id_carrera' => $carrera,
                    'cod_evidencia' => $facultad->id_facultad . '-' .$carrera . ' ' .  $evidencia->id,
                    'fecha_inicial' => $periodoVigente->fecha_inicial,
                    'fecha_final' => $periodoVigente->fecha_final
                ];
                array_push($carrerasEvidenciasData,$data_carreras_evidencias);
            }
            
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
