<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Model\CursoAdo;
use SysSoftIntegra\Src\Tools;

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

    public static function validateCert()
    {
        $headers = getallheaders();
        list($bearer, $token) = explode(" ", $headers['Authorization']);

        $json = Tools::open_ssl_decrypt($token);

        if ($json == "error") {
            print json_encode(array(
                "estado" => 2,
                "message" => "Token invalido"
            ));
            exit();
        } else {
            $result = CursoAdo::validateCert($json->idCurso, $json->idParticipante);
            if (is_array($result)) {
                print json_encode(array(
                    "estado" => 1,
                    "curso" => $result[0],
                    "image" => $result[1],
                ));
                exit();
            } else {
                print json_encode(array(
                    "estado" => 2,
                    "message" => $result
                ));
                exit();
            }
        }
    }
}
