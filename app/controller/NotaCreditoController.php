<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/NotaCreditoAdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] == "all") {
        $opcion = $_GET["opcion"];
        $buscar = $_GET["buscar"];
        $fechaInicio = $_GET["fechaInicio"];
        $fechaFinal = $_GET["fechaFinal"];
        $posicionPagina = $_GET["posicionPagina"];
        $filasPorPagina = $_GET["filasPorPagina"];
        $result = NotaCreditoAdo::ListarNotasCredito($opcion, $buscar, $fechaInicio,   $fechaFinal, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "message" =>   $result,
            ));
        }
    } else if ($_GET["type"] == "detalleNotaCreedito") {
        $result = NotaCreditoAdo::DetalleNotaCreditoById($_GET["idNotaCredito"]);
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "detalles" => $result,
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "message" =>   $result,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    if ($body["type"] == "registro") {
        $result = NotaCreditoAdo::registrarNotaCredito($body);
        if ($result === "Insertado") {
            print json_encode(array(
                "estado" => 1,
                "message" => "Se registró correctamente la nota de crédito..",
            ));
        } else if ($result === "anulado") {
            print json_encode(array(
                "estado" => 2,
                "message" => "El ingreso se encuentra anulado, no se puede realizar la nota de crédito.",
            ));
        } else if ($result == "nota") {
            print json_encode(array(
                "estado" => 3,
                "message" => "El ingreso ya tiene asociado una nota de crédito.",
            ));
        } else {
            print json_encode(array(
                "estado" => 0,
                "message" => $result,
            ));
        }
    }

    exit();
}
