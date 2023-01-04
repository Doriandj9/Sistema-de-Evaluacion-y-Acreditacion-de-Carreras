<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use Illuminate\Database\Eloquent\Model;

class ElementoFundamental extends DatabaseTable
{
    public const TABLE = 'elemento_fundamental';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }

    public function obtenerConEstandares() {
        $estandares = DB::table(self::TABLE)
        ->join('estandar','estandar.id','=','elemento_fundamental.id_estandar')
        ->select([
            'elemento_fundamental.id as id_elemento',
            'elemento_fundamental.descripcion as descripcion',
            'estandar.nombre as nombre_estandar'
        ])->get();
        
        return $estandares;
    }
}
