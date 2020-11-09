<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/ComprobanteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {    
    $result = ComprobanteAdo::getAllComprobates();
    if(is_array($result)){
        print json_encode(array(
            "estado" => 1,
            "data" => $result
        ));
    }else{
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $result
        ));
    }
    exit();
}
