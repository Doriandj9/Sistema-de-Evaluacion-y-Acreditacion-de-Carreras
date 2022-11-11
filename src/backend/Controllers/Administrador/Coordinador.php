<?php

declare(strict_types=1);

namespace App\backend\Controllers\Administrador;

use App\backend\Application\Servicios\Email\EnviarEmail;
use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras;
use App\backend\Models\Docente;
use App\backend\Models\DocentesCarreras;
use App\backend\Models\UsuariosDocente;

class Coordinador implements Controller
{
    private $carrerasModelo;
    private $docenteModelo;
    private $usuarioDocenteModelo;
    private $docentesCarrera;

    public function __construct()
    {
        $this->carrerasModelo = new Carreras;
        $this->docenteModelo = new Docente;
        $this->usuarioDocenteModelo = new UsuariosDocente;
        $this->docentesCarrera = new DocentesCarreras;
    }
    public function vista($variables = []): array
    {
        $carreras = $this->carrerasModelo->select();

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
        $datos_docentes_usuario = [];
        if (!isset($_GET['opcion'])) {
            $datos_docentes_usuario = [
                'id_usuarios' => Docente::COORDINADORES,
                'id_docentes' => trim($_POST['coordinador']),
                'id_carrera' => trim($_POST['carreras']),
                'fecha_inicial' => trim($_POST['fecha_inicial']),
                'fecha_final' => trim($_POST['fecha_final']),
                'estado' => 'activo'
            ];
        }

        if (isset($_GET['opcion']) && $_GET['opcion'] === 'manual') {
            $datos_insertar_docente = [
                'id' => trim($_POST['cedula']),
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'correo' => trim($_POST['correo']),
                'telefono' => empty($_POST['telefono']) ? null : trim($_POST['telefono']),
                'cambio_clave' => true
            ];
            $datos_insertar_carrera = [
                'id_carreras' => trim($_POST['carrera_manual']),
                'id_docentes' => trim($_POST['cedula'])
            ];
            $resultInsertDocente = $this->insertarDocenteYCarrera($datos_insertar_docente, $datos_insertar_carrera);
            if (gettype($resultInsertDocente) === 'string') {
                Http::responseJson($resultInsertDocente);
            }

            $datos_docentes_usuario = [
                'id_usuarios' => Docente::COORDINADORES,
                'id_docentes' => trim($_POST['cedula']),
                'id_carrera' => trim($_POST['carrera_manual']),
                'fecha_inicial' => trim($_POST['f_inicial']),
                'fecha_final' => trim($_POST['f_final']),
                'estado' => 'activo'
            ];
        }

        // Esta linea sirve para generar la clave encriptada del coordinador para ingresar al sistema
        // que por defecto es el mismo numero de cedula
        $dato_docente_clave = [
            'clave' => password_hash($datos_docentes_usuario['id_docentes'], PASSWORD_DEFAULT)
        ];
        // las siguientes lineas va a permitir determinar si existe un error
        // al ingresar un usuario coordinador que previamente haya estado ingresado
        // en el sistema simplemente salte la exepcion y actualiza las fechas de inicio y final
        try {
            $docenteCarrera = $this->usuarioDocenteModelo->selectFromColumn(
                'id_docentes',
                $datos_docentes_usuario['id_docentes']
            )->first();
            $mensajeRespuesta = '';
            if ($docenteCarrera) {
                $carrera = $docenteCarrera->id_carrera;

                if ($datos_docentes_usuario['id_carrera'] !== trim($carrera)) {
                    throw new \PDOException('Error: El usuario no puede ser coordinador de otra carrera');
                } else {
                    $this->usuarioDocenteModelo->updateUsuario(
                        Docente::COORDINADORES,
                        $datos_docentes_usuario['id_docentes'],
                        $datos_docentes_usuario
                    );
                    $mensajeRespuesta = 'El docente anteriormente ya fue coordinador, 
                    se actualizaron las fechas del cargo';
                }
            }else {
                $this->usuarioDocenteModelo->insert($datos_docentes_usuario);
            }
            if (!$this->docenteModelo->updateValues($datos_docentes_usuario['id_docentes'], $dato_docente_clave)) {
                // docenteModelo::updateValues aqui se actualiza la clave y regresa verdader o falso
                throw new \PDOException('Error: No se pudo actualizar correctamente la clave del usuario');
            }
            // Si no se actualizo las fechas se ingresa el coordinador
            $mensajeRespuesta = $mensajeRespuesta === '' ? 'Se ingreso correctamente el usuario coordinador' :
            $mensajeRespuesta;

            // Si no exitio ningun error enviamos una notificacion al docente que es coordinador
            $carrera = $this->carrerasModelo->selectFromColumn('id',$datos_docentes_usuario['id_carrera'])
            ->first()->nombre;
            $cooreo = $this->docenteModelo->selectFromColumn('id',$datos_docentes_usuario['id_docentes'])
            ->first()->correo;
            $respuestaEnvioEmail = EnviarEmail::enviar(
                'Coordinador de la carrera ' . $carrera,
                $_ENV['MAIL_DIRECCION'],
                $cooreo,
                'Sistema de Evaluación y Acreditación de Carreras',
                EnviarEmail::html(
                    null,
                    'Habilitación de la plataforma',
                    'Estimado docente se le notifica que se le a aperturado la 
                    plataforma SEAC para el proceso de evaluación y acreditacion de carreras
                    donde tendra acceso desde la fecha <strong>' . $datos_docentes_usuario['fecha_inicial']
                    . '</strong>  y se le restringira el acceso al mismo desde <strong>' . 
                    $datos_docentes_usuario['fecha_final'] . '</strong>.',
                    true,
                    $_ENV['PROTOCOLO_RED'] . '://' . $_SERVER['SERVER_NAME']
                    // El protcolo de red si tiene ssl ser https caso contratio http
                    // esto se encuentra definido en el /index.php 
                    // por ultimo se concatena todo quedando algo asi https://example.com
                )
            );
            // verificamos que haya existido errores al enviar el correo electronico
            $mensajeRespuestaEmail = '';
            if($respuestaEnvioEmail->ident) {
                $mensajeRespuestaEmail = 'Se envio un email de notificacion al docente correctamente';
            }

            $mensajeRespuestaEmail = $mensajeRespuestaEmail !== '' ? $mensajeRespuestaEmail :
            $respuestaEnvioEmail->mensaje;// Se envial el mensaje de error que contiene el envio
            Http::responseJson(json_encode(// en la table docente en la columna clave
                ['ident' => 1,
                'mensaje' => $mensajeRespuesta,
                'identEmail' => $respuestaEnvioEmail->ident,
                'email' => $mensajeRespuestaEmail,
                ]
            ));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode(
                ['ident' => 0,
                'mensaje' => $e->getMessage()
                ]
            ));
        }
    }

    public function obtenerCoordinadores()
    {
        $coordinadores = $this->usuarioDocenteModelo->obtenerCoordinadores();

        Http::responseJson(json_encode([
            'ident' => 1,
            'coordinadores' => $coordinadores
        ]));
    }


    private function insertarDocenteYCarrera(array $datosDocente, $datosCarrera): bool|string
    {
        try {
            $result = $this->docenteModelo->insert($datosDocente);
            $result = $this->docentesCarrera->insert($datosCarrera);
            return $result;
        } catch (\PDOException $e) {
            return json_encode([
                'ident' => 0,
                'mensaje' => $e->getMessage()
            ]);
        }
    }
}
