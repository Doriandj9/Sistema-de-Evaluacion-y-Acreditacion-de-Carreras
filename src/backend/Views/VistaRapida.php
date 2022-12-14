<?php

namespace App\backend\Views;

class VistaRapida {


    public static function error404() {
        return [
            'title' => 'Pagina no Encontrada',
            'template' => 'ui/error404.html.php'
        ];
    }
    public static function error403() {
        return [
            'title' => 'Pagina no Encontrada',
            'template' => 'ui/error403.html.php'
        ];
    }
    public static function errorLogin() {
        return [
            'title' => 'Pagina no Encontrada',
            'template' => 'ui/error_login.html.php'
        ];
    }   
}