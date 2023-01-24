<?php

namespace App\backend\Models;

class Usuarios extends DatabaseTable
{
    public const TABLE = 'usuarios';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }
}