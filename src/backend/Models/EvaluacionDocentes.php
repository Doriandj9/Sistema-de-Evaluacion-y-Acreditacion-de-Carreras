<?php

declare(strict_types=1);

namespace App\backend\Models;


class EvaluacionDocentes extends DatabaseTable
{
    public const TABLE = 'evaluacion_docentes';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_evaluacion');
    }
}
