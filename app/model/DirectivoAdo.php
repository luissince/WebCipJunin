<?php

namespace SysSoftIntegra\Model;

use DateTime;
use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;
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
                    "Firma" => $row->Firma,
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
            d.Firma,
            d.Ruta
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
                $fileName = $date->format("Ymd") . $date->format("His") . "directivo." . $body["extension"];

                file_put_contents($fileDir . "/" . $fileName,  $bin);
            }

            if($body["Firma"] === 1){
                $comandoUpdate = Database::getInstance()->getDb()->prepare("UPDATE Directivo SET Firma = 0");
                $comandoUpdate->execute();
            }

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Directivo(
                IdDirectivo,
                IdDNI,
                FechaInicio,
                FechaFinal,
                Estado,
                Firma,
                IdTablaTipoDirectivo,
                Ruta,
                idUsuario,
                FechaRegistro,
                HoraRegistro,
                FechaUpdate,
                HoraUpdate 
            ) VALUES(?,?,?,?,?,?,?,?,?,GETDATE(),GETDATE(),GETDATE(),GETDATE())");
            $comandoInsert->bindParam(1, $idDirectivo, PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $body["IdDNI"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $body["FechaInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $body["FechaFinal"], PDO::PARAM_STR);
            $comandoInsert->bindParam(5, $body["Estado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $body["Firma"], PDO::PARAM_STR);
            $comandoInsert->bindParam(7, $body["IdTablaTipoDirectivo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(8, $fileName, PDO::PARAM_STR);
            $comandoInsert->bindParam(9, $body["idUsuario"], PDO::PARAM_STR);
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

            $directivo = Database::getInstance()->getDb()->prepare("SELECT Ruta FROM Directivo WHERE IdDirectivo = ?");
            $directivo->bindParam(1, $body["IdDirectivo"]);
            $directivo->execute();
            if ($row = $directivo->fetchObject()) {
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
                    $fileName = $date->format("Ymd") . $date->format("His") . "directivo." . $body["extension"];

                    file_put_contents($fileDir . "/" . $fileName,  $bin);
                }

                if(boolval($body["Firma"])){
                    $comandoUpdate = Database::getInstance()->getDb()->prepare("UPDATE Directivo SET Firma = 0");
                    $comandoUpdate->execute();
                }

                $comando = Database::getInstance()->getDb()->prepare("UPDATE Directivo SET 
                FechaInicio = ?,
                FechaFinal = ?,
                Estado = ?,
                Firma = ?,
                IdTablaTipoDirectivo = ?,
                Ruta = ?,
                idUsuario = ?,
                FechaUpdate = GETDATE(),
                HoraUpdate = GETDATE()
                WHERE IdDirectivo = ?");
                $comando->bindParam(1, $body["FechaInicio"], PDO::PARAM_STR);
                $comando->bindParam(2, $body["FechaFinal"], PDO::PARAM_STR);
                $comando->bindParam(3, $body["Estado"], PDO::PARAM_STR);
                $comando->bindParam(4, $body["Firma"], PDO::PARAM_STR);
                $comando->bindParam(5, $body["IdTablaTipoDirectivo"], PDO::PARAM_STR);
                $comando->bindParam(6, $fileName, PDO::PARAM_STR);
                $comando->bindParam(7, $body["idUsuario"], PDO::PARAM_STR);
                $comando->bindParam(8, $body["IdDirectivo"], PDO::PARAM_STR);
                $comando->execute();

                Database::getInstance()->getDb()->commit();
                Response::sendSave("Los datos se actualizon correctamente.");
            } else {
                Database::getInstance()->getDb()->rollBack();
                Response::sendClient("El id del directivo fue alterado o no cargó bien los datos, intente nuevamente.");
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
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT IdDirectivo FROM Directivo WHERE IdDirectivo = ? AND Estado = 1");
            $cmdValidate->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("No se pudo eliminar el directivo(a) por que tiene estado activo.");
            } else {
                $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT Ruta FROM Directivo WHERE IdDirectivo = ?");
                $cmdValidate->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
                $cmdValidate->execute();
                if ($row = $cmdValidate->fetchObject()) {
                    $fileDir = "../resources/images";
                    $remove = $fileDir . '/' . $row->Ruta;
                    if (is_file($remove) && file_exists($remove)) {
                        unlink($remove);
                    }

                    $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Directivo WHERE IdDirectivo = ?");
                    $cmdDelete->bindParam(1, $body["IdDirectivo"], PDO::PARAM_INT);
                    $cmdDelete->execute();
                    Database::getInstance()->getDb()->commit();
                    Response::sendSave("Se eliminó correctamente el directivo(a).");
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
