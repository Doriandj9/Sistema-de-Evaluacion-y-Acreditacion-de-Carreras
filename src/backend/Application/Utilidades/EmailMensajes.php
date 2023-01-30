<?php

namespace App\backend\Application\Utilidades;

use App\backend\Application\Servicios\Email\EnviarEmail;
use ErrorException;
use Illuminate\Support\Env;
use Symfony\Component\Dotenv\Dotenv;

$env = new Dotenv();
$env->loadEnv(__DIR__ . '/../../../../config/.env');
class EmailMensajes {

    public static function docentes(
        $emailEmisor,
        $emailReceptor,
        $datosPlatilla = ['carrera','fecha1','fecha2'],
        $redireccion = false,
        $dir = ''
        ) {
        $file = file_get_contents('./src/backend/datos/mensajes/mensajes.json');
        $mensajes = json_decode($file);
        $ente =  $mensajes->correo[0]->docentes->ente;
        $titulo =  $mensajes->correo[0]->docentes->titulo;
        $titulo =  str_replace('?c',$datosPlatilla[0],$titulo);
        $tituloNotifiaccion =  $mensajes->correo[0]->docentes->tituloNotificacion;
        $mensaje = $mensajes->correo[0]->docentes->mensaje;
        $mensaje = str_replace('?c',$datosPlatilla[0],$mensaje);
        $mensaje = str_replace('?f1',$datosPlatilla[1],$mensaje);
        $mensaje = str_replace('?f2',$datosPlatilla[2],$mensaje);
        $html = EnviarEmail::html(null,$tituloNotifiaccion,$mensaje,$redireccion,$dir);
        return EnviarEmail::enviar($ente, $emailEmisor, $emailReceptor,$titulo,$html);
    }

    public static function coordinador(
        $emailEmisor,
        $emailReceptor,
        $datosPlatilla = ['carrera','fecha1,fecha2'],
        $redireccion = false,
        $dir = ''
    ) {
        $file = file_get_contents('./src/backend/datos/mensajes/mensajes.json');
        $mensajes = json_decode($file);
        $ente =  $mensajes->correo[0]->coordinador->ente;
        $titulo =  $mensajes->correo[0]->coordinador->titulo;
        $titulo =  str_replace('?c',$datosPlatilla[0],$titulo);
        $tituloNotifiaccion =  $mensajes->correo[0]->coordinador->tituloNotificacion;
        $mensaje = $mensajes->correo[0]->coordinador->mensaje;
        $mensaje = str_replace('?c',$datosPlatilla[0],$mensaje);
        $mensaje = str_replace('?f1',$datosPlatilla[1],$mensaje);
        $mensaje = str_replace('?f2',$datosPlatilla[2],$mensaje);
        $html = EnviarEmail::html(null,$tituloNotifiaccion,$mensaje,$redireccion,$dir);
        return EnviarEmail::enviar($ente, $emailEmisor, $emailReceptor,$titulo,$html);
    }

    public static function evluador(
        $emailEmisor,
        $emailReceptor,
        $datosPlatilla = ['carrera','fecha1,fecha2'],
        $redireccion = false,
        $dir = ''
    ) {
        $file = file_get_contents('./src/backend/datos/mensajes/mensajes.json');
        $mensajes = json_decode($file);
        $ente =  $mensajes->correo[0]->evaluadores->ente;
        $titulo =  $mensajes->correo[0]->evaluadores->titulo;
        $titulo =  str_replace('?c',$datosPlatilla[0],$titulo);
        $tituloNotifiaccion =  $mensajes->correo[0]->evaluadores->tituloNotificacion;
        $mensaje = $mensajes->correo[0]->evaluadores->mensaje;
        $mensaje = str_replace('?c',$datosPlatilla[0],$mensaje);
        $mensaje = str_replace('?f1',$datosPlatilla[1],$mensaje);
        $mensaje = str_replace('?f2',$datosPlatilla[2],$mensaje);
        $html = EnviarEmail::html(null,$tituloNotifiaccion,$mensaje,$redireccion,$dir);
        return EnviarEmail::enviar($ente, $emailEmisor, $emailReceptor,$titulo,$html);
    }
    public static function directorPlaneamiento(
        $emailEmisor,
        $emailReceptor,
        $datosPlatilla = ['fecha1,fecha2'],
        $redireccion = false,
        $dir = ''
    ) {
        $file = file_get_contents('./src/backend/datos/mensajes/mensajes.json');
        $mensajes = json_decode($file);
        $ente =  $mensajes->correo[0]->director_planeamiento->ente;
        $titulo =  $mensajes->correo[0]->director_planeamiento->titulo;
        $tituloNotifiaccion =  $mensajes->correo[0]->director_planeamiento->tituloNotificacion;
        $mensaje = $mensajes->correo[0]->director_planeamiento->mensaje;
        $mensaje = str_replace('?f1',$datosPlatilla[0],$mensaje);
        $mensaje = str_replace('?f2',$datosPlatilla[1],$mensaje);
        $html = EnviarEmail::html(null,$tituloNotifiaccion,$mensaje,$redireccion,$dir);
        return EnviarEmail::enviar($ente, $emailEmisor, $emailReceptor,$titulo,$html);
    }
}