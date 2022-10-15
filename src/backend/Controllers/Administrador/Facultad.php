<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Facultad as ModelsFacultad;

class Facultad implements Controller
{
    private ModelsFacultad $modeloFacultad;

    public function __construct()
    {
        $this->modeloFacultad = new ModelsFacultad;
    }
    public function vista($variables = []): array
    {
        return [
            'title' => 'Administrar Facultades de la Universidad Estatal de Bolívar',
            'template' => 'administrador/agregar_facultades.html.php'
        ];
    }

    public function insertarFacultad() {
        $data_ingreso_facultad = [
            'id' => trim($_POST['id']),
            'nombre' => trim($_POST['nombre'])
        ];

        try {
            $result = $this->modeloFacultad->insert($data_ingreso_facultad);
            if($result){
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se inserto correctamente la facultad'
                    ]
                    ));
            }else {
                throw new \PDOException('Error: Ocurrio un problema al intentar ingresar la facultad');
            }
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                [
                    'ident'  => 0,
                    'mensaje' => $e->getMessage()
                ]
            ));
        }
    }

    public function editarFacultad() {
        $data_editar_facultad = [
            'id' => trim($_POST['id_editado']),
            'nombre' => trim($_POST['nombre'])
        ];

        try {
            $result = $this->modeloFacultad->updateValues(trim($_POST['id']),$data_editar_facultad);
            if($result) {
                Http::responseJson(json_encode(
                    [
                        'ident' => 1,
                        'mensaje' => 'Se actualizo correctamente los datos de la Facultad'
                    ]
                    ));
            }else {
                throw new \PDOException('Error: Ocurio algo inesperado al intentar actualizar los datos');
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
}