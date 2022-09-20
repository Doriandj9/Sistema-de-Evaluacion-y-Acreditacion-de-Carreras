<?php

declare(strict_types=1);

namespace App\backend\Models;


class PeriodoAcademico extends DatabaseTable
{
    public const TABLE = 'periodo_academicos';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
