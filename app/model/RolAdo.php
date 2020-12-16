<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class RolAdo{

    public function construct(){}

    public static function getAllRoles($nombres, $posicionPagina, $filasPorPagina){
        try {
            $array = array();
            $arrayRoles = array();
            $comandoRoles = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol 
            where Nombre like concat('%', ?,'%')
            ORDER BY idRol ASC
            offset ? rows fetch next ? rows only");
            $comandoRoles->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoRoles->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $comandoRoles->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $comandoRoles->execute();
            $count = 0;
            while ($row = $comandoRoles->fetch()) {
                $count++;
                array_push($arrayRoles, array(
                    "Id" => $count + $posicionPagina,
                    "IdRol" => $row["idRol"],
                    "Nombre" => $row["Nombre"],
                    "Descripcion" => $row["Descripcion"],
                    "Estado" => $row["Estado"],
                    "Sistema" => $row["Sistema"],

                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Rol 
            where Nombre like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayRoles, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    
    public static function insertRol($rol)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol WHERE UPPER(Nombre) = UPPER(?)");
            $comandSelect->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "duplicado";
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Rol (Nombre, Descripcion, Estado, Sistema) VALUES (UPPER(?), UPPER(?), ?, ?)");
                $comandoInsert->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $rol["Descripcion"], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $rol["Estado"], PDO::PARAM_STR);
                $comandoInsert->bindParam(4, $rol["Sistema"], PDO::PARAM_STR);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return "insertado";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateRol($rol)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            // $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol WHERE Sistema = ? ");
            // $comandSelect->bindParam(1, $rol["Sistema"], PDO::PARAM_STR);
            // $comandSelect->execute();
            // if ($comandSelect->fetch()) {
            //     Database::getInstance()->getDb()->rollback();
            //     return "sistema";
            // } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Rol SET Nombre = UPPER(?), Descripcion = UPPER(?), Estado = ?, Sistema = ? WHERE idRol = ?");
                $comandoInsert->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $rol["Descripcion"], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $rol["Estado"], PDO::PARAM_STR);
                $comandoInsert->bindParam(4, $rol["Sistema"], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $rol["idRol"], PDO::PARAM_INT);
                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return "actualizado";
            // }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getRolById($idRol){
        try {
            $object = null;
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
                idRol,
                Nombre,
                Descripcion,
                Estado,
                Sistema            
            FROM Rol WHERE idRol = ?");
            $comando->bindParam(1, $idRol, PDO::PARAM_INT);
            $comando->execute();
            $object = $comando->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}