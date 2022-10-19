<?php

namespace App\backend\Controllers\Datos;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Carreras as ModelsCarreras;
use App\backend\Models\Docente;


class Carreras implements Controller
{
    private Docente $docente;
    private ModelsCarreras $carreras;

    public function __construct()
    {
        $this->docente = new Docente;
        $this->carreras = new ModelsCarreras;
    }

    public function vista($variables = []): array
    {
        if(empty($variables)){
            $carrerasPorUsusario = $this->docente->getCarrerasPorPermisos(
                $_POST['id_usuarios'],
                $_POST['id_docente']
            );
        }
        return [
            'title' => '',
            'template' => 'datos/carreras-por-usuario.html.php',
            'variables' => $variables ?? $variables['carreras'] = $carrerasPorUsusario
        ];
    }

    public function guardarOpciones()
    {
        try {
            //code...
            $_SESSION['opciones'] = true;
            $_SESSION['carrera'] = trim($_POST['carrera']);
            $_SESSION['permiso'] = trim(intval($_POST['permiso']));
            Http::responseJson(json_encode(
                [
                    'ident' => 1,
                    'mensaje' => 'Se ingresaron los datos a la session correctamente'
                ]
            ));
        } catch (\Throwable | \ErrorException $th) {
            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => $th->getMessage()
                ]
            ));
        }
    }

    public function obtenerTodasCarreras() {
        if(isset($_GET['parametro']) && isset($_GET['valor'])){
            if($_GET['parametro'] === 'carrera'){
                try{
                    $carreras = $this->carreras->selectWhitFacultad('carreras.id',$_GET['valor']);
                    if(count($carreras) === 0){
                        throw new \PDOException();
                    }
                    return $this->vista(['carreras' => $carreras]); 
                }catch(\PDOException $e){
                    Http::responseJson(json_encode(
                        [
                            'ident' => 0,
                            'mensaje' => 'Error: No existe la carrera con el identificador <strong>'
                            . $_GET['valor'] . '</strong>'
                        ]
                        ));
                }
                
            }
            if($_GET['parametro'] === 'facultad'){
                $carreras = $this->carreras->selectWhitFacultad('id_facultad',$_GET['valor']);
                return $this->vista(['carreras' => $carreras]); 
            }

            Http::responseJson(json_encode(
                [
                    'ident' => 0,
                    'mensaje' => 'Error ha ingresado un parametro incorrecto'
                ]
                ));
        }
        $carreras = $this->carreras->selectWhitFacultad();
        return $this->vista(['carreras' => $carreras]);
    }
}
