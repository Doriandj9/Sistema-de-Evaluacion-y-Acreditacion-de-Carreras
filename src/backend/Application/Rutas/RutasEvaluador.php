<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Evaluador\Inicio;
use App\backend\Frame\Route;

class RutasEvaluador implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        return [
            'evaluador' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
            ]
        ];
    }

    public function getTemplate(): string
    {
        return 'layout_evaluadores.html.php';
    }

    public function getRestrict(): array
    {
        return [];
    }
}
