<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\PersonaAdo;

require __DIR__ . './../src/autoload.php';

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    $mes = $body["mes"];
    $yearCurrentView = $body["yearCurrentView"];
    $monthCurrentView = $body["monthCurrentView"];
    echo json_encode(PersonaAdo::getPersonaInformacion($idDni, $mes, $yearCurrentView, $monthCurrentView));
    exit;
}


// $body = json_decode(file_get_contents("php://input"), true);
// $postdata = http_build_query(
//     array(
//         'idDni' => $body["idDni"],
//     )
// );
// $opts = array(
//     'http' =>
//     array(
//         'method'  => 'POST',
//         'header'  => 'Content-Type: application/x-www-form-urlencoded',
//         'content' => $postdata
//     )
// );

// $context  = stream_context_create($opts);
// $data = file_get_contents('http://localhost:5000/api/informacion', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
