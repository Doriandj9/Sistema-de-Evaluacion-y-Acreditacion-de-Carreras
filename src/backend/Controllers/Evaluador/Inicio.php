<?php

declare(strict_types=1);

namespace App\backend\Controllers\Evaluador;

use App\backend\Controllers\Controller;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Inicio Evaluador',
            'template' => 'evaluadores/inicio.html.php'
        ];
    }
}
