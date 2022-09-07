<?php

namespace App\backend\Controllers\Datos;

use App\backend\Application\Utilidades\DB;
use App\backend\Controllers\Controller;

class PeriodosAcademicos implements Controller
{
    public function vista($variables = []): array
    {
        $periodosAcademicos = DB::table('periodo_academicos')->get();
        $variables['periodoAcademico'] = $periodosAcademicos;
        return [
            'title' => '',
            'template' => 'administrador/datos-periodo-academico.html.php',
            'variables' => $variables
        ];
    }
}