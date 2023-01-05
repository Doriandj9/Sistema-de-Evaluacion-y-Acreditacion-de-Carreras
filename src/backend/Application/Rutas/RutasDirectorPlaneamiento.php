<?php

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Director_Planeamiento\BaseIndicadores;
use App\backend\Controllers\Director_Planeamiento\Evaluadores;
use App\backend\Controllers\Director_Planeamiento\Inicio;
use App\backend\Controllers\Director_Planeamiento\Reportes;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasDirectorPlaneamiento implements Route
{
    public function getRoutes(): array
    {
        $inicio = new Inicio;
        $baseIndicadores = new BaseIndicadores;
        $emparejamiento = new Evaluadores;
        $reportes = new Reportes;
        return [
            'director-planeamiento' => [
                'GET' => [
                    'controller' => $inicio,
                    'action' => 'vista'
                ]
                ],
            'director-planeamiento/base-indicadores' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'vista'
                ]
                ],
            'director-planeamiento/obtener/criterios' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'listarCriterios'
                ]
                ],
            'director-planeamiento/editar/criterios' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'editarCriterios'
                ]
                ],
            'director-planeamiento/insertar/criterios' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'insertarCriterios'
                ]
                ],
            'director-planeamiento/obtener/estandares' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'listarEstandares'
                ]
                ],
            'director-planeamiento/editar/estandares' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'editarEstandares'
                ]
                ],
            'director-planeamiento/insertar/estandares' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'insertarEstandares'
                ]
                ],
            'director-planeamiento/obtener/elementos-fundamentales' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'listarElementosFundamentales'
                ]
                ],
            'director-planeamiento/editar/elementos-fundamentales' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'editarElementosFundamentales'
                ]
                ],
            'director-planeamiento/insertar/elementos-fundamentales' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'insertarElementosFundamentales'
                ]
                ],
            'director-planeamiento/editar/componentes-elementos-fundamentales' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'editarComponentes'
                ]
                ],
            'director-planeamiento/obtener/componentes-elementos-fundamentales' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'listarComponentes'
                ]
                ],
            'director-planeamiento/insertar/componentes-elementos-fundamentales' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'insertarComponentes'
                ]
                ],
            'director-planeamiento/obtener/evidencias' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'listarEvidencias'
                ]
                ],
            'director-planeamiento/editar/evidencias' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'editarEvidencias'
                ]
                ],
            'director-planeamiento/obtener/componentes-elementos-fundamentales-evidencias' => [
                'GET' => [
                    'controller' => $baseIndicadores,
                    'action' => 'obtenerDatosEvidencias'
                ]
                ],
            'director-planeamiento/insertar/evidencias' => [
                'POST' => [
                    'controller' => $baseIndicadores,
                    'action' => 'insertarEvidencias'
                ]
                ],
            'director-planeamiento/emparejamiento-evaluadores' => [
                'GET' => [
                    'controller' => $emparejamiento,
                    'action' => 'vista'
                ]
                ],
            'director-planeamiento/obtener/evaluadores' => [
                'GET' => [
                    'controller' => $emparejamiento,
                    'action' => 'listarEvaluadores'
                ]
                ],
            'director-planeamiento/registro/evaluadores' => [
                'POST' => [
                    'controller' => $emparejamiento,
                    'action' => 'registro'
                ]
                ],
            'director-planeamiento/reportes' => [
                'GET' => [
                    'controller' => $reportes,
                    'action' => 'vista'
                ]
                ],
            'director-planeamiento/obtener/reporte' => [
                'GET' => [
                    'controller' => $reportes,
                    'action' => 'generar'
                ]
                ],
        ];
    }
    public function getTemplate(): string
    {
        return 'layout_director_planeamiento.html.php';
    }
    public function getRestrict(): array
    {
        return [
            'login' => true,
            'permisos' => Docente::DIRECTOR_PLANEAMIENTO
        ];
    }
}
