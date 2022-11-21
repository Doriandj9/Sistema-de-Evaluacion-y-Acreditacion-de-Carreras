<?php

namespace App\backend\Controllers\Docente;

use App\backend\Controllers\Controller;

class Evidencias implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Docente - Evidencias',
            'template' => 'docentes/evidencias.html.php'
        ];
    }
}