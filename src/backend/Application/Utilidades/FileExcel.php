<?php

namespace App\backend\Application\Utilidades;

class FileExcel {
    public function retornarFile($evidencia) {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        if($evidencia && $evidencia->pdf){
            echo ArchivosTransformar::base64Decode($evidencia->excel);   
         }else{
             echo 0;
         }
    }
}