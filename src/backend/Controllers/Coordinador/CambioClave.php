<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Controllers\Controller;

class CambioClave implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Cambio de Clave',
            'template' => 'coordinadores/cambio-clave.html.php'
        ];
    }
}