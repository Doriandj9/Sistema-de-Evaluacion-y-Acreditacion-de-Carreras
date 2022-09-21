<?php

declare(strict_types=1);

namespace App\backend\Models;


class Evaluacion extends DatabaseTable
{
    public const TABLE = 'evaluacion';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
