<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Coordinador\Docentes;
use App\backend\Controllers\Coordinador\Evidencias;
use App\backend\Controllers\Coordinador\Inicio;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasCoordinador implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        $docentes = new Docentes;
        $evidencias = new Evidencias;
        return [
            'coordinador' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
                ],
            'coordinador/docentes' => [
                'GET' => [
                    'controller' => $docentes,
                    'action' => 'vista'
                ]
                ],
            'coordinador/datos/docentes/carrera' => [
                'GET' => [
                    'controller' => $docentes,
                    'action' => 'listarDocentes'
                ],
            ],
            'coordinador/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'vista'
                ],
            ],
            'coordinador/registrar/docente' => [
                'POST' => [
                    'controller' => $docentes,
                    'action' => 'registar'
                ],
            ],
            'coordinador/datos/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'listarEvidenciasPorPeriodo'
                ],
            ],
            'coordinador/subir/evidencias' => [
                'POST' => [
                    'controller' => $evidencias,
                    'action' => 'registrar'
                ],
            ],
            'coordinador/listar/pdf/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'returnPDF'
                ],
            ],
            'coordinador/listar/word/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'returnWord'
                ],
            ],
            'coordinador/listar/excel/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'returnExcel'
                ],
            ],
        ];
    }
    public function getTemplate(): string
    {
        return 'layout_coordinadores.html.php';
    }

    public function getRestrict(): array
    {
        return [
            'permisos' => Docente::COORDINADORES,
            'login' => true
        ];
    }
}
