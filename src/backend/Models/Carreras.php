<?php

declare(strict_types=1);

namespace App\backend\Models;

use App\backend\Application\Utilidades\DB;
use App\backend\Application\Utilidades\Http;
use Illuminate\Database\Eloquent\Model;

class Carreras extends Model
{
    // public $id;
    // public $nombre;
    // public $id_facultad;
    // private Docente $docentes;
    // private DocentesCarreras $docentes_carreras;

    // public function __construct()
    // {
    //     parent::__construct(
    //         'carreras',
    //         'id',
    //         'App\backend\Models\Carreras',
    //         ['carreras','id',]
    //     );

    //     $this->docentes = new Docente;
    //     $this->docentes_carreras = new DocentesCarreras;
    // }

    public function getDatosDocentes(string $idCarrera)
    {
        $carrera = DB::table('carreras')
        ->find(trim($idCarrera));
        if ($carrera) {
            $docentes_carreras = DB::table('carreras')
            ->join('docentes_carreras','carreras.id','=','docentes_carreras.id_carreras')
            ->join('docentes','docentes.id','=','docentes_carreras.id_docentes')
            ->get();
            return $docentes_carreras;
        } else {
            return false;
        }
    }
}
