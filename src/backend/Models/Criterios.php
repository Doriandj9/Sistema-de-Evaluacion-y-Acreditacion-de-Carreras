<?php

declare(strict_types=1);

namespace App\backend\Models;


class Criterios extends DatabaseTable
{
    public const TABLE = 'criterios';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
