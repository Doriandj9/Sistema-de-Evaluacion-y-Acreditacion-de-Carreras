<?php

declare(strict_types=1);

namespace App\backend\Application\Utilidades;

use Firebase\JWT\JWT as JWToken;
use Firebase\JWT\Key;

class Jwt
{
    private const HASH = 'HS512';
    private const CLAVE = 'Universidad_Estatal_de_Bolivar_Carrera_de_software_2022';

    /**
     * Esta funcion se encarga de crear el json web token
     * a partir de los valores enviando en una matriz
     *
     * @param array $datos datos en un array para ser creados como token
     *
     * @return string $jwt json web token
     */
    public static function crearToken(array $datos): string
    {
        $jwt = JWToken::encode(
            $datos,
            self::CLAVE,
            self::HASH
        );

        return $jwt;
    }

    private static function getClave(): Key
    {
        return new Key(self::CLAVE, self::HASH);
    }

    public static function decodificadorToken(string $jwt): \stdClass
    {
        $jwtDecodificado = JWToken::decode($jwt, self::getClave());

        return $jwtDecodificado;
    }
}
