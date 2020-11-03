<?php

date_default_timezone_set('America/Lima');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../model/ConceptoAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if($_GET["type"] === "alldata"){
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $conceptos = ConceptoAdo::getAll($nombres,intval($posicionPagina),intval($filasPorPagina));
        if(is_array($conceptos)){
            echo json_encode(array(
                "estado" => 1,
                "conceptos"=>$conceptos[0],
                "total"=>$conceptos[1]
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$conceptos
            ));
        }
    } else if($_GET["type"] === "data"){
        $concepto = ConceptoAdo::getId($_GET["idConcepto"]);
        if(is_object($concepto)){
            echo json_encode(array(
                "estado" => 1,
                "object"=>$concepto
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message"=>$concepto
            ));
        }        
    } 
} else if($_SERVER['REQUEST_METHOD'] == 'POST'){

}