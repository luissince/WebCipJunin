<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;
use Mpdf\Tag\Dd;
use PDOException;

class DirectivoAdo
{
    public static function list($opcion, $text, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();

            $comando = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Directivos(?,?,?,?)}");
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
                    "IdDirectivo" => $row->IdDirectivo,
                    "CIP" => $row->CIP,
                    "NumDoc" => $row->NumDoc,
                    "Apellidos" => $row->Apellidos,
                    "Nombres" => $row->Nombres,
                    "FechaInicio" => $row->FechaInicio,
                    "FechaFinal" => $row->FechaFinal,
                    "Estado" => $row->Estado,
                    "Directivo" => $row->Directivo,
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("{CALL Sp_Listar_Directivos_Count(?,?)}");
            $comandoTotal->bindParam(1, $opcion, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $text, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            Response::sendSuccess([
                "directivos" => $array,
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
            $comando = Database::getInstance()->getDb()->prepare("SELECT d.IdDirectivo,
            d.IdDNI,
            p.Apellidos,
            p.Nombres,
            d.FechaInicio,
            d.FechaFinal,
            d.IdTablaTipoDirectivo,
            d.Estado,
            d.Firma
            FROM Directivo AS d  
            INNER JOIN Persona AS p ON d.IdDNI = p.idDNI
            WHERE d.IdDirectivo = ?");
            $comando->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
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

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Directivo(
                IdDirectivo,
                IdDNI,
                FechaInicio,
                FechaFinal,
                Estado,
                Firma,
                IdTablaTipoDirectivo,
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
            $comandoInsert->bindParam(5, $body["Estado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $body["Firma"], PDO::PARAM_STR);
            // $comandoInsert->bindParam(7, $body["Ruta"], PDO::PARAM_STR);
            $comandoInsert->bindParam(7, $body["IdTablaTipoDirectivo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(8, $body["idUsuario"], PDO::PARAM_STR);
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
            Firma = ?,
            IdTablaTipoDirectivo = ?,
            idUsuario = ?,
            FechaUpdate = GETDATE(),
            HoraUpdate = GETDATE()
            WHERE IdDirectivo = ?");
            $comando->bindParam(1, $body["FechaInicio"], PDO::PARAM_STR);
            $comando->bindParam(2, $body["FechaFinal"], PDO::PARAM_STR);
            $comando->bindParam(3, $body["Estado"], PDO::PARAM_STR);
            $comando->bindParam(4, $body["Firma"], PDO::PARAM_STR);
            $comando->bindParam(5, $body["IdTablaTipoDirectivo"], PDO::PARAM_STR);
            $comando->bindParam(6, $body["idUsuario"], PDO::PARAM_STR);
            $comando->bindParam(7, $body["IdDirectivo"], PDO::PARAM_STR);
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

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Directivo WHERE IdDirectivo = ? AND Estado = 1");
            $cmdValidate->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
            $cmdValidate->execute();

            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("No se pudo eliminar el directivo(a) por que tiene estado activo.");
            } else {
                $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Directivo WHERE IdDirectivo = ?");
                $cmdDelete->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
                $cmdDelete->execute();
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se eliminó correctamente el directivo(a).");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            Response::sendError($ex->getMessage());
        }
    }

    public static function listTbDirectorio()
    {
        try {
            $comando = Database::getInstance()->getDb()->prepare("SELECT IdTablaTipoDirectivo,Nombre FROM TablaTipoDirectivo");
            $comando->execute();
            $result = $comando->fetchAll(PDO::FETCH_OBJ);
            Response::sendSuccess($result);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Response::sendError($ex->getMessage());
        }
    }
}
