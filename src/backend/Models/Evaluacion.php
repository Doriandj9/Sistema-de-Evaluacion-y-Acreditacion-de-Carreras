<?php

declare(strict_types=1);

namespace App\backend\Models;

class Evaluacion extends DatabaseTable
{
    public $id;
    public $nota;

    public function __construct()
    {
        parent::__construct(
            'evaluacion',
            'id',
            'App\backend\Models\Evaluacion'
        );
    }
}
