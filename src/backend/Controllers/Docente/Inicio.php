<?php

declare(strict_types=1);

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Inicio Docentes',
            'template' => 'docentes/inicio.html.php'
        ];
    }
}
