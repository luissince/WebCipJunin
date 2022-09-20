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

    public static function update($body){
        DirectivoAdo::update($body);
    }

    public static function delete($body){
        DirectivoAdo::delete($body);
    }
    
    public static function listTbDirectorio($body){
        DirectivoAdo::listTbDirectorio($body);
    }

}