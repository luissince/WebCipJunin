<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;
use DateTime;
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
            pr.Estado,
            pr.Ruta
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

            $IdPresidente = 0;
            $validate = Database::getInstance()->getDb()->prepare("SELECT IdPresidente FROM Presidente");
            $validate->execute();
            $listPresidente = $validate->fetchAll(PDO::FETCH_CLASS);
            if ($listPresidente) {
                $currentValue = max($listPresidente);
                $IdPresidente = $currentValue->IdPresidente + 1;
            } else {
                $IdPresidente = 1;
            }

            $fileName = "";

            if ($body["imagen"] != "") {
                $fileDir = "../resources/images";
                if (!file_exists($fileDir)) {
                    mkdir($fileDir, 0777, true);
                } else {
                    chmod($fileDir, 0777);
                }

                $bin = base64_decode($body["imagen"]);

                $date = new DateTime("now");
                $fileName = $date->format("Ymd") . $date->format("His") . "presidente." . $body["extension"];

                file_put_contents($fileDir . "/" . $fileName,  $bin);
            }

            if (boolval($body["Estado"])) {
                $comandoValidate = Database::getInstance()->getDb()->prepare("UPDATE Presidente SET Estado = 0 AND idCapitulo = ?");
                $comandoValidate->bindParam(1, $body["IdCapitulo"], PDO::PARAM_STR);
                $comandoValidate->execute();
            }

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Presidente(
                IdPresidente,
                IdDNI,
                FechaInicio,
                FechaFinal,
                idCapitulo,
                Estado,
                Ruta,
                idUsuario,
                FechaRegistro,
                HoraRegistro,
                FechaUpdate,
                HoraUpdate 
            ) VALUES(?,?,?,?,?,?,?,?,GETDATE(),GETDATE(),GETDATE(),GETDATE())");
            $comandoInsert->bindParam(1, $IdPresidente, PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $body["IdDNI"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $body["FechaInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $body["FechaFinal"], PDO::PARAM_STR);
            $comandoInsert->bindParam(5, $body["IdCapitulo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $body["Estado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(7, $fileName, PDO::PARAM_STR);
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
            $presidente = Database::getInstance()->getDb()->prepare("SELECT Ruta FROM Presidente WHERE IdPresidente = ?");
            $presidente->bindParam(1, $body["IdPresidente"]);
            $presidente->execute();
            if ($row = $presidente->fetchObject()) {
                $fileName = "";

                if (intval($body["valImagen"]) == 0) {
                    $fileName  = "";
                } else if (intval($body["valImagen"]) == 1) {
                    $fileName  = $row->Ruta;
                } else {
                    $fileDir = "../resources/images";
                    if (!file_exists($fileDir)) {
                        mkdir($fileDir, 0777, true);
                    } else {
                        chmod($fileDir, 0777);
                    }

                    $remove = $fileDir . '/' . $row->Ruta;
                    if (is_file($remove) && file_exists($remove)) {
                        unlink($remove);
                    }

                    $bin = base64_decode($body["imagen"]);

                    $date = new DateTime("now");
                    $fileName = $date->format("Ymd") . $date->format("His") . "presidente." . $body["extension"];

                    file_put_contents($fileDir . "/" . $fileName,  $bin);
                }

                $comando = Database::getInstance()->getDb()->prepare("UPDATE Presidente SET 
                FechaInicio = ?,
                FechaFinal = ?,
                idCapitulo = ?,
                Estado = ?,
                Ruta = ?,
                idUsuario = ?,
                FechaUpdate = GETDATE(),
                HoraUpdate = GETDATE()
                WHERE IdPresidente = ?");
                $comando->bindParam(1, $body["FechaInicio"], PDO::PARAM_STR);
                $comando->bindParam(2, $body["FechaFinal"], PDO::PARAM_STR);
                $comando->bindParam(3, $body["IdCapitulo"], PDO::PARAM_STR);
                $comando->bindParam(4, $body["Estado"], PDO::PARAM_STR);
                $comando->bindParam(5, $fileName, PDO::PARAM_STR);
                $comando->bindParam(6, $body["idUsuario"], PDO::PARAM_STR);
                $comando->bindParam(7, $body["IdPresidente"], PDO::PARAM_STR);
                $comando->execute();

                Database::getInstance()->getDb()->commit();
                Response::sendSave("Los datos se actualizon correctamente.");
            } else {
                Database::getInstance()->getDb()->rollBack();
                Response::sendClient("El id del presidente fue alterado o no cargó bien los datos, intente nuevamente.");
            }
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
                $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT Ruta FROM Presidente WHERE IdPresidente = ?");
                $cmdValidate->bindParam(1, $body["IdPresidente"], PDO::PARAM_INT);
                $cmdValidate->execute();
                if ($row = $cmdValidate->fetchObject()) {
                    $fileDir = "../resources/images";
                    $remove = $fileDir . '/' . $row->Ruta;
                    if (is_file($remove) && file_exists($remove)) {
                        unlink($remove);
                    }

                    $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Presidente WHERE IdPresidente = ?");
                    $cmdDelete->bindParam(1, $body["IdPresidente"], PDO::PARAM_INT);
                    $cmdDelete->execute();
                    Database::getInstance()->getDb()->commit();
                    Response::sendSave("Se eliminó correctamente el presidente.");
                } else {
                    Database::getInstance()->getDb()->rollBack();
                    Response::sendClient("El id del directivo fue alterado o no cargó bien los datos, intente nuevamente.");
                }
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
