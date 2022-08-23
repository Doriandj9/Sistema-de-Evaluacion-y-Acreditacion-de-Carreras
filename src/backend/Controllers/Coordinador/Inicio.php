<?php

declare(strict_types=1);

namespace App\backend\Controllers\Coordinador;

use App\backend\Controllers\Controller;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Inicio Coordinador',
            'template' => 'coordinadores/inicio.html.php'
        ];
    }
}
