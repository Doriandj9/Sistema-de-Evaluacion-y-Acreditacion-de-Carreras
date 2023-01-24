<?php

namespace App\backend\Controllers\Director_Planeamiento;

use App\backend\Application\Utilidades\Http;
use App\backend\Controllers\Controller;
use App\backend\Models\Docente;
use App\backend\Models\PeriodoAcademico;
use App\backend\Models\UsuariosDocente;

class Evaluadores implements Controller {
    private PeriodoAcademico $periodos;
    private UsuariosDocente $evaluadores;

    public function __construct()
    {
        $this->periodos = new PeriodoAcademico;
        $this->evaluadores = new UsuariosDocente;
    }

    public function vista($variables = []): array
    {
        $periodos = $this->periodos->select(true,'id','desc');
        $variables['periodos'] = $periodos;

        return [
            'title' => 'Emparejamiento de evaluadores | SEAC',
            'template' => 'director_planeamiento/emparejamiento.html.php',
            'variables' => $variables
        ];
    }

    public function listarEvaluadores() {
        try {
            $evaluadores = $this->evaluadores->listarEvaluadoresEmparejamiento();
            Http::responseJson(json_encode([
                'ident' => 1,
                'evaluadores' => $evaluadores
            ]));
        } catch (\PDOException $e) {
            Http::responseJson(json_encode([
                'ident' => 0,
                'evaluadores' => $e->getMessage()
            ]));
        }
    }

    public function registro() {
        $carreras = $_POST['carreras'];
        $errores = [];
        foreach($carreras as $carrera){
            $usuario = UsuariosDocente::whereRaw(
                'id_usuarios = ? and id_docentes = ? and id_carrera = ?',
                [Docente::EVALUADORES,trim($_POST['cedula']),$carrera]
            )->get();
            $data_usuarios = [
                'id_usuarios' => Docente::EVALUADORES,
                'id_docentes' => trim($_POST['cedula']),
                'id_carrera' => $carrera,
                'fecha_inicial' => trim($_POST['f_i']),
                'fecha_final' => trim($_POST['f_f']),
                'estado' => 'activo'
            ];
            try{
                if($usuario->count() <= 0) {
                    $this->evaluadores->insert($data_usuarios);
                }else {
                    UsuariosDocente::where('id_usuarios',Docente::EVALUADORES)
                    ->where('id_docentes',trim($_POST['cedula']))
                    ->where('id_carrera',$carrera)
                    ->update([
                        'fecha_inicial' => trim($_POST['f_i']),
                        'fecha_final' => trim($_POST['f_f']),
                        'estado' => 'activo'
                    ]);
                }
                
            }catch(\PDOException $e) {
                array_push($errores,$e->getMessage());
            }
        }
        
        if(count($errores) >= 1){
            Http::responseJson(json_encode([
                'ident' => 0,
                'mensaje' => $errores
            ]));
        }

        Http::responseJson(json_encode([
            'ident' => 1,
            'mensaje' => 'Se ingreso correctamente los datos.'
        ]));
    }
}