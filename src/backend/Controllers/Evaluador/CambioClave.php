<?php

namespace App\backend\Controllers\Evaluador;

use App\backend\Controllers\Controller;

class CambioClave implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Cambio de clave',
            'template' => 'evaluadores/cambio-clave.html.php'
        ];
    }
}