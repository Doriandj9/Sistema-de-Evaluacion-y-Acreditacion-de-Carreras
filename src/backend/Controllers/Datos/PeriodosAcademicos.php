<?php

namespace App\backend\Controllers\Datos;

use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico;

class PeriodosAcademicos implements Controller
{
    private PeriodoAcademico $modeloPeriodoAcademico;
    public function __construct()
    {
        $this->modeloPeriodoAcademico = new PeriodoAcademico;   
    }
    public function vista($variables = []): array
    {
        $periodosAcademicos = $this->modeloPeriodoAcademico->select();
        $variables['periodoAcademico'] = $periodosAcademicos;
        return [
            'title' => '',
            'template' => 'administrador/datos-periodo-academico.html.php',
            'variables' => $variables
        ];
    }
}