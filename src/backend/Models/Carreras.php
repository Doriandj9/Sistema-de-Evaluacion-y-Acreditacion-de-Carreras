<?php

declare(strict_types=1);

namespace App\backend\Models;

class Carreras extends DatabaseTable
{
    public $id;
    public $nombre;
    public $id_facultad;
    private Docente $docentes;
    private DocentesCarreras $docentes_carreras;

    public function __construct()
    {
        parent::__construct(
            'carreras',
            'id',
            'App\backend\Models\Carreras',
            ['carreras','id',]
        );

        $this->docentes = new Docente;
        $this->docentes_carreras = new DocentesCarreras;
    }

    public function getDatosDocentes(string $idCarrera): array|bool
    {
        $carrera = $this->selectFromColumn('id', $idCarrera);
        $docentes = [];
        if ($carrera) {
            $docentes_carreras = $this->docentes_carreras->selectFromColumn('id_carreras', $carrera[0]->id);
            foreach ($docentes_carreras as $docentesTable) {
                $docente = $this->docentes->selectFromColumn('id', $docentesTable->id_docentes)[0];
                array_push($docentes, $docente);
            }

            return $docentes;
        } else {
            return false;
        }
    }
}
