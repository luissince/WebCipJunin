<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\EmpleoAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $text = $_GET['text'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $empleo = EmpleoAdo::getAllEmpleos ($text, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($empleo)) {
            echo json_encode(array(
                "estado" => 1,
                "empleos" => $empleo[0],
                "total" => $empleo[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $empleo
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insert") {
        
        $empleo["Titulo"] = strtoupper($_POST["Titulo"]);
        $empleo["Descripcion"] = strtoupper($_POST["Descripcion"]);
        $empleo["Empresa"] = strtoupper($_POST["Descripcion"]);
        $empleo["Celular"] = $_POST["Celular"];
        $empleo["Telefono"] = $_POST["Telefono"];
        $empleo["Correo"] = $_POST["Correo"];
        $empleo["Direccion"] = strtoupper($_POST["Direccion"]);
        $empleo["Estado"] = $_POST["Estado"];
        $empleo["Tipo"] = $_POST["Tipo"];
        $empleo["idUsuario"] = $_POST["idUsuario"];

        $result = EmpleoAdo::insertEmpleo($empleo);

        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de registrar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "update") {

        $empleo["Titulo"] = strtoupper($_POST["Titulo"]);
        $empleo["Descripcion"] = strtoupper($_POST["Descripcion"]);
        $empleo["Empresa"] = strtoupper($_POST["Descripcion"]);
        $empleo["Celular"] = $_POST["Celular"];
        $empleo["Telefono"] = $_POST["Telefono"];
        $empleo["Correo"] = $_POST["Correo"];
        $empleo["Direccion"] = strtoupper($_POST["Direccion"]);
        $empleo["Estado"] = $_POST["Estado"];
        $empleo["Tipo"] = $_POST["Tipo"];
        $empleo["idUsuario"] = $_POST["idUsuario"];

        $result = EmpleoAdo::updateEmpleo($empleo);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "delete") {

        $empleo["idEmpleo"] = $_POST["idEmpleo"];

        $result = EmpleoAdo::deleteEmpleo($empleo);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminó correctamente la oferta laboral."
            ));
        } else if ($result == "activo") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se pudo eliminar la oferta laboral por que tiene estado activo"
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
