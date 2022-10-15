<?php

namespace App\backend\Controllers\Datos;

use App\backend\Controllers\Controller;
use App\backend\Models\Facultad as ModelsFacultad;

class Facultad implements Controller
{
    private ModelsFacultad $modeloFacultad;

    public function __construct()
    {
        $this->modeloFacultad = new ModelsFacultad;
    }
    public function vista($variables = []): array
    {
        $facultades = $this->modeloFacultad->select(true,'nombre');
        return [
            'title' => '',
            'template' => 'datos/facultades.html.php',
            'variables' => [
                'facultades' => $facultades
            ]
        ];
    }
}