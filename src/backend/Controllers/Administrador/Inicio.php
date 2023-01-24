<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Docente;

class Inicio implements Controller
{
    private Autentification $autentificacion;
    private Docente $docentes;

    public function __construct()
    {
        $this->docentes = new Docente;
        $this->autentificacion = new Autentification(
            'correo',
            'clave',
            $this->docentes
        );
    }
    public function vista($variables = []): array
    {
        $_SESSION['permiso'] = Docente::ADMIN;
        $usuario = $this->autentificacion->getUsuario();
        $variables['usuario'] = $usuario;
        return [
            'title' => 'Inicio Administrador',
            'template' => 'administrador/inicio.html.php',
            'variables' => $variables
        ];
    }
}
