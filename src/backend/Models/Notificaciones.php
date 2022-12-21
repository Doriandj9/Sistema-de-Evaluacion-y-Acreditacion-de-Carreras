<?php

namespace App\backend\Models;

class Notificaciones extends DatabaseTable
{
    public const TABLE = 'notificaciones';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }
}