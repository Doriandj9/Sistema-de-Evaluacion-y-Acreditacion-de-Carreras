<?php

use App\backend\Models\Carreras;
use App\backend\Models\ComponenteElementoFundamental;
use App\backend\Models\Criterios;
use App\backend\Models\Docente;
use App\backend\Models\ElementoFundamental;
use App\backend\Models\Estandar;
use App\backend\Models\EvidenciaComponenteElementoFundamental;
use App\backend\Models\Evidencias;
use App\backend\Models\Facultad;
use App\backend\Models\Responsabilidades;
use App\backend\Models\Usuarios;
use App\backend\Models\UsuariosDocente;

include __DIR__ . '/../vendor/autoload.php';
include __DIR__ . '/../config/database.php';

/*==========================================================

 Datos para el ingreso de Administrador

=========================================================== */

$data_admin = [
    'id' => '0250186665', //Ingrese el numero de cedula
    'nombre' => 'Dorian Josue',
    'apellido' => 'Armijos Gadvay',
    'correo' => 'dorian9armijos@gmail.com',
    'cambio_clave' => true,
    'clave' => '12345', //Es una clave provisional,
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
    case '2' : insertarAdministrador($data_admin);
    default: printDefault(); 
}




// Funciones de cada caso

/**TODO: Insertar los datos al sistema como los criterio, estandares,elementos etc. */
function insertarDatos(){
    // rutas de los archivos del sistema
    $dir_criterios = __DIR__ . '/../src/backend/datos/sistema/criterios.json';
    $dir_estandares_indicadores = __DIR__ . '/../src/backend/datos/sistema/estandares.json';
    $dir_elementos_fundamentales = __DIR__ . '/../src/backend/datos/sistema/elementos_fundamentales.json';
    $dir_componentes_e_fundamentales = __DIR__ . '/../src/backend/datos/sistema/componentes_elementos_fundamentales.json';
    $dir_evidencias = __DIR__ . '/../src/backend/datos/sistema/evidencias.json';
    $dir_evidencias_componentes =  __DIR__ . '/../src/backend/datos/sistema/evidencias_componentes_elementos_fundamentales.json';
    $dir_facultades = __DIR__ . '/../src/backend/datos/sistema/facultades.json';
    $dir_carreras = __DIR__ . '/../src/backend/datos/sistema/carreras.json';
    $dir_usuarios = __DIR__ . '/../src/backend/datos/sistema/usuarios.json';
    $dir_responsabilidades = __DIR__ . '/../src/backend/datos/sistema/responsabilidades.json';
    //datos de los archivos del sistema decodificados de json
    // archivos en json
    $datos_criterios = file_get_contents($dir_criterios);
    $datos_estandares = file_get_contents($dir_estandares_indicadores);
    $datos_elementos_fun = file_get_contents($dir_elementos_fundamentales);
    $datos_componentes_el = file_get_contents($dir_componentes_e_fundamentales);
    $datos_evidencias = file_get_contents($dir_evidencias);
    $datos_evidencias_componentes = file_get_contents($dir_evidencias_componentes);
    $datos_facultades = file_get_contents($dir_facultades);
    $datos_carreras = file_get_contents($dir_carreras);
    $datos_usuarios = file_get_contents($dir_usuarios);
    $datos_responsabilidades = file_get_contents($dir_responsabilidades);
    // datos decodificados de json
    $criterios = json_decode($datos_criterios);
    $estandares_indicadores = json_decode($datos_estandares);
    $elementos_fundamentales = json_decode($datos_elementos_fun);
    $componentes_elemen_fun = json_decode($datos_componentes_el);
    $evidencias = json_decode($datos_evidencias);
    $evidencias_componentes = json_decode($datos_evidencias_componentes);
    $facultades = json_decode($datos_facultades);
    $carreras = json_decode($datos_carreras);
    $usuarios = json_decode($datos_usuarios);
    $responsabilidades = json_decode($datos_responsabilidades);
    //variables que contendran los errores de cada insercion ala DB
    $erroresCriterios = [];
    $erroresEstandares_In = [];
    $erroresElementos_Fun = [];
    $erroresComponentes_El = [];
    $erroresEvidencias = [];
    $erroresEvidenciasComponentes = [];
    $erroresFacultades = [];
    $erroresCarreras = [];
    $erroresUsuarios = [];
    $erroresResponsabilidad = [];
    // variable para mostrar el progreso
    $progreso = 0;
    printProgress($progreso);
    // insertamos la facultad por defecto y la carrera por defecto para el administrador
    $facultadModelo = new Facultad;
    $carreraModelo = new Carreras;
    $progreso += 1;
    printProgress($progreso);
    foreach($facultades as $facultad){
        $data = [
            'id' => $facultad->id,
            'nombre' => $facultad->nombre
        ];
        try{
            $facultadModelo->insert($data);
        }catch(\PDOException $e) {
            array_push($erroresFacultades,[
                'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                'error' => $e->getMessage()
            ]);
        }
    }

    $progreso += 5;
    printProgress($progreso);
    foreach($carreras as $carrera) {
        $data = [
            'id' => $carrera->id,
            'nombre' => $carrera->nombre,
            'id_facultad' => $carrera->id_facultad,
            'numero_asig' => $carrera->numero_asig,
            'total_horas_proyecto' => $carreras->total_horas_proyecto
    
        ];
        try{
            $carreraModelo->insert($data);
        }catch(\PDOException $e) {
            array_push($erroresCarreras,[
                'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                'error' => $e->getMessage()
            ]);
        }
    }
    $progreso +=1;
    printProgress($progreso);
    /**
     * Insertamos los usuarios y responsabilidades
     */
    $usuariosModelo = new Usuarios;
    $responsabilidadesModelo = new Responsabilidades;

    foreach($usuarios as $usuario) {
        $data = [
            'id' => $usuario->id,
            'descripcion' => $usuario->nombre,
            'permisos' => $usuarios->permisos
        ];

        try{   
            $usuariosModelo->insert($data);
        }catch(\PDOException $e) {
            array_push($erroresUsuarios,[
                'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                'error' => $e->getMessage()
            ]);
        }
    }

    foreach($responsabilidades as $responsabilidad) {
        $data = [
            'nombre' => $responsabilidad->nombre,
            'id_criterio' => $responsabilidad->id_criterio
        ];
        try{   
            $responsabilidadesModelo->insert($data);
        }catch(\PDOException $e) {
            array_push($erroresResponsabilidad,[
                'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                'error' => $e->getMessage()
            ]);
        }
    }    
    $progreso += 10;
    printProgress($progreso);
    /**
     * Inserta los datos de los criterios a la base de datos 
     * 
     */
        $ModeloCriterios = new Criterios;
        $progreso +=1;
        printProgress($progreso);
        foreach($criterios->criterios as $dato) {
            $data = [
                'id' => $dato->codigo,
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
        
        $progreso += 10;
        printProgress($progreso);
        /**
         * Insertar estandares
         */
        $ModeloEstandar = new Estandar;
        $progreso +=1;
        printProgress($progreso);

        foreach($estandares_indicadores->estandares as $dato) {
            $data = [
                'id' => $dato->id,
                'nombre' => $dato->nombre,
                'descripcion' => $dato->descripcion,
                'id_criterio' => $dato->id_criterio,
                'tipo' => $dato->tipo
            ];
            try{
                $ModeloEstandar->insert($data);
            }catch(\PDOException $e) {
                array_push($erroresEstandares_In,[
                    'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                    'error' => $e->getMessage()
                ]);
            }
        }

        $progreso += 10;
        printProgress($progreso);

        /**
         * Insertamos los elementos fundamentales
         */
        $ModeloElemento = new ElementoFundamental;
        $progreso +=1;
        printProgress($progreso);

        foreach($elementos_fundamentales->elementos_fundamentales as $dato) {
            $data = [
                'id' => $dato->id,
                'descripcion' => $dato->descripcion,
                'id_estandar' => $dato->id_estandar,
            ];
            try{
                $ModeloElemento->insert($data);
            }catch(\PDOException $e) {
                array_push($erroresElementos_Fun,[
                    'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                    'error' => $e->getMessage()
                ]);
        }
    }

    $progreso += 10;
    printProgress($progreso);


    /**
     * Insertamos los componentes 
     */
    $ModeloComponente = new ComponenteElementoFundamental;
        $progreso +=1;
        printProgress($progreso);

        foreach($componentes_elemen_fun->componentes_elementos_fundamentales as $dato) {
            $data = [
                'id' => $dato->id_elemento,
                'id_componente' => $dato->id_componente,
                'id_elemento' => $dato->id_elemento,
                'descripcion' => $dato->descripcion,
            ];
            try{
                $ModeloComponente->insert($data);
            }catch(\PDOException $e) {
                array_push($erroresComponentes_El,[
                    'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                    'error' => $e->getMessage()
                ]);
        }
    }
    $progreso +=20;
    /**
     * Insertamos las evidencias 
     */
    $ModeloEvidencias = new Evidencias;
        $progreso +=1;
        printProgress($progreso);
        foreach($evidencias->evidencias as $dato) {
            $data = [
                'id' => $dato->id,
                'nombre' => $dato->nombre
            ];
            try{
                $ModeloEvidencias->insert($data);
            }catch(\PDOException $e) {
                array_push($erroresEvidencias,[
                    'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                    'error' => $e->getMessage()
                ]);
        }
    }
    $progreso += 15;
    printProgress($progreso);

    /**
     * Insertar los componenetes a cada evidencia
     */
    $ModeloEvidenciasComponents = new EvidenciaComponenteElementoFundamental;
        $progreso +=1;
        printProgress($progreso);
        foreach($evidencias_componentes->componentes_evidencias as $dato) {
            $compont = preg_split('/-/',$dato->id_componentes);
            foreach($compont as $com){
                $data = [
                    'id_evidencias' => $dato->id_evidencias,
                    'id_componente' => $com
                ];
                try{
                    $ModeloEvidenciasComponents->insert($data);
                }catch(\PDOException $e) {
                    array_push($erroresEvidenciasComponentes,[
                        'fuente' => json_encode($data,JSON_UNESCAPED_UNICODE),
                        'error' => $e->getMessage()
                    ]);
                }
            }

    }
    $progreso += 13;
    printProgress($progreso);

    echo "Finalizado la tarea, recuento de errores: \n";
    if(count($erroresFacultades) === 0 ){
        echo 'Errores al ingresar las facultades : 0' . "\n";
    }else{
        echo "Errores al ingresar las facultades : \n";
        foreach($erroresFacultades as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresCarreras) === 0 ){
        echo 'Errores al ingresar las carreras : 0' . "\n";
    }else{
        echo "Errores al ingresar las carreras : \n";
        foreach($erroresCarreras as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresUsuarios) === 0 ){
        echo 'Errores al ingresar los usuarios : 0' . "\n";
    }else{
        echo "Errores al ingresar los usuarios : \n";
        foreach($erroresUsuarios as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresResponsabilidad) === 0 ){
        echo 'Errores al ingresar las responsabilidades : 0' . "\n";
    }else{
        echo "Errores al ingresar las responsabilidades : \n";
        foreach($erroresResponsabilidad as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresCriterios) === 0 ){
        echo 'Errores al ingresar criterios : 0' . "\n";
    }else{
        echo "Errores al ingresar criterios : \n";
        foreach($erroresCriterios as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresEstandares_In) === 0 ){
        echo 'Errores al ingresar los estandares : 0' . "\n";
    }else{
        echo "Errores al ingresar estandares : \n";
        foreach($erroresEstandares_In as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresElementos_Fun) === 0 ){
        echo 'Errores al ingresar elementos fundamentales : 0' . "\n";
    }else{
        echo "Errores al ingresar elementos fundamentales : \n";
        foreach($erroresElementos_Fun as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresComponentes_El) === 0 ){
        echo 'Errores al ingresar los componentes de elementos fundamentales : 0' . "\n";
    }else{
        echo "Errores al ingresar componentes elementos fundamentales : \n";
        foreach($erroresComponentes_El as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresEvidencias) === 0 ){
        echo 'Errores al ingresar las evidencias : 0' . "\n";
    }else{
        echo "Errores al ingresar las evidencias: \n";
        foreach($erroresEvidencias as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    if(count($erroresEvidenciasComponentes) === 0 ){
        echo 'Errores al emparejar las evidencias con los componentes : 0' . "\n";
    }else{
        echo "Errores al emparejar las evidencias con los componentes: \n";
        foreach($erroresEvidenciasComponentes as $e) {
            echo 'Fuente: ' . $e['fuente'] . "\n";
            echo 'Error: ' . $e['error'].  "\n\n";
        }
    }
    die;
}

function printProgress($progreso) {
    echo 'Progreso de la tarea: ' . $progreso . '%' . "\n";
}
/**TODO: Insertar un nuevo administrador al sistema */
function insertarAdministrador($data_admin) {
    date_default_timezone_set('America/Guayaquil');
    $clave = password_hash($data_admin['clave'],PASSWORD_DEFAULT);
    $data_admin['clave'] = $clave;
    $modelDocente = new Docente;
    $usuarios = new UsuariosDocente;
    $date = new \DateTime();
    $data_usuarios_docente = [
        'id_usuarios' => Docente::ADMIN,
        'id_docentes' => $data_admin['id'],
        'id_carrera' => '0-TICS',
        'fecha_inicial' => $date->format('Y-m-d'),
        'fecha_final' => '2080-01-02',
        'estado' => 'activo'
    ];
    try{
        $modelDocente->insert($data_admin);
        $usuarios->insert($data_usuarios_docente);
        echo "\n Se ingreso el coordinador correctamente.";
    }catch(\PDOException $e) {
        echo 'Error, al ingresar un coordinador' . "\n";
        echo $e->getMessage();
    }
    die;
}
/**TODO: Una impresion normal  */
function printDefault() {
    echo "\n No existe esa opcion";
    die;
}