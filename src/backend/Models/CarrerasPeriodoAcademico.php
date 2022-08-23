<?php

declare(strict_types=1);

namespace App\backend\Models;

class CarrerasPeriodoAcademico extends DatabaseTable
{
    public $id_carreras;
    public $id_periodo_academico;

    public function __construct()
    {
        parent::__construct(
            'carreras_periodo_academico',
            'id_carreras',
            'App\backend\Models\CarrerasPeriodoAcademico',
            ['carreras_periodo_academico','id_carreras']
        );
    }
}
