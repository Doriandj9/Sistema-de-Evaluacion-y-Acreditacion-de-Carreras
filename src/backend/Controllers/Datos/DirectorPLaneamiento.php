<?php

namespace App\backend\Controllers\Datos;

use App\backend\Controllers\Controller;
use App\backend\Models\Docente;
use App\backend\Models\UsuariosDocente;

class DirectorPlaneamiento implements Controller
{
    private UsuariosDocente $usuariosDocentes;
    public function __construct()
    {
        $this->usuariosDocentes = new UsuariosDocente;
    }
    public function vista($variables = []): array
    {
        $usuariosDocentes = $this->usuariosDocentes->selectDirectoresPlaneamiento();
        return [
            'title' => '',
            'template' => 'datos/director-planeamiento.html.php',
            'variables' => [
                'directores' => $usuariosDocentes
            ]
        ];
    }
}
