<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico as ModelsPeriodoAcademico;

class PeriodoAcademico implements Controller
{
    private $periodoAcademico;
    public function __construct()
    {
        $this->periodoAcademico = new ModelsPeriodoAcademico;
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
                'result' => 1,
                'error' => ''
            ];
            Http::responseJson(json_encode($respuesta));
        } catch (\PDOException $e) {
            $respuesta = [
                'result' => 0,
                'error' => $e->getMessage()
            ];
            Http::responseJson(json_encode($respuesta));
        }
    }
}
