<?php

namespace App\backend\Models;

class Facultad extends DatabaseTable
{
    public const TABLE = 'facultad';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }
}
