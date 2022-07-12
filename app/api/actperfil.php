<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\PersonaAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idDni = $_GET['idDni'];
    echo json_encode(PersonaAdo::getByIdPersonaToUpdate($idDni));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    
    $result = PersonaAdo::actPersonaById($body);
    if ($result == "update") {
        echo json_encode(array(
            "estado" => 1,
            "message" => "Se actualizaron correctamente los datos",
        ));
    } else {
        echo json_encode(array(
            "estado" => 2,
            "message" => "Error al tratar de actualizar los datos " . $result,
        ));
    }
    
}
