<?php

declare(strict_types=1);

namespace App\backend\Models;

class ElementoFundamental extends DatabaseTable
{
    public $id;
    public $descripcion;
    public $id_estandar;

    public function __construct()
    {
        parent::__construct(
            'elemento_fundamental',
            'id',
            'App\backend\Models\ElementoFundamental'
        );
    }
}
