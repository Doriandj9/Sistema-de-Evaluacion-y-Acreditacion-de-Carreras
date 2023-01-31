<?php

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Docente;

class Docentes implements Controller
{

    private Docente $docentes;
    
    public function __construct()
    {
        $this->docentes = new Docente;
    }

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
        
        $arcTem = $_FILES['file']['tmp_name'];
        $arcCont = file_get_contents($arcTem);
        $lineas = preg_split('/\n/',$arcCont);
        $primeraLinea = preg_split('/,/',$lineas[0]);
        $datosDocentes = [];
        unset($lineas[0]);
        foreach($lineas as $linea) {
            $datos = preg_split('/,/',$linea);
            $docente = [];
            for($i = 0 ; $i <= count($primeraLinea) - 1; $i++){
                $docente[trim($primeraLinea[$i])] = empty($datos[$i]) ? null : $datos[$i];
            }
            array_push($datosDocentes,$docente);
        }
        
        $datosDocentes = array_filter($datosDocentes, function($docente) {
            if(!$docente['ci_doc']){
                return false;
            }

            return true;
        });
        $errores = [];
        foreach($datosDocentes as $docente){
        try{
            $datoDocente = [
                //'id' => $docente['ci_doc'],
                'nombre' => mb_substr($docente['nombres_doc'],0),
                'apellido' => mb_substr($docente['apellidos_doc'],0),
                'correo' => trim($docente['nick']),
                'telefono' => $docente['celular'],
                //'cambio_clave' => true,
                //'clave' => password_hash($docente['ci_doc'],PASSWORD_DEFAULT)
            ];
            $this->docentes->updateValues($docente['ci_doc'], $datoDocente);
        }catch(\PDOException $e) {
           array_push($errores,$e->errorInfo);
        }
    }
    Http::responseJson(json_encode([
        'ident' => 1,
        'mensaje' => 'Tarea realizada correctamente.',
        'errores' => $errores
    ]));  
    }
}