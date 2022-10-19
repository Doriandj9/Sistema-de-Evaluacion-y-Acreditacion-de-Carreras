<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Datos\Carreras;
use App\backend\Controllers\Datos\Docentes;
use App\backend\Controllers\Datos\Facultad;
use App\backend\Controllers\Datos\PeriodosAcademicos;
use App\backend\Frame\Route;

class RutasDatos implements Route
{
    public function getRoutes(): array
    {
        $docentes = new Docentes;
        $periodosAcademicos = new PeriodosAcademicos;
        $carrerasController = new Carreras;
        $facultades = new Facultad;
        return [
            'datos/docentes' => [
                'GET' => [
                    'controller' => $docentes,
                    'action' => 'vista'
                ]
                ],
            'datos/periodos-academicos' => [
                'GET' => [
                    'controller' => $periodosAcademicos,
                    'action' => 'vista'
                ]
                ],
            'datos/carreras/usuario' => [
                'POST' => [
                    'controller' => $carrerasController,
                    'action' => 'vista'
                ]
                ],
            'datos/cambio/clave' => [
                    'POST' => [
                        'controller' => $docentes,
                        'action' => 'cambioClave'
                    ],
                ],
            'datos/comprobacion/clave' => [
                    'POST' => [
                        'controller' => $docentes,
                        'action' => 'comprobacionClave'
                    ],
                ],
            'datos/facultades' => [
                    'GET' => [
                        'controller' => $facultades,
                        'action' => 'vista'
                    ],
                ],
            'datos/carreras' => [
                    'GET' => [
                        'controller' => $carrerasController,
                        'action' => 'obtenerTodasCarreras'
                    ],
                ],
            'datos/opciones' => [
                'POST' => [
                    'controller' => $carrerasController,
                    'action' => 'guardarOpciones'
                ]
            ]
        ];
    }

    public function getTemplate(): string
    {
        return 'layout_datos.html.php';
    }

    public function getRestrict(): array
    {
        return [
           'login' => true,
            'token_autorizacion' => true
        ];
    }
}
