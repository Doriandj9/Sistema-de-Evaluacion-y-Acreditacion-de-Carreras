<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;

class CambioClave implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Cambio de Contraseña',
            'template' => 'administrador/cambio-clave.html.php'
        ];
    }
}
