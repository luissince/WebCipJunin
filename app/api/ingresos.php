<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];

    echo json_encode(Ingresos::getIngresosById($idDni));
    exit;
}

class Ingresos
{

    public static function getIngresosById($idDni)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,
            i.Hora,
            tc.Nombre as Comprobante,
            i.Serie, 
            i.NumRecibo,
            i.Estado,
            p.CIP,
            case when not e.IdEmpresa is null then 'RUC' else 'DNI' end as NombreDocumento,
            isnull(e.NumeroRuc,p.idDNI) as NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ', p.Nombres)) as Persona,
            sum(d.Monto) AS Total
            FROM Ingreso AS i 
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante
            INNER JOIN Persona AS p ON i.idDNI = p.idDNI
            LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN Detalle AS d ON d.idIngreso = i.idIngreso
            WHERE
            p.idDNI = ?
            GROUP BY 
            i.idIngreso,
            i.Fecha,
            i.Hora,
            i.Serie,
            i.NumRecibo,
            i.Estado,
            p.CIP,
            p.idDNI,
            p.Apellidos,
            p.Nombres,
            e.NumeroRuc,
            e.Nombre,
            e.IdEmpresa,
            tc.Nombre
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
