<?php

namespace App\backend\Application\Utilidades;

class FileWord {
    public function retornarFile($evidencia) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        if($evidencia && $evidencia->pdf){
            echo ArchivosTransformar::base64Decode($evidencia->word);   
         }else{
             echo 0;
         }
    }
}