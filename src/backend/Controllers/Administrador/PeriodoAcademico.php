<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\DB;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\CarrerasPeriodoAcademico;
use App\backend\Models\Docente;
use App\backend\Models\PeriodoAcademico as ModelsPeriodoAcademico;

class PeriodoAcademico implements Controller
{
    private $periodoAcademico;
    private CarrerasPeriodoAcademico $carrerasPeriodoAcademico;
    public function __construct()
    {
        $this->periodoAcademico = new ModelsPeriodoAcademico;
        $this->carrerasPeriodoAcademico = new CarrerasPeriodoAcademico;
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

    public function guardarCarrerasHabilitadas() {
        $periodo = $_POST['periodo'];
        $id_carreras = $_POST['ids_carreras'];

        foreach($id_carreras as $carrera) {
            $data_carreras_periodo_academico = [
                'id_carreras' => $carrera,
                'id_periodo_academico' => $periodo
            ];
            try {
                $result = $this->carrerasPeriodoAcademico->insert($data_carreras_periodo_academico);
                if(!$result) {
                    throw new \PDOException('Error: Ocurrio un problema inesperado intento mas tarde.');
                }
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
                break;
            }
        }

        Http::responseJson(json_encode(
            [
                'ident' => 1,
                'mensaje' => 'Se habilito correctamente las carreras'
            ]
            ));
    }
}
