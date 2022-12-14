<?php

namespace App\backend\Models;

class Responsabilidades extends DatabaseTable
{
    public const TABLE = 'responsabilidad';
    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }
}