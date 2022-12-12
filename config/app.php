<?php

use App\backend\Models\Criterios;

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/database.php';

/*==========================================================

 Datos para el ingreso de Administrador

=========================================================== */

$data_admin = [
    'id' => '', //Ingrese el numero de cedula
    'nombre' => '',
    'apellido' => '',
    'correo' => '',
    'cambio_clave' => true,
    'clave' => '', //Es una clave provisional,
    'telefono' => '' //opcional
];

/**------------------------------TODO: Opciones del Sistema -------------------------- */
$optionList = [
    '1' => 'Insertar todos los datos para el sistema',
    '2' => 'Ingresar un administrador'
];
echo "Selecione una de las opciones\n";
foreach($optionList as $key => $op) {
    echo "$key:$op\n";
}
$option = readline('[opcion]: ' . "\n");

switch($option){
    case '1' : insertarDatos();
    case '2' : insertarAdministrador();
    default: printDefault(); 
}




// Funciones de cada caso

/**TODO: Insertar los datos al sistema como los criterio, estandares,elementos etc. */
function insertarDatos(){
    // rutas de los archivos del sistema
    $dir_criterios = __DIR__ . '/../src/backend/datos/sistema/criterios.json';
    $dir_estandares_indicadores = __DIR__ . '/../src/backend/datos/sistema/estandares_indicadores.json';
    $dir_elementos_fundamentales = __DIR__ . '/../src/backend/datos/sistema/elementos_fundamentales.json';
    $dir_componentes_e_fundamentales = __DIR__ . '/../src/backend/datos/sistema/componentes_elementos.json';
    $dir_evidencias = __DIR__ . '/../src/backend/datos/sistema/evidencias.json';
    //datos de los archivos del sistema decodificados de json
    // archivos en json
    $datos_criterios = file_get_contents($dir_criterios);
    $datos_estandares = file_get_contents($dir_estandares_indicadores);
    $datos_elementos_fun = file_get_contents($dir_elementos_fundamentales);
    $datos_componentes_el = file_get_contents($dir_componentes_e_fundamentales);
    $datos_evidencias = file_get_contents($dir_evidencias);
    // datos decodificados de json
    $criterios = json_decode($datos_criterios);
    $estandares_indicadores = json_decode($datos_estandares);
    $elementos_fundamentales = json_decode($datos_elementos_fun);
    $componentes_elemen_fun = json_decode($datos_componentes_el);
    $evidencias = json_decode($datos_evidencias);
    //variables que contendran los errores de cada insercion ala DB
    $erroresCriterios = [];
    $erroresEstandares_In = [];
    $erroresElementos_Fun = [];
    $erroresComponentes_El = [];
    $erroresEvidencias = [];
    // variable para mostrar el progreso
    $progreso = 0;
    /**
     * Inserta los datos de los criterios a la base de datos 
     * 
     */
        $ModeloCriterios = new Criterios;
        $progreso +=1;
        foreach($criterios['criterios'] as $dato) {
            $data = [
                'id' => $dato->id,
                'nombre' => $dato->nombre
            ];
            try{
                $ModeloCriterios->insert($data);
            }catch(\PDOException $e) {
                array_push($erroresCriterios,[
                    'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $progreso += 20;

    die;
}

/**TODO: Insertar un nuevo administrador al sistema */
function insertarAdministrador() {
    
}
/**TODO: Una impresion normal  */
function printDefault() {
    echo "\n No existe esa opcion";
    die;
}