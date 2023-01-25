<?php

namespace App\backend\Models;

class Titulos extends DatabaseTable
{
    public const TABLE = 'titulos';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }
}