<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Inicio Administrador',
            'template' => 'administrador/inicio.html.php'
        ];
    }
}
