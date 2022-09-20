<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Model\PresidenteAdo;

class PresidenteController
{
    public static function list($body){
        PresidenteAdo::list($body["opcion"],$body["text"],$body["posicionPagina"],$body["filasPorPagina"]);
    }

    public static function id($body){
        PresidenteAdo::id($body);
    }

    public static function insert($body){
        PresidenteAdo::insert($body);
    }

    public static function update($body){
        PresidenteAdo::update($body);
    }

    public static function delete($body){
        PresidenteAdo::delete($body);
    }
    
}