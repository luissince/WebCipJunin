<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/NotaCreditoAdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejar petición GET
    $data = json_decode(file_get_contents("php://input"), true);
    //$search = $_GET['search'];
    $result = NotaCreditoAdo::registrarNotaCredito($data);

    if($result === "Insertado"){
        print json_encode(array(
            "estado" => 1,
            "mensaje" => "Se completo correctamente el ingreso.",
        ));
    }else if ($result === "Duplicado") {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ya existe una nota de credito para dicho documento",
        ));
    }else{
        print json_encode(array(
            "estado" => 3,
            "mensaje" => $result,
        ));
    }      
    exit();
}
