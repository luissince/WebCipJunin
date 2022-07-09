<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\CuotaAdo;

require __DIR__ . './../src/autoload.php';

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    $mes = $body["mes"];
    $yearCurrentView = $body["yearCurrentView"];
    $monthCurrentView = $body["monthCurrentView"];
    echo json_encode(CuotaAdo::getCuotas($idDni, $mes, $yearCurrentView, $monthCurrentView));
    exit;
}