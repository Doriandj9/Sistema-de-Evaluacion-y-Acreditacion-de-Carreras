<?php

namespace App\backend\Models;

class EvidenciaComponenteElementoFundamental extends DatabaseTable
{
    public const TABLE = 'evidencia_componente_elemento_fundamental';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id_evidencias');
    }
}