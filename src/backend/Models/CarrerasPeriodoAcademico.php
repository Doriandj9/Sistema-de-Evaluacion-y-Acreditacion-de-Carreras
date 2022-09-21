<?php

declare(strict_types=1);

namespace App\backend\Models;


class CarrerasPeriodoAcademico extends DatabaseTable
{
    public const TABLE = 'carreras_periodo_academico';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_carreras');
    }
}
