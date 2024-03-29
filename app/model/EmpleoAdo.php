<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;

class EmpleoAdo
{

    public function construct()
    {
    }

    public static function getAllEmpleos($text, $posicionPagina, $filasPorPagina)
    {
        try {

            $arrayEmpleo = array();
            $comandoEmpleo = Database::getInstance()->getDb()->prepare("SELECT 
            idEmpleo, Titulo, Descripcion, Empresa, Celular, Telefono, Correo, Direccion, convert(VARCHAR, CAST(Fecha AS DATE),103) AS Fecha, Hora, Estado, Tipo 
            FROM Empleo
            where Titulo like concat('%', ?,'%') or Descripcion like concat('%', ?,'%')
            order by Fecha desc, Hora desc
            offset ? rows fetch next ? rows only");
            $comandoEmpleo->bindParam(1, $text, PDO::PARAM_STR);
            $comandoEmpleo->bindParam(2, $text, PDO::PARAM_STR);
            $comandoEmpleo->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comandoEmpleo->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comandoEmpleo->execute();
            $count = 0;
            while ($row = $comandoEmpleo->fetch()) {
                $count++;
                array_push($arrayEmpleo, array(
                    "Id" => $count + $posicionPagina,
                    "idEmpleo" => $row["idEmpleo"],
                    "Titulo" => $row["Titulo"],
                    "Descripcion" => $row["Descripcion"],
                    "Empresa" => $row["Empresa"],
                    "Celular" => $row["Celular"],
                    "Telefono" => $row["Telefono"],
                    "Correo" => $row["Correo"],
                    "Direccion" => $row["Direccion"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"],
                    "Estado" => $row["Estado"],
                    "Tipo" => $row["Tipo"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Empleo 
            where Titulo like concat('%',?,'%') or Descripcion like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $text, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            return Response::sendSuccess([
                "empleos" => $arrayEmpleo,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            return Response::sendError($ex->getMessage());
        }
    }

    public static function insertEmpleo($empleo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Empleo 
            (Titulo, Descripcion, Empresa, Celular, Telefono, Correo, Direccion, Fecha, Hora, Estado, Tipo, idUsuario) 
            VALUES (UPPER(?), UPPER(?), UPPER(?), ?,?,?, UPPER(?), GETDATE(), GETDATE(), ?,?,?)");
            $comandoInsert->bindParam(1, $empleo["Titulo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $empleo["Descripcion"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $empleo["Empresa"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $empleo["Celular"], PDO::PARAM_STR);
            $comandoInsert->bindParam(5, $empleo["Telefono"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $empleo["Correo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(7, $empleo["Direccion"], PDO::PARAM_STR);
            $comandoInsert->bindParam(8, $empleo["Estado"], PDO::PARAM_BOOL);
            $comandoInsert->bindParam(9, $empleo["Tipo"], PDO::PARAM_INT);
            $comandoInsert->bindParam(10, $empleo["idUsuario"], PDO::PARAM_INT);

            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return Response::sendSave("Se insertaron correctamente los datos.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return Response::sendError($ex->getMessage());
        }
    }

    public static function idEmpleado($idEmpleo)
    {
        try {
            $cmdEmpleo = Database::getInstance()->getDb()->prepare("SELECT * from Empleo WHERE idEmpleo = ?");
            $cmdEmpleo->bindParam(1, $idEmpleo, PDO::PARAM_INT);
            $cmdEmpleo->execute();
            $resultEmpleo = $cmdEmpleo->fetchObject();
            return Response::sendSuccess(["object" => $resultEmpleo]);
        } catch (Exception $ex) {
            return Response::sendError($ex->getMessage());
        }
    }

    public static function updateEmpleo($empleo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoUpdate = Database::getInstance()->getDb()->prepare("UPDATE Empleo SET 
            Titulo = UPPER(?), 
            Descripcion = UPPER(?),
            Empresa = UPPER(?),
            Celular = ?,
            Telefono = ?,
            Correo = ?,
            Direccion = UPPER(?),
            Estado = ?,
            Tipo = ?,
            idUsuario = ?
            WHERE idEmpleo = ?");

            $comandoUpdate->bindParam(1, $empleo["Titulo"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(2, $empleo["Descripcion"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(3, $empleo["Empresa"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(4, $empleo["Celular"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(5, $empleo["Telefono"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(6, $empleo["Correo"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(7, $empleo["Direccion"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(8, $empleo["Estado"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(9, $empleo["Tipo"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(10, $empleo["idUsuario"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(11, $empleo["idEmpleo"], PDO::PARAM_INT);

            $comandoUpdate->execute();
            Database::getInstance()->getDb()->commit();
            return Response::sendSave("Se actualizaron correctamente los datos");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return Response::sendError($ex->getMessage());
        }
    }

    public static function deleteEmpleo($empleo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Empleo WHERE idEmpleo = ? AND Estado = 1");
            $cmdValidate->bindParam(1, $empleo["idEmpleo"], PDO::PARAM_INT);
            $cmdValidate->execute();

            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return Response::sendClient("No se pudo eliminar la oferta laboral por que tiene estado activo.");
            } else {

                $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Empleo WHERE idEmpleo = ?");
                $cmdDelete->bindParam(1, $empleo["idEmpleo"], PDO::PARAM_INT);
                $cmdDelete->execute();
                Database::getInstance()->getDb()->commit();
                return Response::sendSave("Se eliminó correctamente la oferta laboral.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return Response::sendError($ex->getMessage());
        }
    }
}
