<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Coordinador\Inicio;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasCoordinador implements Route
{
    public function getRoutes(): array
    {
        $inicioController = new Inicio;
        return [
            'coordinador' => [
                'GET' => [
                    'controller' => $inicioController,
                    'action' => 'vista'
                ]
            ]
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
