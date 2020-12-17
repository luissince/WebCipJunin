<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/RolAdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    if ($body["type"] == "updateModulo") {
        $modulos = RolAdo::updateModulo($body);
        if ($modulos == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamento los cambios."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $modulos
            ));
        }
    }
    exit();
}
