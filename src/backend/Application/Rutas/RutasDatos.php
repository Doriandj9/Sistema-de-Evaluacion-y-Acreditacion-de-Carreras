<?php

declare(strict_types=1);

namespace App\backend\Application\Rutas;

use App\backend\Controllers\Datos\Docentes;
use App\backend\Frame\Route;

class RutasDatos implements Route
{
    public function getRoutes(): array
    {
        $docentes = new Docentes;
        return [
            'datos/docentes' => [
                'GET' => [
                    'controller' => $docentes,
                    'action' => 'vista'
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
            'api-key' => true
        ];
    }
}
