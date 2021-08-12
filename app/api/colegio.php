<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body = json_decode(file_get_contents("php://input"), true);
    echo json_encode(Colegio::getEmpresa());
    exit;
}

class Colegio
{

    public static function getEmpresa()
    {
        try {
            $cmdEmpresa = Database::getInstance()->getDb()->prepare("SELECT 
            TOP 1 
            NumeroDocumento,
            NombreComercial,
            RazonSocial,
            Domicilio,
            Telefono,
            Celular,
            Horario,
            PaginaWeb,
            Email
            FROM Empresa");
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();
            return array("state" => 1, "empresa" => $resultEmpresa);
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }
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
// $data = file_get_contents('http://localhost:5000/api/perfil', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
