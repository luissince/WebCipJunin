<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $usuario = $body["usuario"];
    $clave = $body["clave"];

    echo json_encode(Login::getUsurioLogin($usuario, $clave));
    exit;
}

class Login
{

    public static function getUsurioLogin($usuario, $clave)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT  
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP,
            p.Clave
            FROM Persona AS p
            WHERE p.CIP = ? AND  p.CIP = ?");
            $cmdValidate->bindParam(1, $usuario, PDO::PARAM_STR);
            $cmdValidate->bindParam(2, $clave, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultUsuario = $cmdValidate->fetchObject();
            if ($resultUsuario) {
                return array("state" => 1, "persona" => $resultUsuario);
                // if (password_verify($clave, $resultUsuario->Clave)) {
                //     return array("state" => 1, "persona" => $resultUsuario);
                // } else {
                //     return array(
                //         'state' => '0',
                //         'message' => 'Usuario o contraseña incorrectas.',
                //     );
                // }
            } else {
                return array("state" => 2, "message" => "El usuario o contraseña son incorrectas.");
            }
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }
}


// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
// header('Content-Type: application/json; charset=UTF-8');
// $body = json_decode(file_get_contents("php://input"), true);
// $postdata = http_build_query(
//     array(
//         'usuario' => $body["usuario"],
//         'clave' => $body["clave"]
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
// $data = file_get_contents('http://localhost:5000/api/login', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
