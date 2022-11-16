<?php

namespace App\backend\Application\Utilidades;

class ArchivosTransformar {

    public static function base64(string $rutaFile): string|bool
    {   
        if(!file_exists($rutaFile)){
            return false;
        }

        $arch = file_get_contents($rutaFile);
        $str64 = base64_encode($arch);
        return $str64;
    }

    public static function base64Decode(string $str64)
    {
        $decode = base64_decode($str64);
        return $decode;
    }
    /**
     * @param string $nombreArchivo asegurese de escribir correctament por ejemplo exaple.pdf
     * @param string $rutaCarpeta donde se guardara el archivo el punto de partida es del index.php
     * @param string $str64 es el string en base 64 codificado
     */
    public static function transformarDeBase64aArchivo(
        string $nombreArchivo,
        string $str64,
        string $rutaCarpeta= './src/backend/datos/archivos/'
    ): bool
    {
        $rutaCompleta = $rutaCarpeta.$nombreArchivo;
        if(file_put_contents($rutaCompleta,self::base64Decode($str64))){
            return true;
        }

        return false;
    }
}