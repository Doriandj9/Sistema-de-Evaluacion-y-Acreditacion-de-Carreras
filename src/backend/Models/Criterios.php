<?php

declare(strict_types=1);

namespace App\backend\Models;

class Criterios extends DatabaseTable
{
    public $id;
    public $nombre;

    public function __construct()
    {
        parent::__construct(
            'criterios',
            'id',
            'App\backend\Models\Criterios',
            ['criterios','id']
        );
    }
}
