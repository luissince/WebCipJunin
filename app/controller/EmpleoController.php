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

        echo json_encode(EmpleoAdo::getAllEmpleos($text, intval($posicionPagina), intval($filasPorPagina)));
        exit;
    } else if ($_GET["type"] === "id") {
        echo json_encode(EmpleoAdo::idEmpleado($_GET['idEmpleo']));
        exit;
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insert") {

        $empleo["Titulo"] = strtoupper($_POST["Titulo"]);
        $empleo["Descripcion"] = strtoupper($_POST["Descripcion"]);
        $empleo["Empresa"] = strtoupper($_POST["Empresa"]);
        $empleo["Celular"] = $_POST["Celular"];
        $empleo["Telefono"] = $_POST["Telefono"];
        $empleo["Correo"] = $_POST["Correo"];
        $empleo["Direccion"] = strtoupper($_POST["Direccion"]);
        $empleo["Estado"] = $_POST["Estado"];
        $empleo["Tipo"] = $_POST["Tipo"];
        $empleo["idUsuario"] = $_POST["idUsuario"];

        echo json_encode(EmpleoAdo::insertEmpleo($empleo));
        exit;
    } else if ($_POST["type"] === "update") {

        $empleo["Titulo"] = strtoupper($_POST["Titulo"]);
        $empleo["Descripcion"] = strtoupper($_POST["Descripcion"]);
        $empleo["Empresa"] = strtoupper($_POST["Empresa"]);
        $empleo["Celular"] = $_POST["Celular"];
        $empleo["Telefono"] = $_POST["Telefono"];
        $empleo["Correo"] = $_POST["Correo"];
        $empleo["Direccion"] = strtoupper($_POST["Direccion"]);
        $empleo["Estado"] = $_POST["Estado"];
        $empleo["Tipo"] = $_POST["Tipo"];
        $empleo["idUsuario"] = $_POST["idUsuario"];
        $empleo["idEmpleo"] = $_POST["idEmpleo"];

        echo json_encode(EmpleoAdo::updateEmpleo($empleo));
        exit;
    } else if ($_POST["type"] === "delete") {
        $empleo["idEmpleo"] = $_POST["idEmpleo"];
        echo json_encode(EmpleoAdo::deleteEmpleo($empleo));
        exit;
    }
}
