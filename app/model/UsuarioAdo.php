<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class UsuarioAdo
{

    public function construct()
    {
    }

    public static function getAllUsuarios($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayUsuarios = array();
            $comandoUsuarios = Database::getInstance()->getDb()->prepare("SELECT idUsuario, upper(Nombres) AS Nombres, upper(Apellidos) AS Apellidos, 
            upper(Usuario) AS Usuario, Clave FROM Usuario 
            where Nombres like concat('%', ?,'%') or Apellidos like concat('%', ?,'%') or Usuario like concat('%', ?,'%')
            ORDER BY idUsuario ASC
            offset ? rows fetch next ? rows only");
            $comandoUsuarios->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoUsuarios->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoUsuarios->bindParam(3, $nombres, PDO::PARAM_STR);
            $comandoUsuarios->bindParam(4, $posicionPagina, PDO::PARAM_INT);
            $comandoUsuarios->bindParam(5, $filasPorPagina, PDO::PARAM_INT);
            $comandoUsuarios->execute();
            $count = 0;
            while ($row = $comandoUsuarios->fetch()) {
                $count++;
                array_push($arrayUsuarios, array(
                    "Id" => $count + $posicionPagina,
                    "idUsuario" => $row["idUsuario"],
                    "Nombres" => $row["Nombres"],
                    "Apellidos" => $row["Apellidos"],
                    "Usuario" => $row["Usuario"],
                    "Clave" => $row["Clave"]
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Usuario 
            where Nombres like concat('%',?,'%') or Apellidos like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayUsuarios, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insertUsuario($usuario)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE idUsuario = ? ");
            $comandSelect->bindParam(1, $usuario["idusuario"], PDO::PARAM_INT);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {

                $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE idUsuario <> ? AND UPPER(Nombres) = UPPER(?) AND UPPER(Apellidos) = UPPER(?)");
                $comandSelect->bindParam(1, $usuario["idusuario"], PDO::PARAM_INT);
                $comandSelect->bindParam(2, $usuario["nombres"], PDO::PARAM_STR);
                $comandSelect->bindParam(3, $usuario["apellidos"], PDO::PARAM_STR);
                $comandSelect->execute();
                if ($comandSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "duplicado";
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Usuario SET Nombres = UPPER(?), Apellidos = UPPER(?), Usuario = UPPER(?), Clave = ? WHERE idUsuario = ?");
                    $comandoInsert->bindParam(1, $usuario["nombres"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $usuario["apellidos"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $usuario["usuarios"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $usuario["contrasena"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $usuario["idusuario"], PDO::PARAM_INT);
                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "actualizado";
                }
            } else {

                $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE UPPER(Nombres) = UPPER(?) AND UPPER(Apellidos) = UPPER(?)");
                $comandSelect->bindParam(1, $usuario["nombres"], PDO::PARAM_STR);
                $comandSelect->bindParam(2, $usuario["apellidos"], PDO::PARAM_STR);
                $comandSelect->execute();
                if ($comandSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "duplicado";
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Usuario (Nombres, Apellidos, Usuario,Clave,Estado,Sistema) VALUES (UPPER(?), UPPER(?), UPPER(?), ?,1,0)");
                    $comandoInsert->bindParam(1, $usuario["nombres"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $usuario["apellidos"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $usuario["usuarios"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $usuario["contrasena"], PDO::PARAM_STR);
                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "insertado";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteUsuario($usuario)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE idUsuario = ? and Sistema = 1");
            $comandSelect->bindParam(1, $usuario["idusuario"], PDO::PARAM_STR);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "sistema";
            } else {
                $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE idUsuario = ? and Estado = 1");
                $comandSelect->bindParam(1, $usuario["idusuario"], PDO::PARAM_STR);
                $comandSelect->execute();
                if ($comandSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "activo";
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("DELETE FROM Usuario WHERE idUsuario = ?");
                    $comandoInsert->bindParam(1, $usuario["idusuario"], PDO::PARAM_STR);
                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "eliminado";
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getUsuarioById($idUsuario)
    {
        try {
            $cmdLogin = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE idUsuario = ? ");
            $cmdLogin->bindParam(1, $idUsuario, PDO::PARAM_INT);
            $cmdLogin->execute();
            $result = $cmdLogin->fetchObject();
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function login($usuario, $clave)
    {

        try {
            $cmdLogin = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE Usuario = ? AND Clave = ?");
            $cmdLogin->bindParam(1, $usuario, PDO::PARAM_STR);
            $cmdLogin->bindParam(2, $clave, PDO::PARAM_STR);
            $cmdLogin->execute();

            $result = $cmdLogin->fetchObject();
            // $result = $cmdLogin->fetch();
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
