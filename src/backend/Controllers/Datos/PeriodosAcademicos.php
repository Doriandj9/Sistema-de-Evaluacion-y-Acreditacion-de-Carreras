<?php

namespace App\backend\Controllers\Datos;
use App\backend\Controllers\Controller;
use App\backend\Models\PeriodoAcademico;

class PeriodosAcademicos implements Controller
{
    private $periodosAcademicos;
    public function __construct()
    {
        $this->periodosAcademicos = new PeriodoAcademico;
    }
    public function vista($variables = []): array
    {
        $periodosAcademicos = $this->periodosAcademicos->select(true, 'id', 'desc');
        $variables['periodoAcademico'] = $periodosAcademicos;
        return [
            'title' => '',
            'template' => 'administrador/datos-periodo-academico.html.php',
            'variables' => $variables
        ];
    }
}
