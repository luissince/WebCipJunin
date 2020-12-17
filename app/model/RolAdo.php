<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class RolAdo
{

    public function construct()
    {
    }

    public static function getAllRoles($nombres)
    {
        try {
            $array = array();
            $comandoRoles = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol 
            where Nombre like concat('%', ?,'%')
            ORDER BY idRol ASC");
            $comandoRoles->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoRoles->execute();
            $count = 0;
            while ($row = $comandoRoles->fetch()) {
                $count++;
                array_push($array, array(
                    "Id" => $count,
                    "IdRol" => $row["idRol"],
                    "Nombre" => $row["Nombre"],
                    "Descripcion" => $row["Descripcion"],
                    "Estado" => $row["Estado"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    public static function insertRol($rol)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol WHERE idRol = ?");
            $comandSelect->bindParam(1, $rol["IdRol"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol WHERE idRol <> ? AND UPPER(Nombre) = UPPER(?)");
                $comandSelect->bindParam(1, $rol["IdRol"], PDO::PARAM_STR);
                $comandSelect->bindParam(2, $rol["Nombre"], PDO::PARAM_STR);
                $comandSelect->execute();
                if ($comandSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "duplicado";
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Rol SET Nombre = UPPER(?), Descripcion = UPPER(?), Estado = ? WHERE idRol = ?");
                    $comandoInsert->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $rol["Descripcion"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $rol["Estado"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $rol["IdRol"], PDO::PARAM_INT);
                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "actualizado";
                }
            } else {

                $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Rol WHERE UPPER(Nombre) = UPPER(?)");
                $comandSelect->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
                $comandSelect->execute();
                if ($comandSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "duplicado";
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Rol (Nombre, Descripcion, Estado) VALUES (UPPER(?), UPPER(?), ?)");
                    $comandoInsert->bindParam(1, $rol["Nombre"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $rol["Descripcion"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $rol["Estado"], PDO::PARAM_STR);
                    $comandoInsert->execute();

                    $idRol = Database::getInstance()->getDb()->lastInsertId();
                    $comandoPermisos = Database::getInstance()->getDb()->prepare("INSERT INTO Permiso (idRol, idModulo, ver,crear,actualizar,eliminar) VALUES (?,?,?,?,?,?)");
                    for ($i = 0; $i < 10; $i++) {
                        $comandoPermisos->execute(array($idRol, ($i + 1), 1, 1, 1, 1));
                    }
                    Database::getInstance()->getDb()->commit();
                    return "insertado";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getRolById($idRol)
    {
        try {
            $object = null;
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
                idRol,
                Nombre,
                Descripcion,
                Estado  
            FROM Rol WHERE idRol = ?");
            $comando->bindParam(1, $idRol, PDO::PARAM_INT);
            $comando->execute();
            $object = $comando->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getModulosByIdRol($idRol)
    {
        try {
            $array = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT p.idPermiso,p.idRol,m.nombre,p.ver,p.crear,p.actualizar,p.eliminar 
           FROM Permiso AS p
           INNER JOIN Modulo AS m ON m.idModulo = p.idModulo
           WHERE idRol = ?");
            $comando->bindValue(1, $idRol, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($array, array(
                    "id" => $count,
                    "idPermiso" => $row["idPermiso"],
                    "idRol" => $row["idRol"],
                    "nombre" => $row["nombre"],
                    "ver" => $row["ver"],
                    "crear" => $row["crear"],
                    "actualizar" => $row["actualizar"],
                    "eliminar" => $row["eliminar"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
