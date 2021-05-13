<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/IngresosAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //$search = $_GET['search'];
    if ($_GET["type"] === "allIngresos") {
        $opcion = $_GET['opcion'];
        $buscar = $_GET['buscar'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFinal = $_GET['fechaFinal'];
        $comprobante = $_GET['comprobante'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = IngresosAdo::ListarIngresos($opcion, $buscar, $fechaInicio, $fechaFinal, intval($comprobante),intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "allCertHabilidad") {
        $opcion = $_GET['opcion'];
        $buscar = $_GET['buscar'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFinal = $_GET['fechaFinal'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = IngresosAdo::ListarCertificadosHabilidad($opcion, $buscar, $fechaInicio, $fechaFinal, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "allCertProyecto") {
        $opcion = $_GET['opcion'];
        $buscar = $_GET['buscar'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFinal = $_GET['fechaFinal'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = IngresosAdo::ListarCertificadosProyecto($opcion, $buscar, $fechaInicio, $fechaFinal,intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) { 
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "allCertObra") {
        $opcion = $_GET['opcion'];
        $buscar = $_GET['buscar'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFinal = $_GET['fechaFinal'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = IngresosAdo::ListarCertificadosObra($opcion, $buscar, $fechaInicio, $fechaFinal,intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1]
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    }
    exit();
}
