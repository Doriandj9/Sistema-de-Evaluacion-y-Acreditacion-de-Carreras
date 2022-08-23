<?php

declare(strict_types=1);

namespace App\backend\Models;

class Documentos extends DatabaseTable
{
    public $id;
    public $fecha_inicial;
    public $fecha_final;
    public $pdf;
    public $word;
    public $excel;
    public $id_evidencias;

    public function __construct()
    {
        parent::__construct(
            'documentos',
            'id',
            'App\backend\Models\Documentos'
        );
    }
}
