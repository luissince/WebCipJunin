<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../model/PersonaAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if($_GET["type"] === "alldata"){
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAll(intval($posicionPagina),intval($filasPorPagina));
        if(is_array($personas)){
            echo json_encode(array(
                "estado" => 1,
                "personas"=>$personas[0],
                "total"=>$personas[1]
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$personas
            ));
        }
    }else if($_GET["type"] === "data"){
        $persona = PersonaAdo::getId($_GET["dni"]);
        if(is_object($persona)){
            echo json_encode(array(
                "estado" => 1,
                "object"=>$persona
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$persona
            ));
        }        
    }    
    
}elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

}

