<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Src\Response;
use SysSoftIntegra\Model\InscripcionAdo;


class InscripcionController
{
    public static function getAll($body)
    {
        $text = $body['text'];
        $idCurso = $body['idCurso'];
        $posicionPagina = $body['posicionPagina'];
        $filasPorPagina = $body['filasPorPagina'];
        $result = InscripcionAdo::getAll($text, $idCurso, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            Response::sendSuccess($result);
        } else {
            Response::sendError($result);
        }
    }

    public static function insert($body)
    {
        InscripcionAdo::insert($body);
    }
}
