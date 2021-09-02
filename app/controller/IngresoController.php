<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/IngresosAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($_GET["type"] === "allIngresos") {
        $opcion = $_GET['opcion'];
        $buscar = $_GET['buscar'];
        $fechaInicio = $_GET['fechaInicio'];
        $fechaFinal = $_GET['fechaFinal'];
        $comprobante = $_GET['comprobante'];
        $estado = $_GET['estado'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = IngresosAdo::ListarIngresos($opcion, $buscar, $fechaInicio, $fechaFinal, intval($comprobante), $estado, intval($posicionPagina), intval($filasPorPagina));
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
        $result = IngresosAdo::ListarCertificadosProyecto($opcion, $buscar, $fechaInicio, $fechaFinal, intval($posicionPagina), intval($filasPorPagina));
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
        $result = IngresosAdo::ListarCertificadosObra($opcion, $buscar, $fechaInicio, $fechaFinal, intval($posicionPagina), intval($filasPorPagina));
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
    } else if ($_GET["type"] == "detalleingreso") {
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
    } else if ($_GET["type"] == "dataComprobante") {
        $result = IngresosAdo::ObtenerIngresoForNotaCredito($_GET["comprobante"]);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "notasCredito" => $result[0],
                "facturados" => $result[1],
                "motivo" => $result[2],
                "ingreso" => $result[3],
                "detalle" => $result[4]
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] == "notificaciones") {
        $result = IngresosAdo::Notificaciones();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result,
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_GET["type"] == "listaNotificaciones") {
        $result = IngresosAdo::ListarNotificaciones(intval($_GET["posicionPagina"]), intval($_GET["filasPorPagina"]));
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result[0],
                "total" => $result[1],
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] == "deleteIngreso") {

        $result = IngresosAdo::EliminarIngreso($_POST["idIngreso"], $_POST["idUsuario"], $_POST["fecha"], $_POST["hora"], $_POST["motivo"]);
        if ($result == "deleted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se anuló el ingreso correctamente."
            ));
        } elseif ($result == "nodata") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "Nose puedo obtener el registro, intente nuevamente porfavor."
            ));
        } elseif ($result == "anulado") {
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
    } else if ($_POST["type"] == "addAfiliacion") {
        $data["colegiado"] = $_POST["colegiado"];
        $data["concepto"] = $_POST["concepto"];
        $data["monto"] = $_POST["monto"];
        $data["usuario"] = $_POST["usuario"];

        $result = IngresosAdo::addAfiliacion($data);

        if ($result == "inserted") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registró la afiliación correctamente."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
