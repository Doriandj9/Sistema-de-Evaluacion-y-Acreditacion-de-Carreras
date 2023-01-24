<?php

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class ComponenteElementoFundamental extends DatabaseTable
{
    public const TABLE = 'componente_elemento_fundamental';

    public function __construct()
    {
        parent::__construct(self::TABLE,'id');
    }

    public function obtenerConElementos() {
        $estandares = DB::table(self::TABLE)
        ->join('elemento_fundamental','elemento_fundamental.id',
        '=','componente_elemento_fundamental.id_elemento')
        ->select([
            'elemento_fundamental.id as id_elemento',
            'componente_elemento_fundamental.id as id', 
            'componente_elemento_fundamental.descripcion as descripcion',
            'elemento_fundamental.descripcion as descripcion_elemento',
            'componente_elemento_fundamental.id_componente'
        ])->get();
        
        return $estandares;
    }
}