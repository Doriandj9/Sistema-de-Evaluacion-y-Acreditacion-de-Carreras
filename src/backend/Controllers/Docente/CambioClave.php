<?php

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;

class CambioClave implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Cambio Clave',
            'template' => 'docentes/cambio-clave.html.php'
        ];
    }
}