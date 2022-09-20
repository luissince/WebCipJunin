<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;
use PDOException;

class PresidenteAdo
{
    public static function list($opcion, $text, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Presidentes(?,?,?,?)}");
            $comando->bindParam(1, $opcion, PDO::PARAM_STR);
            $comando->bindParam(2, $text, PDO::PARAM_STR);
            $comando->bindParam(3, $posicionPagina, PDO::PARAM_STR);
            $comando->bindParam(4, $filasPorPagina, PDO::PARAM_STR);
            $comando->execute();

            $count = 0;
            while ($row = $comando->fetch(PDO::FETCH_OBJ)) {
                $count++;
                array_push($array, array(
                    "Id" => $count + $posicionPagina,
                    "IdPresidente" => $row->IdPresidente,
                    "CIP" => $row->CIP,
                    "NumDoc" => $row->NumDoc,
                    "Apellidos" => $row->Apellidos,
                    "Nombres" => $row->Nombres,
                    "FechaInicio" => $row->FechaInicio,
                    "FechaFinal" => $row->FechaFinal,
                    "Estado" => $row->Estado,
                    "Capitulo" => $row->Capitulo,
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Presidentes_Count(?,?)}");
            $comandoTotal->bindParam(1, $opcion, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $text, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            Response::sendSuccess([
                "presidentes" => $array,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function id($body)
    {
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT pr.IdPresidente,
            pr.IdDNI,
            p.Apellidos,
            p.Nombres,
            pr.FechaInicio,
            pr.FechaFinal,
            pr.idCapitulo,
            pr.Estado
            FROM Presidente AS pr  
            INNER JOIN Persona AS p ON pr.IdDNI = p.idDNI
            WHERE pr.IdPresidente = ?");
            $comando->bindParam(1, $body["IdPresidente"], PDO::PARAM_INT);
            $comando->execute();
            Response::sendSuccess($comando->fetchObject());
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function insert($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $idDirectivo = 0;
            $validate = Database::getInstance()->getDb()->prepare("SELECT IdDirectivo FROM Directivo");
            $validate->execute();
            $listDirectivo = $validate->fetchAll(PDO::FETCH_CLASS);
            if ($listDirectivo) {
                $currentValue = max($listDirectivo);
                $idDirectivo = $currentValue->IdDirectivo + 1;
            } else {
                $idDirectivo = 1;
            }

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Presidente(
                IdPresidente,
                IdDNI,
                FechaInicio,
                FechaFinal,
                idCapitulo,
                Estado,
                idUsuario,
                FechaRegistro,
                HoraRegistro,
                FechaUpdate,
                HoraUpdate 
            ) VALUES(?,?,?,?,?,?,?,GETDATE(),GETDATE(),GETDATE(),GETDATE())");
            $comandoInsert->bindParam(1, $idDirectivo, PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $body["IdDNI"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $body["FechaInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $body["FechaFinal"], PDO::PARAM_STR);
            $comandoInsert->bindParam(5, $body["IdCapitulo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $body["Estado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(7, $body["idUsuario"], PDO::PARAM_STR);
            $comandoInsert->execute();

            Database::getInstance()->getDb()->commit();
            Response::sendSave("Los datos se registraron correctamente.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        }
    }

    public static function update($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comando = Database::getInstance()->getDb()->prepare("UPDATE Directivo SET 
            FechaInicio = ?,
            FechaFinal = ?,
            Estado = ?,
            Puesto = ?,
            idUsuario = ?,
            FechaUpdate = GETDATE(),
            HoraUpdate = GETDATE()
            WHERE IdDirectivo = ?");
            $comando->bindParam(1, $body["FechaInicio"], PDO::PARAM_STR);
            $comando->bindParam(2, $body["FechaFinal"], PDO::PARAM_STR);
            $comando->bindParam(3, $body["Estado"], PDO::PARAM_STR);
            $comando->bindParam(4, $body["Puesto"], PDO::PARAM_STR);
            $comando->bindParam(5, $body["idUsuario"], PDO::PARAM_STR);
            $comando->bindParam(6, $body["IdDirectivo"], PDO::PARAM_STR);
            $comando->execute();

            Database::getInstance()->getDb()->commit();
            Response::sendSave("Los datos se actualizon correctamente.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        }
    }

    public static function delete($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Presidente WHERE IdPresidente = ? AND Estado = 1");
            $cmdValidate->bindParam(1, $body["IdPresidente"], PDO::PARAM_INT);
            $cmdValidate->execute();

            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("No se pudo eliminar el presidente por que tiene estado activo.");
            } else {
                $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Presidente WHERE IdPresidente = ?");
                $cmdDelete->bindParam(1, $body["IdPresidente"], PDO::PARAM_INT);
                $cmdDelete->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se eliminó correctamente el presidente.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        }
    }
}