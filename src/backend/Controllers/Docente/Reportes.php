<?php

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;

class Reportes implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Docentes - Generación de Reportes',
            'template' => 'docentes/reportes.html.php'
        ];
    }
} 
