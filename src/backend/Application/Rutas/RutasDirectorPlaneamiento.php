<?php

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Director_Planeamiento\Inicio;
use App\backend\Frame\Route;
use App\backend\Models\Docente;

class RutasDirectorPlaneamiento implements Route
{
    public function getRoutes(): array
    {
        $inicio = new Inicio;
        return [
            'director-planeamiento' => [
                'GET' => [
                    'controller' => $inicio,
                    'action' => 'vista'
                ]
            ]
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
            // 'permisos' => Docente::DIRECTOR_PLANEAMIENTO
        ];
    }
}
