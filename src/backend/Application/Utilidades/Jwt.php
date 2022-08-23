<?php

declare(strict_types=1);

namespace App\backend\Application\Utilidades;

use Firebase\JWT\JWT as JWToken;
use Firebase\JWT\Key;

class Jwt
{
    private const CLAVE = 'Universidad_Estatal_de_Bolivar_Carrera_de_software_2022';
    public static function crearToken(array $datos): string
    {
        $jwt = JWToken::encode(
            $datos,
            self::CLAVE,
            'HS512'
        );

        return $jwt;
    }

    public static function getClave(): Key
    {
        return new Key(self::CLAVE, 'HS512');
    }
}
