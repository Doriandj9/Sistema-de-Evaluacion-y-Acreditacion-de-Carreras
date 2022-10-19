<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Administrador\Carreras;
use App\backend\Controllers\Administrador\Coordinador;
use App\backend\Controllers\Administrador\Facultad;
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
        $facultad = new Facultad;
        $carreras = new Carreras;
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
            'admin/editar/ciclo/academico' => [
                'POST' => [
                    'controller' => $periodoAcademico,
                    'action' => 'editarPeriodoAcademico'
                ]
            ],
            'admin/agregar/facultad' => [
                'GET' => [
                    'controller' => $facultad,
                    'action' => 'vista'
                ],
                'POST' => [
                    'controller' => $facultad,
                    'action' => 'insertarFacultad'
                ]
            ],
            'admin/editar/facultad' => [
                'POST' => [
                    'controller' => $facultad,
                    'action' => 'editarFacultad'
                ]
            ],
            'admin/administrar/carreras' => [
                'GET' => [
                    'controller' => $carreras,
                    'action' => 'vista'
                ]
            ],
            'admin/insertar/carreras' => [
                'POST' => [
                    'controller' => $carreras,
                    'action' => 'insertarCarrera'
                ]
            ],
            'admin/editar/carreras' => [
                'POST' => [
                    'controller' => $carreras,
                    'action' => 'editarCarrera'
                ]
            ],
            'admin/carreras/periodo-academico/habilitadas' => [
                'GET' => [
                    'controller' => $carreras,
                    'action' => 'obtenerCarrerasHabilitadas'
                ],
                'POST' => [
                    'controller' => $periodoAcademico,
                    'action' => 'guardarCarrerasHabilitadas'
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
