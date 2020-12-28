<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/IngresosAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
 
    if($_GET["type"] == "detalleingreso"){
        $datalle = IngresosAdo::DetalleIngresoPorIdIngreso($_GET["idIngreso"]);
        if (is_array($datalle)) {
            echo json_encode(array(
                "estado" => 1,
                "detalles" => $datalle
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $datalle
            ));
        }
    }

}else if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($_POST["type"] == "deleteIngreso"){
        $result = IngresosAdo::EliminarIngreso($_POST["idIngreso"],$_POST["idUsuario"],$_POST["fecha"],$_POST["hora"],$_POST["motivo"]);
        if ($result == "deleted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se anuló el ingreso correctamente."
            ));
        }elseif($result == "anulado"){
            echo json_encode(array(
                "estado" => 2,
                "message" => "El comprobante ya se encuentra anulado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
