<?php

declare(strict_types=1);

namespace App\backend\Models;

class EvaluacionDocentes extends DatabaseTable
{
    public $id_evaluacion;
    public $id_docente;

    public function __construct()
    {
        parent::__construct(
            'evaluacion_docentes',
            'id_evaluacion',
            'App\backend\Models\EvaluacionDocentes'
        );
    }
}
