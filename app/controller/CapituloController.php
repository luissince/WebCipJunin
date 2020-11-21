<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/CapituloAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') { 
    
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $especialidades = CapituloAdo::getAllEspecialidades($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($especialidades)) {
            echo json_encode(array(
                "estado" => 1,
                "especialidades" => $especialidades[0],
                "total" => $especialidades[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $especialidades
            ));
        }
    } else if($_GET["type"] === "allCapitulos"){
        $capitulos = CapituloAdo::getAllDistinctCapitulos();
        if (is_array($capitulos)) {
            echo json_encode(array(
                "estado" => 1,
                "capitulos" => $capitulos,
                //"mensaje" => "hijo de tu puta madre"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $capitulos
            ));
        }
    } else if($_GET["type"] === "allEspecialidades"){
        $especialidades = CapituloAdo::getAllDistinctEspecialidades();
        if (is_array($especialidades)) {
            echo json_encode(array(
                "estado" => 1,
                "especialidades" => $especialidades,
                //"mensaje" => "hijo de tu puta madre"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $especialidades
            ));
        }
    }

}
