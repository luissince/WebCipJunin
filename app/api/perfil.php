<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    echo json_encode(Perfil::getPersonaPerfil($idDni));
    exit;
}

class Perfil
{

    public static function getPersonaPerfil($idDni)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP,
            p.Sexo,
            CONVERT(VARCHAR,CAST(ISNULL(p.FechaNac,GETDATE()) AS DATE),103) AS FechaNac,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
            WHERE p.idDNI = ? ");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultPerfil = $cmdValidate->fetch(PDO::FETCH_ASSOC);

            $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
                Foto
                FROM PersonaImagen WHERE idDNI = ?");
            $cmdImage->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdImage->execute();
            $image = "";
            if ($row = $cmdImage->fetch()) {
                $image = base64_encode($row['Foto']);
            }
            return array("state" => 1, "persona" => $resultPerfil, "image" => $image);
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
