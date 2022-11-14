<?php

namespace App\backend\Controllers\Coordinador;

use App\backend\Controllers\Controller;

class Evidencias implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Evidencias del Coordinador',
            'template' => 'coordinadores/evidencias.html.php'
        ];
    }
}