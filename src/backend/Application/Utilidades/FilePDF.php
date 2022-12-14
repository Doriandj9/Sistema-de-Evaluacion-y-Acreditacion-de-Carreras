<?php

namespace App\backend\Application\Utilidades;

class FilePDF {
    public function retornarFile($evidencia) {
        header('Content-Type: application/pdf');
        if($evidencia && $evidencia->pdf){
           echo ArchivosTransformar::base64Decode($evidencia->pdf);   
        }else{
            echo 0;
        }
    }
}