<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;

class Docentes implements Controller
{
    public function vista($variables = []): array
    {
        return [
            'title' => 'Actualizar datos de los docentes',
            'template' => 'administrador/docentes.html.php'
        ];
    }

    public function actualizarDatos() {
        /**
         * Argumentos de cada columna necesaria para la tabla docentes
         * los indices tiene que coincidir con los nombres del encabezado del 
         * archivo mientras que los valores son los nombres de las columnas de la 
         * tabla docentes
         */
        $columnas = ['name' => 'nombre','lastname' => 'apellido','cedula' => 'id',
        'email' => 'correo','phone' => 'telefono'];
        $keys = array_keys($columnas);
        $arcTem = $_FILES['file']['tmp_name'];
        $arcCont = file_get_contents($arcTem);
        $lineas = preg_split('/\n/',$arcCont);
        $primeraLinea = $lineas[0]; 
        if(!$this->everyDatos($columnas,$primeraLinea)){
            $mensaje = 'Error, asegurese de que el archivo contenga las columnas necesarias
            para actualizar los datos:';
            foreach($keys as $key){
                $mensaje .= "$key, ";
            }
            $mensaje = rtrim($mensaje,', ');
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $mensaje 
            ]));
        }
        
        die;
    }
    
    private function everyDatos($datos,$linea) {

        foreach($datos as $indice => $dato){
            if(!str_contains($linea,$indice)){
                return false;
            }
        }

        return true;
    }
}