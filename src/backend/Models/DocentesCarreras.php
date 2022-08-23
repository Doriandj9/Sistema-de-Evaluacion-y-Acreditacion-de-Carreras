<?php

declare(strict_types=1);

namespace App\backend\Models;

class DocentesCarreras extends DatabaseTable
{
    public $id_carreras;
    public $id_docentes;

    public function __construct()
    {
        parent::__construct(
            'docentes_carreras',
            'id_carreras',
            'App\backend\Models\DocentesCarreras'
        );
    }
}
