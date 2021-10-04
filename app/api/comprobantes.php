<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    echo json_encode(Cuotas::allComprobantes($idDni));
    exit;
}

class Cuotas
{

    public static function allComprobantes($idDni)
    {
        try {
            $array = array();
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante 
            WHERE Estado = 1 AND ComprobanteAfiliado = 2 AND (Destino = 1 OR Destino = 3)");
            $comandoConcepto->execute();

            while ($row = $comandoConcepto->fetch(PDO::FETCH_OBJ)) {
                array_push($array, array(
                    "IdTipoComprobante" => $row->IdTipoComprobante,
                    "Nombre" => $row->Nombre,
                    "Serie" => $row->Serie,
                    "Predeterminado" => $row->Predeterminado,
                    "UsarRuc" => $row->UsarRuc
                ));
            }

            $direccion = Database::getInstance()->getDb()->prepare("SELECT TOP 1 d.Direccion FROM Persona AS p
            INNER JOIN Direccion AS d
            ON p.idDNI = d.idDNI
            WHERE p.idDNI = ?");
            $direccion->bindParam(1, $idDni, PDO::PARAM_STR);
            $direccion->execute();

            $ubicacion = "";
            if ($row = $direccion->fetch(PDO::FETCH_OBJ)) {
                $ubicacion = $row->Direccion;
            }

            return array(
                'status' => 1,
                'data' => $array,
                'ubicacion' => $ubicacion
            );
        } catch (Exception $ex) {
            return array("status" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }
}
