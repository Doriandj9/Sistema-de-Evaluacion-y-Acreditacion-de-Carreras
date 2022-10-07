<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;
use App\backend\Models\Docente;

class Inicio implements Controller
{
    public function vista($variables = []): array
    {
        $_SESSION['permiso'] = Docente::ADMIN;
        return [
            'title' => 'Inicio Administrador',
            'template' => 'administrador/inicio.html.php'
        ];
    }
}
