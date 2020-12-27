<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/IngresosAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //$search = $_GET['search'];
    $posicionPagina = $_GET['posicionPagina'];
    $filasPorPagina = $_GET['filasPorPagina'];
    $result = IngresosAdo::ListarIngresos(intval($posicionPagina), intval($filasPorPagina));
    if (is_array($result)) {
        print json_encode(array(
            "estado" => 1,
            "data" => $result[0],
            "total"=>$result[1]
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => $result
        ));
    }


    exit();
}
