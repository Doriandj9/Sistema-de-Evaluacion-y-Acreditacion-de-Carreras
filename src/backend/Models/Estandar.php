<?php

declare(strict_types=1);

namespace App\backend\Models;

class Estandar extends DatabaseTable
{
    public $id;
    public $descripcion;
    public $id_criterio;

    public function __construct()
    {
        parent::__construct(
            'estandar',
            'id',
            'App\backend\Models\Estandar'
        );
    }
}
