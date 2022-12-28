<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Evaluador\Evidencias;
use App\backend\Controllers\Evaluador\Inicio;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasEvaluador implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        $evidencias = new Evidencias;
        return [
            'evaluador' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
                ],
            'evaluador/evaluacion/documentos' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'vista'
                ]
                ],
            'evaluador/datos/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'listarEvidenciasPorPeriodo'
                ]
                ],
            'evaluador/listar/pdf/evidencias' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'returnPDF'
                ],
            ],
            'evaluador/registro/calificacion' => [
                'POST' => [
                    'controller' => $evidencias,
                    'action' => 'registroCalificacion'
                ],
            ],
            'evaluador/obtener/calificacion' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'listarCalificacion'
                ],
            ],
            'evaluador/ver/calificacion' => [
                'GET' => [
                    'controller' => $evidencias,
                    'action' => 'estaCalificado'
                ],
            ],
        ];
    }

    public function getTemplate(): string
    {
        return 'layout_evaluadores.html.php';
    }

    public function getRestrict(): array
    {
        return [
            'login' => true,
            'permisos' => Docente::EVALUADORES
        ];
    }
}
