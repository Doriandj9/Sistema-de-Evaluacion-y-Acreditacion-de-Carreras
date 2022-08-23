<?php

declare(strict_types=1);

namespace App\backend\Models;

class UsuariosDocente extends DatabaseTable
{


    public function __construct()
    {
        parent::__construct(
            'usuarios_docente',
            'id_usuarios',
            'App\backend\Models\UsuariosDocente'
        );
    }
}
