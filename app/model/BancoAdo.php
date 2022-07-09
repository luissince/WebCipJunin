<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use Exception;


class BancoAdo
{
    public static function getNombreBancos()
    {
        try {
            $array = array();
            $cmdBancos = Database::getInstance()->getDb()->prepare("SELECT * FROM Banco WHERE Estado = 1");
            $cmdBancos->execute();
            while ($row = $cmdBancos->fetch()) {
                array_push($array, array(
                    "Idbanco" => $row["idBanco"],
                    "Nombre" => $row["Nombre"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public static function getAllBancos($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayBancos = array();
            $comandoBancos = Database::getInstance()->getDb()->prepare("SELECT *
            FROM Banco
            WHERE Nombre like concat('%', ?,'%') 
            ORDER BY IdBanco ASC
            offset ? rows fetch next ? rows only");
            $comandoBancos->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoBancos->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $comandoBancos->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $comandoBancos->execute();
            $count = 0;
            while ($row = $comandoBancos->fetch()) {
                $count++;
                array_push($arrayBancos, array(
                    "Id" => $count + $posicionPagina,
                    "Idbanco" => $row["idBanco"],
                    "Nombre" => $row["Nombre"],
                    "NmroCuenta" => $row["NmroCuenta"],
                    "NmroCuentaInterbancaria" => $row["NmroCuentaInterbancaria"],
                    "EstadoBanco" => $row["Estado"]
                ));
            }
            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Banco WHERE Nombre like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayBancos, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function RegistrarBanco($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * from Banco where idBanco = ?');
            $cmdSelect->bindParam(1, $data['Idbanco'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                $cmdInsert = Database::getInstance()->getDb()->prepare("UPDATE Banco SET Nombre = ?, NmroCuenta = ?, NmroCuentaInterbancaria = ?, Estado = ? WHERE idBanco = ?");
                $cmdInsert->bindParam(1, $data["Nombre"], PDO::PARAM_STR);
                $cmdInsert->bindParam(2, $data["NumeroCuenta"], PDO::PARAM_STR);
                $cmdInsert->bindParam(3, $data["NumeroCuentainterbancaria"], PDO::PARAM_STR);
                $cmdInsert->bindParam(4, $data["Estado"], PDO::PARAM_INT);
                $cmdInsert->bindParam(5, $data["Idbanco"], PDO::PARAM_INT);
                $cmdInsert->execute();
                Database::getInstance()->getDb()->commit();
                return "Actualizado";
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Banco (
                    Nombre,
                    NmroCuenta, 
                    NmroCuentaInterbancaria,
                    Estado)
                VALUES(?,?,?,?)");

                $comandoInsert->bindParam(1, $data['Nombre'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $data['NumeroCuenta'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $data['NumeroCuentainterbancaria'], PDO::PARAM_STR);
                $comandoInsert->bindParam(4, $data["Estado"], PDO::PARAM_INT);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return "Insertado";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getDataByIdBanco($idBanco)
    {
        try {
            $cmdBanco = Database::getInstance()->getDb()->prepare("SELECT * from Banco  WHERE idBanco = ?");
            $cmdBanco->bindParam(1, $idBanco, PDO::PARAM_INT);
            $cmdBanco->execute();
            $resultBanco = $cmdBanco->fetchObject();
            return $resultBanco;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function deletebanco($idBanco)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Ingreso where idBanco = ?");
            $cmdValidate->bindValue(1,$idBanco["idBanco"],PDO::PARAM_INT);
            $cmdValidate->execute();
            if($cmdValidate->fetch()){
                Database::getInstance()->getDb()->rollback();
                return "ingreso";
            }else{
                $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Banco WHERE IdBanco = ?");
                $cmdDelete->bindParam(1, $idBanco["idBanco"], PDO::PARAM_INT);
                $cmdDelete->execute();
                Database::getInstance()->getDb()->commit();
                return "eliminado";
            }           
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
