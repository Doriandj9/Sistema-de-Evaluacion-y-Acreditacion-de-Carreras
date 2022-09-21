<?php

declare(strict_types=1);

namespace App\backend\Models;


class UsuariosDocente extends DatabaseTable
{
    public const TABLE = 'usuarios_docente';

    public function __construct()
    {
        parent::__construct(self::TABLE, 'id_usuarios');
    }
}
