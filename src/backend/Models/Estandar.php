<?php

declare(strict_types=1);

namespace App\backend\Models;


class Estandar extends DatabaseTable
{
    public const TABLE = 'estandar';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
