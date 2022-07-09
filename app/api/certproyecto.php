<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\DataBase\Database;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];

    echo json_encode(CertificadoObra::getCertProyectoById($idDni));
    exit;
}

class CertificadoObra
{

    public static function getCertProyectoById($idDni)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cp.Numero, 
            cp.Modalidad, 
            cp.Propietario, 
            cp.Proyecto, 
            cp.Monto, 
            CONCAT(U.Departamento,'-',U.Provincia,'-', u.Distrito) AS Ubigeo, 
            ISNULL(cp.Adicional1,'N/D') AS Adicional1, 
            ISNULL(cp.Adicional2,'N/D') AS Adicional2, 
            convert(VARCHAR, CAST(cp.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(cp.HastaFecha AS DATE),103) AS HastaFecha,
            cp.idIngreso, 
            cp.Anulado AS Estado  
            FROM CERTProyecto AS cp
            INNER JOIN Ingreso AS i ON i.idIngreso = cp.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = cp.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cp.idUbigeo
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
