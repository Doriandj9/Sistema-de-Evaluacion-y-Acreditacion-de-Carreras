<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Docente\Evidencias;
use App\backend\Controllers\Docente\Inicio;
use App\backend\Controllers\Docente\Reportes;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasDocente implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        $evidencias = new Evidencias;
        $reportes = new Reportes;
        return [
            'docente' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
            ],
            'docente/inicio' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
                ],
            'docente/evidencias' => [
                    'GET' => [
                        'controller' => $evidencias,
                        'action' => 'vista'
                    ]
                    ],
            'docente/datos/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'listarEvidenciasPorPeriodo'
                ]
                ],
            'docente/subir/evidencias' => [
                    'POST' => [
                        'controller' => $evidencias,
                        'action' => 'registrar'
                    ],
                ],
            'docente/listar/pdf/evidencias' => [
                    'GET' => [
                        'controller' => $evidencias,
                        'action' => 'returnPDF'
                    ],
                ],
            'docente/listar/word/evidencias' => [
                    'GET' => [
                        'controller' => $evidencias,
                        'action' => 'returnWord'
                    ],
                ],
            'docente/listar/excel/evidencias' => [
                    'GET' => [
                        'controller' => $evidencias,
                        'action' => 'returnExcel'
                    ],
                ],
            'docente/reportes' => [
                        'GET' => [
                            'controller' => $reportes,
                            'action' => 'vista'
                        ]
                        ],
            
        ];
    }

    public function getTemplate(): string
    {
        return 'layout_docentes.html.php';
    }

    public function getRestrict(): array
    {
        return [
            'login' => true,
            'permisos' => Docente::DOCENTES
        ];
    }
}
