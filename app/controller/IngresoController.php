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
        }elseif($result == "nodata"){
            echo json_encode(array(
                "estado" => 3,
                "message" => "Nose puedo obtener el registro, intente nuevamente porfavor."
            ));
        }
        elseif($result == "anulado"){
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
    } else if($_POST["type"] == "deleteCertHabilidad"){
        $result = IngresosAdo::EliminarCertHabilidad($_POST["idIngreso"],$_POST["idUsuario"],$_POST["fecha"],$_POST["hora"],$_POST["motivo"]);
        if ($result == "deleted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se anuló el certificado correctamente."
            ));
        }elseif($result == "anulado"){
            echo json_encode(array(
                "estado" => 2,
                "message" => "El certificado ya se encuentra anulado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if($_POST["type"] == "deleteCertObra"){
        $result = IngresosAdo::EliminarCertObra($_POST["idIngreso"],$_POST["idUsuario"],$_POST["fecha"],$_POST["hora"],$_POST["motivo"]);
        if ($result == "deleted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se anuló el certificado correctamente."
            ));
        }elseif($result == "anulado"){
            echo json_encode(array(
                "estado" => 2,
                "message" => "El certificado ya se encuentra anulado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if($_POST["type"] == "deleteCertProyecto"){
        $result = IngresosAdo::EliminarCertProyecto($_POST["idIngreso"],$_POST["idUsuario"],$_POST["fecha"],$_POST["hora"],$_POST["motivo"]);
        if ($result == "deleted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se anuló el certificado correctamente."
            ));
        }elseif($result == "anulado"){
            echo json_encode(array(
                "estado" => 2,
                "message" => "El certificado ya se encuentra anulado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
