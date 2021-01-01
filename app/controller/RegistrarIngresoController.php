<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/IngresosAdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejar petición GET
    $body = json_decode(file_get_contents("php://input"), true);
    //$search = $_GET['search'];
    $result = IngresosAdo::RegistrarIngresos($body);
    if($result[0] === "inserted"){
        print json_encode(array(
            "estado" => 1,
            "mensaje" => "Se completo correctamento el ingreso.",
            "idIngreso" => $result[1],
            "cerHabilidad" => $result[2],
            "cerObra" => $result[3],
            "cerProyecto" => $result[4],
        ));
    }else{
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $result
        ));
    }        
    exit();
}
