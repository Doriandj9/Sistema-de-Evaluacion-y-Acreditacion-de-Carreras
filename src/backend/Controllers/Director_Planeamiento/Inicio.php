<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Controllers\Controller;
use App\backend\Models\Docente;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        $_SESSION['permiso'] = Docente::DIRECTOR_PLANEAMIENTO;
        return [
            'title' => 'Director Planeamiento',
            'template' => 'director_planeamiento/inicio.html.php'
        ];
    }
}
