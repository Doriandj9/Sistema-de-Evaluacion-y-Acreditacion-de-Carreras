<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;

class Carreras extends DatabaseTable
{
    public const TABLE = 'carreras';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id');
    }

    public function getDatosDocentes(string $idCarrera): \Illuminate\Support\Collection|bool
    {
        $carrera = DB::table(self::TABLE)
        ->find(trim($idCarrera));
        if ($carrera) {
            $docentes_carreras = DB::table(self::TABLE)
            ->join('docentes_carreras', 'carreras.id', '=', 'docentes_carreras.id_carreras')
            ->join('docentes', 'docentes.id', '=', 'docentes_carreras.id_docentes')
            ->get();
            return $docentes_carreras;
        } else {
            return false;
        }
    }
}
