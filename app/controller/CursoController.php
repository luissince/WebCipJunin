<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Model\CursoAdo;

class CursoController
{
    public static function getAll($body)
    {
        $text = $body['text'];
        $posicionPagina = $body['posicionPagina'];
        $filasPorPagina = $body['filasPorPagina'];
        CursoAdo::getAll($text, intval($posicionPagina), intval($filasPorPagina));
    }

    public static function id($body)
    {
        CursoAdo::id($body['idCurso']);
    }

    public static function insert($body)
    {
        CursoAdo::insert($body);
    }

    public static function update($body)
    {
        CursoAdo::update($body);
    }

    public static function delete($body)
    {
        CursoAdo::delete($body);
    }
}