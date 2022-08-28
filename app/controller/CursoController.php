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
        $curso["Nombre"] = $body["Nombre"];
        $curso["Instructor"] = $body["Instructor"];
        $curso["Organizador"] = $body["Organizador"];
        $curso["idCapitulo"] = $body["idCapitulo"];
        $curso["Modalidad"] = $body["Modalidad"];
        $curso["Direccion"] = $body["Direccion"];

        $curso["FechaInicio"] = $body["FechaInicio"];
        $curso["HoraInicio"] = $body["HoraInicio"];
        $curso["PrecioCurso"] = $body["PrecioCurso"];
        $curso["PrecioCertificado"] = $body["PrecioCertificado"];
        $curso["Celular"] = $body["Celular"];
        $curso["Correo"] = $body["Correo"];
        $curso["Descripcion"] = $body["Descripcion"];
        $curso["Estado"] = $body["Estado"];
        $curso["idUsuario"] = $body["idUsuario"];

        CursoAdo::insert($curso);
    }

    public static function update($body)
    {
        $curso["Nombre"] = $body["Nombre"];
        $curso["Instructor"] = $body["Instructor"];
        $curso["Organizador"] = $body["Organizador"];
        $curso["idCapitulo"] = $body["idCapitulo"];
        $curso["Modalidad"] = $body["Modalidad"];
        $curso["Direccion"] = $body["Direccion"];

        $curso["FechaInicio"] = $body["FechaInicio"];
        $curso["HoraInicio"] = $body["HoraInicio"];
        $curso["PrecioCurso"] = $body["PrecioCurso"];
        $curso["PrecioCertificado"] = $body["PrecioCertificado"];
        $curso["Celular"] = $body["Celular"];
        $curso["Correo"] = $body["Correo"];
        $curso["Descripcion"] = $body["Descripcion"];
        $curso["Estado"] = $body["Estado"];
        $curso["idUsuario"] = $body["idUsuario"];
        $curso["idCurso"] = $body["idCurso"];

        CursoAdo::update($curso);
    }

    public static function delete($body)
    {
        $curso["idCurso"] = $body["idCurso"];
        CursoAdo::delete($body);
    }
}