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
