<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Controllers\Controller;

class CambioClave implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Cambio de Clave | SEAC',
            'template' => 'director_planeamiento/cambio-clave.html.php',
        ];
    }
}