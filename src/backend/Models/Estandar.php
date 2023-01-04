<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Estandar extends DatabaseTable
{
    public const TABLE = 'estandar';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }

    public function obtenerConCriterios() {
        $estandares = DB::table(self::TABLE)
        ->join('criterios','criterios.id','=','estandar.id_criterio')
        ->select([
            'estandar.id as id_estandar',
            'estandar.nombre as nombre_indicador',
            'estandar.descripcion as descripcion',
            'estandar.tipo as tipo',
            'criterios.nombre as nombre_criterio'
        ])->get();
        
        return $estandares;
    }
}
