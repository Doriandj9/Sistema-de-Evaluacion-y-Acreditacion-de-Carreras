<?php

declare(strict_types=1);

namespace App\backend\Models;

class CarrerasEvidencias extends DatabaseTable
{
    public $id_periodo_academico;
    public $id_evidencias;
    public $id_evaluacion;

    public function __construct()
    {
        parent::__construct(
            'carreras_evidencias',
            ''
        );
    }
}
