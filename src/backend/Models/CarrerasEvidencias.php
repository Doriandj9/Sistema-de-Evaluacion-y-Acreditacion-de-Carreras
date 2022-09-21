<?php

declare(strict_types=1);

namespace App\backend\Models;


class CarrerasEvidencias extends DatabaseTable
{
    public const TABLE = 'carreras_evidencias';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_periodo_academico');
    }
}
