<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use Exception;
use PDOException;
use SysSoftIntegra\Src\Response;

class CapituloAdo
{

    public function construct()
    {
    }

    public static function list($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.Capitulo, 
            c.idCapitulo, ISNULL(e.Especialidad,'No tiene asignado ninguna especialidad') AS Especialidad, ISNULL(e.idEspecialidad,-1) AS idEspecialidad
            FROM Especialidad AS e RIGHT JOIN Capitulo AS c ON c.idCapitulo = e.idCapitulo
            WHERE c.Capitulo LIKE CONCAT('%', ?,'%') OR e.Especialidad LIKE CONCAT('%', ?,'%')
            ORDER BY Capitulo ASC
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY");
            $comando->bindParam(1, $nombres, PDO::PARAM_STR);
            $comando->bindParam(2, $nombres, PDO::PARAM_STR);
            $comando->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comando->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "Id" => $count + $posicionPagina,
                    "idCapitulo" => $row["idCapitulo"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Capitulo" => $row["Capitulo"],
                    "Especialidad" => $row["Especialidad"]

                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Especialidad AS e RIGHT JOIN Capitulo 
            AS c ON c.idCapitulo = e.idCapitulo 
            WHERE Capitulo LIKE concat(?,'%') OR Especialidad LIKE concat(?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            Response::sendSuccess([
                "especialidades" => $array,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function getAllDistinctCapitulos()
    {
        try {
            $comandoCapitulo = Database::getInstance()->getDb()->prepare("SELECT DISTINCT idCapitulo, Capitulo FROM Capitulo");
            $comandoCapitulo->execute();
            $resultado = $comandoCapitulo->fetchAll();
            return Response::sendSuccess($resultado);
        } catch (Exception $ex) {
            return Response::sendError($ex->getMessage());
        }
    }

    public static function getAllDistinctEspecialidades()
    {
        try {
            $comandoEspecialidad = Database::getInstance()->getDb()->prepare("SELECT DISTINCT idEspecialidad,Especialidad from Especialidad");
            $comandoEspecialidad->execute();
            $resultado = $comandoEspecialidad->fetchAll();
            return $resultado;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllEspecialidadesByCapitulo($idCapitulo)
    {
        try {
            $comandoEspecialidad = Database::getInstance()->getDb()->prepare("SELECT DISTINCT idEspecialidad,Especialidad from Especialidad WHERE idCapitulo = ?");
            $comandoEspecialidad->bindParam(1, $idCapitulo, PDO::PARAM_INT);
            $comandoEspecialidad->execute();
            $resultado = $comandoEspecialidad->fetchAll();
            Response::sendSuccess($resultado);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function getAllCountCapAndEsp()
    {
        try {
            $comandoEsp = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Especialidad");
            $comandoCap = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Capitulo");
            $comandoEsp->execute();
            $comandoCap->execute();

            $resulCountCapAndEsp = [
                "Especialidad" => $comandoEsp->fetchColumn(),
                "Capitulo" => $comandoCap->fetchColumn()
            ];
            return $resulCountCapAndEsp;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insertCapitulo($capitulos)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Capitulo WHERE Capitulo = UPPER(?)");
            $comandSelect->bindParam(1, $capitulos["capitulo"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("El capítulo " . $capitulos["capitulo"] . " ya se encuentra registrado.");
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Capitulo (Capitulo) VALUES (UPPER(?))");
                $comandoInsert->bindParam(1, $capitulos["capitulo"], PDO::PARAM_STR);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se registró correctamente el capítulo.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function insertEspecialidad($especialidad)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoSelect =  Database::getInstance()->getDb()->prepare("SELECT * FROM Especialidad WHERE Especialidad = UPPER(?)");
            $comandoSelect->bindParam(1, $especialidad["especialidad"], PDO::PARAM_STR);
            $comandoSelect->execute();
            if ($comandoSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("La especialidad " . $especialidad["especialidad"] . " ya se encuentra registrado.");
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Especialidad (idCapitulo, Especialidad) VALUES (?,?)");
                $comandoInsert->bindParam(1, $especialidad["capitulo"], PDO::PARAM_INT);
                $comandoInsert->bindParam(2, $especialidad["especialidad"], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se registró correctamente la especialidad.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function updateCapitulo($capitulo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Capitulo WHERE idCapitulo <> ? AND Capitulo = UPPER(?)");
            $comandSelect->bindParam(1, $capitulo["idCapitulo"], PDO::PARAM_INT);
            $comandSelect->bindParam(2, $capitulo["Capitulo"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("El capitulo " . $capitulo["Capitulo"] . " ya se encuentra registrado.");
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Capitulo SET Capitulo = UPPER(?) WHERE idCapitulo = ?");
                $comandoInsert->bindParam(1, $capitulo["Capitulo"], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $capitulo["idCapitulo"], PDO::PARAM_INT);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se actualizaron correctamente el capítulo.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function updateEspecialidad($especialidad)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Especialidad WHERE idEspecialidad <> ? AND UPPER(Especialidad) = UPPER(?)");
            $comandSelect->bindParam(1, $especialidad["idEspecialidad"], PDO::PARAM_STR);
            $comandSelect->bindParam(2, $especialidad["Especialidad"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("La especialidad " . $especialidad["Especialidad"] . " ya se encuentra registrado.");
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Especialidad SET idCapitulo = ?, Especialidad = ? WHERE idEspecialidad = ?");
                $comandoInsert->bindParam(1, $especialidad["idCapitulo"], PDO::PARAM_INT);
                $comandoInsert->bindParam(2, $especialidad["Especialidad"], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $especialidad["idEspecialidad"], PDO::PARAM_INT);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se actualizaron correctamente la especialidad.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function deleteCapitulo($idCapitulo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Especialidad WHERE idCapitulo = ?");
            $cmdValidate->bindParam(1, $idCapitulo, PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("No se puede elimar el capítulo porque tiene ligado especialidades.");
            } else {
                $cmdCapitulo = Database::getInstance()->getDb()->prepare("DELETE FROM Capitulo WHERE idCapitulo = ?");
                $cmdCapitulo->bindParam(1, $idCapitulo, PDO::PARAM_STR);
                $cmdCapitulo->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se eliminó correctamente el capítulo.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function deleteEspecialidad($idEspecialidad)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Colegiatura WHERE idEspecialidad = ?");
            $cmdValidate->bindParam(1, $idEspecialidad, PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("No se puede elimar la especialidad porque esta ligada a una colegiatura.");
            } else {
                $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Especialidad WHERE idEspecialidad = ?");
                $comandSelect->bindParam(1, $idEspecialidad, PDO::PARAM_STR);
                $comandSelect->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se eliminó correctamente la especialidad.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }
}
