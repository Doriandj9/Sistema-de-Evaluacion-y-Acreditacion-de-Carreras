<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras as ModelsCarreras;

class Carreras implements Controller
{
    private ModelsCarreras $carreras;
    public function __construct()
    {
        $this->carreras = new ModelsCarreras;
    }

    public function vista($variables = []): array
    {
        return [
            'title' => 'Administrar Carreras de la Universidad Estatal de Bolívar.',
            'template' => 'administrador/carreras.html.php'
        ];
    }

    public function insertarCarrera() {
        $data_insert_carrera = [
            'id' => strtoupper(trim($_POST['id'])),
            'nombre' => trim($_POST['nombre']),
            'numero_asig' => trim($_POST['numero_asig']),
            'total_horas_proyecto' => trim($_POST['horas_proyecto']),
            'id_facultad' => trim($_POST['facultad'])
        ];

        try{
            $result = $this->carreras->insert($data_insert_carrera);
            if($result) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se inserto correctamente la carrera'
                    ]
                    ));
            }else {
                throw new \PDOException('Error: Ocurrio un evento inesperado, intentelo mas tarde');
            }
        }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
        }
    }

    public function editarCarrera() {
        $data_edit_carrera = [
            'id' => strtoupper(trim($_POST['id_editado'])),
            'nombre' => trim($_POST['nombre']),
            'numero_asig' => intval(trim($_POST['numero_asig'])),
            'total_horas_proyecto' => intval(trim($_POST['horas_proyecto']))
        ];
        try{
            $result = $this->carreras->updateValues(trim($_POST['id']), $data_edit_carrera);
            if($result) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se Actualizo correctamente la carrera'
                    ]
                    ));
            }else {
                throw new \PDOException('Error: Ocurrio un evento inesperado, intentelo mas tarde');
            }
        }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
        }
    }

    public function obtenerCarrerasHabilitadas() {
        if(isset($_GET['periodo'])){
            try{
                $carreras = $this->carreras->obtenerHabilitacionPorPeriodoAcademico(trim($_GET['periodo']));
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'carreras' => $carreras
                    ]
                    ));
            }catch(\PDOException $e) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 0,
                        'mensaje' => $e->getMessage()
                    ]
                    ));
            }

        }else {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error: No ha enviado el parametro periodo'
                ]
                ));
        }

    }
}