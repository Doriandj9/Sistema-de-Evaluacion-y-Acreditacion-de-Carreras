<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class EvidenciasEvaluacion extends DatabaseTable
{
    public const TABLE = 'evidencias_evaluacion';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id_evidencia');
    }

    public function lastInsertDatos() {
        
    }
}