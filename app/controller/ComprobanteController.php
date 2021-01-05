<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/ComprobanteAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "comprobante") {
        $result = ComprobanteAdo::getAllComprobates();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "empresaPersona") {
        $result = ComprobanteAdo::getAllEmpresaPersona();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "listaComprobantes") {

        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];

        $result = ComprobanteAdo::getListComprobantes($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1],
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "updateComprobante") {
        $idComprobante = $_GET['idComprobante'];

        $result = ComprobanteAdo::getDataByIdComprobante($idComprobante);
        if (is_object($result)) {
            echo json_encode(array(
                "estado" => 1,
                "Comprobante" => $result,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "addComprobante") {

        $data["IdComprobante"] = $_POST["idComprobante"];
        $data["Nombre"] = $_POST["nombre"];
        $data["Serie"] = $_POST["serie"];
        $data["Numeracion"] = $_POST["numeracion"];
        $data["CodigoAlterno"] = $_POST["codigoAlterno"];
        $data["Predeterminado"] = $_POST["predeterminado"];
        $data["Estado"] = $_POST["estado"];
        $data["UsaRuc"] = $_POST["usaRuc"];

        $result = ComprobanteAdo::RegistrarComprobante($data);
        if ($result === "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "mensaje" => "Se completo correctamento el ingreso.",
            ));
        } else if ($result === "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "mensaje" => "El comprobante ya se encuentra registrado",
            ));
        } else if ($result === "Actualizado") {
            echo json_encode(array(
                "estado" => 3,
                "mensaje" => "El comprobante se  actualizó correctamente",
            ));
        } else {
            echo json_encode(array(
                "estado" => 4,
                "mensaje" => $result
            ));
        }
        // exit();
    }
}
