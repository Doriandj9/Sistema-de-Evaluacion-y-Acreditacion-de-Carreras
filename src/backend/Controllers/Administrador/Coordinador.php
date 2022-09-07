<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Utilidades\DB;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Frame\Autentification;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\UsuariosDocente;

class Coordinador implements Controller
{
    private $carrerasModelo;
    private $docenteModelo;
    private $usuarioDocenteModelo;

    public function __construct()
    {
        $this->carrerasModelo = new Carreras;
        $this->docenteModelo = new Docente;
        $this->usuarioDocenteModelo = new UsuariosDocente;
    }
    public function vista($variables = []): array
    {
        $carreras = DB::table('carreras')->get();
        return [
            'title' => 'Ingreso de un Coordinador',
            'template' => 'administrador/agregar_coordinador.html.php',
            'variables' => [
                'carreras' => $carreras
            ]
        ];
    }

    public function agregarCoordinadorACarrera()
    {

        $datos_docentes_usuario = [
            'id_usuarios' => Docente::COORDINADORES,
            'id_docentes' => $_POST['coordinador'],
            'id_carrera' => $_POST['carreras'],
            'fecha_inicial' => $_POST['fecha_inicial'],
            'fecha_final' => $_POST['fecha_final'],
            'estado' => 'activo'
        ];
        // Esta linea sirve para generar la clave encriptada del coordinador para ingresar al sistema
        // que por defecto es el mismo numero de cedula
        $dato_docente_clave = [
            'clave' => password_hash($_POST['coordinador'], PASSWORD_DEFAULT)
        ];
        // las siguientes lineas va a permitir determinar si existe un error
        // al ingresar un usuario coordinador que previamente haya estado ingresado
        // en el sistema simplemente salte la exepcion y actualiza las fechas de inicio y final
        try {
            $docenteCarrera = $this->usuarioDocenteModelo->selectFromColumn(
                'id_docentes',
                $datos_docentes_usuario['id_docentes']
            );
            if($docenteCarrera){
                $carrera = $docenteCarrera[0]->id_carrera;
                if($datos_docentes_usuario['id_carrera'] !== trim($carrera)){
                    throw new \PDOException('Error: El usuario no puede ser coordinador de otra carrera');
                }else{
                    unset($datos_docentes_usuario['id_docentes']);
                    $this->usuarioDocenteModelo->update(
                        $datos_docentes_usuario['id_usuarios'],
                        $datos_docentes_usuario
                    );
                    Http::responseJson(json_encode(
                        ['ident' => 1,
                        'result' => 'El docente anteriormente ya fue coordinador, se actualizaron las fechas',
                        'error' => ''
                        ]
                    ));
                }
            }
            $this->usuarioDocenteModelo->insert($datos_docentes_usuario);
            $this->docenteModelo->update($_POST['coordinador'], $dato_docente_clave);// aqui se actualiza la clave
            Http::responseJson(json_encode(// en la table docente en la columna clave
                ['ident' => 1, 'result' => 'Se ingreso correctamente el usuario coordinador', 'error' => '']
            ));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                ['ident' => 0,
                'result' => '',
                'error' => $e->getMessage()
                ]
            ));
        }
    }
}
