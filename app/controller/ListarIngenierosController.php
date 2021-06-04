<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once('../model/ListarIngenierosAdo.php');


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        // $nombres = $_GET['nombres'];
        // $posicionPagina = $_GET['posicionPagina'];
        // $filasPorPagina = $_GET['filasPorPagina'];

        $result = ListarIngenierosAdo::IngenierosNombres($_GET["search"]);
        if (is_array($result)) {
            echo json_encode($result);
        } else {
            echo json_encode(array('id' => 0, 'text' => $result));
        }
    }
}
