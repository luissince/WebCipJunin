<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];

    echo json_encode(CertificadoObra::getCertObraById($idDni));
    exit;
}

class CertificadoObra
{

    public static function getCertObraById($idDni)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cr.Numero, 
            cr.Modalidad, 
            cr.Propietario, 
            cr.Proyecto, 
            cr.Monto, 
            CONCAT(u.Departamento,'-',u.Provincia,'-', u.Distrito) AS Ubigeo, 
            convert(VARCHAR, CAST(cr.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(cr.HastaFecha AS DATE),103) AS HastaFecha, 
            cr.idIngreso, 
            cr.Anulado AS Estado
            FROM CERTResidencia AS cr
            INNER JOIN Ingreso AS i ON i.idIngreso = cr.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cr.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cr.idUbigeo
            WHERE p.idDNI = ?
            ORDER BY i.Fecha DESC,i.Hora DESC");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultData = $cmdValidate->fetchAll(PDO::FETCH_ASSOC);

            return array("state" => 1, "data" => $resultData);
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
// $data = file_get_contents('http://localhost:5000/api/ingresos', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
