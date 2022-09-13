<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Model\DirectivoAdo;

class DirectivoController
{
    public static function list($body){
        DirectivoAdo::list($body["opcion"],$body["text"],$body["posicionPagina"],$body["filasPorPagina"]);
    }

    public static function id($body){
        DirectivoAdo::id($body);
    }

    public static function insert($body){
        DirectivoAdo::insert($body);
    }
    
}