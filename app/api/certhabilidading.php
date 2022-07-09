<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\DataBase\Database;

require __DIR__ . './../src/autoload.php';

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $request = (object)$body;
    echo json_encode(CerthHabilidadIng::certicado($request));
    exit;
}


class CerthHabilidadIng
{
    public static function certicado($request)
    {
        try {
            $user = Database::getInstance()->getDb()->prepare('SELECT * FROM Persona WHERE idDNI = ?');
            $user->execute(array($request->idDNI));

            $resultIngeniero = $user->fetchObject();
            if ($resultIngeniero) {
                if ($resultIngeniero->Condicion == "T") {
                    $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 1");
                    $cmdConcepto->execute();
                    $resultConcepto = $cmdConcepto->fetchObject();
                    if (!$resultConcepto) {
                        throw new Exception('No se encontro ningún concepto para obtener.');
                    }
                } else {
                    $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 0");
                    $cmdConcepto->execute();
                    $resultConcepto = $cmdConcepto->fetchObject();
                    if (!$resultConcepto) {
                        throw new Exception('No se encontro ningún concepto para obtener.');
                    }
                }

                $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT c.idColegiado, c.idEspecialidad, e.Especialidad FROM Colegiatura AS c 
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?");
                $cmdEspecialidad->execute(array($request->idDNI));
                $resultEspecialidad = $cmdEspecialidad->fetchAll(PDO::FETCH_OBJ);

                $arrayEspecialidades = array();
                foreach ($resultEspecialidad as $row) {
                    array_push($arrayEspecialidades, array(
                        "idColegiado" => $row->idColegiado,
                        "idEspecialidad" => $row->idEspecialidad,
                        "Especialidad" => $row->Especialidad
                    ));
                }

                if (empty($arrayEspecialidades)) {
                    throw new Exception('Error en cargar en las espcialidad(es).');
                }

                return array(
                    "state" => 1,
                    "data" => $resultConcepto,
                    "especialidades" => $arrayEspecialidades,
                    "tipoColegiado" => $resultIngeniero->Condicion
                );
            } else {
                return array(
                    'state' => 2,
                    'message' => "Se pudo validar los datos, intente nuevamente en un parte de minutos.",
                );
            }
        } catch (PDOException $e) {
            Database::getInstance()->getDb()->rollBack();
            return array(
                'state' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            );
        }
    }
}
