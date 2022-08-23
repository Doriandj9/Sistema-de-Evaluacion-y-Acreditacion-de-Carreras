<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Administrador\Coordinador;
use App\backend\Controllers\Administrador\Inicio;
use App\backend\Controllers\Administrador\PeriodoAcademico;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasAdministrador implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        $periodoAcademico = new PeriodoAcademico;
        $coordinador = new Coordinador;
        return [
            'admin' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
                ],
            'admin/inicio' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
                ],
            'admin/agregar/ciclo/academico' => [
                'GET' => [
                    'controller' => $periodoAcademico,
                    'action' => 'vista'
                ],
                'POST' => [
                    'controller' => $periodoAcademico,
                    'action' => 'agregarPeriodoAcademico'
                ]
            ],
            'admin/agregar/coordinador' => [
                'GET' => [
                    'controller' => $coordinador,
                    'action' => 'vista'
                ],
                'POST' => [
                    'controller' => $coordinador,
                    'action' => 'agregarCoordinadorACarrera'
                ],
                ],
        ];
    }

    public function getTemplate(): string
    {
        return 'layout_administrador.html.php';
    }

    public function getRestrict(): array
    {
        return [
            'login' => true,
            'permisos' => Docente::ADMIN
        ];
    }
}
