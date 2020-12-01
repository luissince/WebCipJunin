<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class UniversidadAdo
{

    public function construct()
    {
    }

    public static function getAllUniversidades($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayUniversidades = array();
            $comandoUniversidades = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, Universidad, Siglas FROM Universidad
            where Universidad like concat('%', ?,'%') or Siglas like concat('%', ?,'%')
            order by Universidad asc
            offset ? rows fetch next ? rows only");
            $comandoUniversidades->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoUniversidades->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoUniversidades->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comandoUniversidades->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comandoUniversidades->execute();
            $count = 0;
            while ($row = $comandoUniversidades->fetch()) {
                $count++;
                array_push($arrayUniversidades, array(
                    "Id" => $count + $posicionPagina,
                    "idUniversidad" => $row["idUniversidad"],
                    "universidad" => $row["Universidad"],
                    "siglas" => $row["Siglas"]

                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Universidad 
            where Universidad like concat('%',?,'%') or Siglas like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayUniversidades, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insertUniversidad($universidad)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Universidad WHERE Universidad = UPPER(?)");
            $comandSelect->bindParam(1, $universidad["universidad"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "duplicado";
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Universidad (Universidad, Siglas) VALUES (UPPER(?), UPPER(?))");
                $comandoInsert->bindParam(1, $universidad["universidad"], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $universidad["siglas"], PDO::PARAM_STR);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return "insertado";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateUniversidad($universidad)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Universidad WHERE idUniversidad <> ? AND Universidad = UPPER(?)");
            $comandSelect->bindParam(1, $universidad["idUniversidad"], PDO::PARAM_INT);
            $comandSelect->bindParam(2, $universidad["universidad"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "duplicado";
            } else {
                // $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Universidad WHERE idUniversidad <> ? AND Siglas = UPPER(?)");
                // $comandSelect->bindParam(1, $universidad["idUniversidad"], PDO::PARAM_INT);
                // $comandSelect->bindParam(2, $universidad["siglas"], PDO::PARAM_STR);
                // $comandSelect->execute();
                // if ($comandSelect->fetch()) {
                //     Database::getInstance()->getDb()->rollback();
                //     return "duplicadosiglas";
                // } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Universidad SET Universidad = UPPER(?), Siglas = UPPER(?) WHERE idUniversidad = ?");
                    $comandoInsert->bindParam(1, $universidad["universidad"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $universidad["siglas"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $universidad["idUniversidad"], PDO::PARAM_INT);
                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "actualizado";
                // }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteUniversidad($universidad){
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Universidad WHERE idUniversidad = ?");
            $comandSelect->bindParam(1, $universidad["idUniversidad"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
