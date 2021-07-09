<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class EmpresaAdo
{
    public static function RegistrarEmpresa($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * from EmpresaPersona where IdEmpresa = ?');
            $cmdSelect->bindParam(1, $data['IdEmpresa'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM EmpresaPersona WHERE IdEmpresa <> ? AND NumeroRuc =?");
                $cmdSelect->bindParam(1, $data["IdEmpresa"], PDO::PARAM_INT);
                $cmdSelect->bindParam(2, $data["Ruc"], PDO::PARAM_INT);
                $cmdSelect->execute();
                if ($cmdSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return 'Duplicado';
                } else {
                    $cmdInsert = Database::getInstance()->getDb()->prepare("UPDATE EmpresaPersona SET NumeroRuc = ?, Nombre = UPPER(?), Direccion = UPPER(?), 
                    Telefono = ?, PaginaWeb=?, Email=? WHERE IdEmpresa = ?");
                    $cmdInsert->bindParam(1, $data["Ruc"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(2, $data["Nombre"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(3, $data["Direccion"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(4, $data["Telefono"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(5, $data["Web"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(6, $data["Email"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(7, $data["IdEmpresa"], PDO::PARAM_STR);
                    $cmdInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "Actualizado";
                }
            } else {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM EmpresaPersona WHERE NumeroRuc = ?");
                $cmdSelect->bindParam(1, $data["Ruc"], PDO::PARAM_STR);
                $cmdSelect->execute();
                if ($cmdSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return 'Duplicado';
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO EmpresaPersona (
                        NumeroRuc,
                        Nombre,
                        Direccion, 
                        Telefono,
                        PaginaWeb, 
                        Email)
                    VALUES(?,UPPER(?),UPPER(?),?,LOWER(?),LOWER(?))");

                    $comandoInsert->bindParam(1, $data['Ruc'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $data['Nombre'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $data['Direccion'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $data['Telefono'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $data['Web'], PDO::PARAM_STR);
                    $comandoInsert->bindParam(6, $data['Email'], PDO::PARAM_STR);

                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return array("result"=>"Insertado","id"=>Database::getInstance()->getDb()->lastInsertId());
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getAllEmpresas($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayEmpresas = array();
            $comandoEmpresas = Database::getInstance()->getDb()->prepare("SELECT 
            IdEmpresa, 
            NumeroRuc, 
            UPPER(Nombre) AS Nombre, 
            UPPER(Direccion) AS Direccion, 
            Telefono, 
            LOWER(PaginaWeb) AS PaginaWeb, 
            LOWER(Email) AS Email 
            FROM EmpresaPersona
            WHERE Nombre like concat('%', ?,'%') or NumeroRuc like concat('%', ?,'%')
            ORDER BY IdEmpresa ASC
            offset ? rows fetch next ? rows only");
            $comandoEmpresas->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoEmpresas->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoEmpresas->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comandoEmpresas->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comandoEmpresas->execute();
            $count = 0;
            while ($row = $comandoEmpresas->fetch()) {
                $count++;
                array_push($arrayEmpresas, array(
                    "Id" => $count + $posicionPagina,
                    "idEmpresa" => $row["IdEmpresa"],
                    "numeroRuc" => $row["NumeroRuc"],
                    "nombre" => $row["Nombre"],
                    "direccion" => $row["Direccion"],
                    "telefono" => $row["Telefono"],
                    "paginaWeb" => $row["PaginaWeb"],
                    "email" => $row["Email"]
                ));
            }
            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM EmpresaPersona WHERE Nombre like concat('%',?,'%') OR NumeroRuc like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayEmpresas, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getDataByIdEmpresa($idEmpresa)
    {
        try {
            $cmdEmpresa = Database::getInstance()->getDb()->prepare("SELECT IdEmpresa, NumeroRuc, UPPER(Nombre) AS Nombre, UPPER(Direccion) AS Direccion, Telefono, LOWER(PaginaWeb) AS PaginaWeb, 
            LOWER(Email) AS Email from EmpresaPersona
            WHERE IdEmpresa = ?");
            $cmdEmpresa->bindParam(1, $idEmpresa, PDO::PARAM_INT);
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();
            return $resultEmpresa;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function deleteEmpresa($idEmpresa)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();


            $comandoInsert = Database::getInstance()->getDb()->prepare("DELETE FROM EmpresaPersona WHERE IdEmpresa = ?");
            $comandoInsert->bindParam(1, $idEmpresa["idEmpresa"], PDO::PARAM_STR);
            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
