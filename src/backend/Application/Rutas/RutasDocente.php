<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Docente\Inicio;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasDocente implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
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
            ]
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
