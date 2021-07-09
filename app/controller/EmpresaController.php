<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/EmpresaAdo.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];

        $result = EmpresaAdo::getAllEmpresas($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "empresas" => $result[0],
                "total" => $result[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    } else if ($_GET["type"] === "updateEmpresa") {
        $idEmpresa = $_GET['idEmpresa'];

        $result = EmpresaAdo::getDataByIdEmpresa($idEmpresa);
        if (is_object($result)) {
            echo json_encode(array(
                "estado" => 1,
                "empresa" => $result,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "addEmpresa") {

        $data["IdEmpresa"] = $_POST["idEmpresa"];
        $data["Ruc"] = $_POST["ruc"];
        $data["Nombre"] = $_POST["nombre"];
        $data["Direccion"] = $_POST["direccion"];
        $data["Telefono"] = $_POST["telefono"];
        $data["Web"] = $_POST["web"];
        $data["Email"] = $_POST["email"];

        $result = EmpresaAdo::RegistrarEmpresa($data);
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "mensaje" => "Se completo correctamento el ingreso.",
                "data"=>$result
            ));
        } else if ($result === "Duplicado") {
            echo json_encode(array(
                "estado" => 2,
                "mensaje" => "La empresa " . $data["Nombre"] . "(RUC:" . $data["Ruc"] . ") ya se encuentra registrada",
            ));
        } else if ($result === "Actualizado") {
            echo json_encode(array(
                "estado" => 3,
                "mensaje" => "La empresa con el ruc " . $data["Nombre"] . "(RUC:" . $data["Ruc"] . ") se actualizó correctamente",
            ));
        } else {
            echo json_encode(array(
                "estado" => 4,
                "mensaje" => $result
            ));
        }
        // exit();
    } else if ($_POST["type"] === 'deleteEmpresa') {
        $empresa["idEmpresa"] = $_POST['idEmpresa'];
        $result = EmpresaAdo::deleteEmpresa($empresa);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos",
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de eliminar los datos " . $result,
            ));
        }
    }
}
