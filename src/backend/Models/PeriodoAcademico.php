<?php

declare(strict_types=1);

namespace App\backend\Models;

class PeriodoAcademico extends DatabaseTable
{
    public $id;
    public $fecha_inicial;
    public $fecha_final;

    public function __construct()
    {
        parent::__construct(
            'periodo_academico',
            'id',
            'App\backend\Models\PeriodoAcademico',
            ['periodo_academico','id']
        );
    }
}
