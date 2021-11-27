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
            $comandoUsuarios = Database::getInstance()->getDb()->prepare("SELECT 
            u.idUsuario, upper(u.Nombres) AS Nombres, upper(u.Apellidos) AS Apellidos, 
            upper(u.Usuario) AS Usuario, u.Clave,r.Nombre as Rol, u.Estado FROM Usuario as u INNER JOIN Rol AS r ON r.idRol = u.Rol
            where u.Nombres like concat('%', ?,'%') or u.Apellidos like concat('%', ?,'%') or u.Usuario like concat('%', ?,'%')
            ORDER BY u.idUsuario ASC
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
                    "Clave" => $row["Clave"],
                    "Rol" => $row["Rol"],
                    "Estado" => $row["Estado"]
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Usuario as u INNER JOIN Rol AS r ON r.idRol = u.Rol 
            where u.Nombres like concat('%',?,'%') or u.Apellidos like concat('%',?,'%')");
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
                    $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Usuario SET Nombres = UPPER(?), Apellidos = UPPER(?), Usuario = UPPER(?), Clave = ?,Rol = ?,Estado = ? WHERE idUsuario = ?");
                    $comandoInsert->bindParam(1, $usuario["nombres"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $usuario["apellidos"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $usuario["usuarios"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $usuario["contrasena"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $usuario["rol"], PDO::PARAM_INT);
                    $comandoInsert->bindParam(6, $usuario["estado"], PDO::PARAM_INT);
                    $comandoInsert->bindParam(7, $usuario["idusuario"], PDO::PARAM_INT);
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
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Usuario (Nombres, Apellidos, Usuario,Clave,Rol,Estado,Sistema) VALUES (UPPER(?), UPPER(?), UPPER(?), ?, ?, ?, 0)");
                    $comandoInsert->bindParam(1, $usuario["nombres"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $usuario["apellidos"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $usuario["usuarios"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $usuario["contrasena"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $usuario["rol"], PDO::PARAM_INT);
                    $comandoInsert->bindParam(6, $usuario["estado"], PDO::PARAM_INT);
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

                    $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM Ingreso WHERE idUsuario = ? ");
                    $comandSelect->bindParam(1, $usuario["idusuario"], PDO::PARAM_STR);
                    $comandSelect->execute();
                    if ($comandSelect->fetch()) {
                        Database::getInstance()->getDb()->rollback();
                        return "ingreso";
                    } else {
                        $comandoInsert = Database::getInstance()->getDb()->prepare("DELETE FROM Usuario WHERE idUsuario = ?");
                        $comandoInsert->bindParam(1, $usuario["idusuario"], PDO::PARAM_STR);
                        $comandoInsert->execute();
                        Database::getInstance()->getDb()->commit();
                        return "eliminado";
                    }
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updatePerfil($idUsuario, $usuario, $clave)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoInsert = Database::getInstance()->getDb()->prepare("UPDATE Usuario SET Usuario=?,Clave=? WHERE idUsuario = ?");
            $comandoInsert->bindParam(1, $usuario, PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $clave, PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $idUsuario, PDO::PARAM_INT);
            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return "update";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getUsuarioById($idUsuario)
    {
        try {
            $cmdLogin = Database::getInstance()->getDb()->prepare("SELECT 
            u.idUsuario,
            u.Nombres,
            u.Apellidos,
            u.Usuario,
            u.Clave,
            u.Rol,
            u.Estado,
            u.Sistema,
            r.Nombre as RolNombre 
            FROM Usuario AS u INNER JOIN Rol AS r ON r.idRol = u.Rol
            WHERE u.idUsuario = ? ");
            $cmdLogin->bindParam(1, $idUsuario, PDO::PARAM_INT);
            $cmdLogin->execute();
            $result = $cmdLogin->fetchObject();
            return $result;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function listUsuarios($fechaInicio, $fechaFinal)
    {
        try {
            $cmdUsuarios = Database::getInstance()->getDb()->prepare("SELECT DISTINCT
            i.idUsuario,
            CASE
            WHEN NOT u.idUsuario IS NULL THEN CONCAT(u.Apellidos,', ',u.Nombres)
            ELSE 'USUARIO LIBRE' END AS Usuario
            FROM Ingreso AS i 
            LEFT JOIN Usuario AS u ON u.idUsuario = i.idUsuario
            WHERE i.Fecha BETWEEN ? AND ?");
            $cmdUsuarios->execute(array($fechaInicio, $fechaFinal));
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . 200 . ' ' . "OK");

            return $cmdUsuarios->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $ex) {
            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
            header($protocol . ' ' . 500 . ' ' . "Internal Server Error");

            return $ex->getMessage();
        }
    }

    public static function login($usuario, $clave)
    {
        try {
            $array = array();
            $cmdValidateUsuario = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE Usuario = ? ");
            $cmdValidateUsuario->bindParam(1, $usuario, PDO::PARAM_STR);
            $cmdValidateUsuario->execute();
            if ($cmdValidateUsuario->fetch()) {

                $cmdValidateClave = Database::getInstance()->getDb()->prepare("SELECT * FROM Usuario WHERE Usuario = ? AND Clave = ? ");
                $cmdValidateClave->bindParam(1, $usuario, PDO::PARAM_STR);
                $cmdValidateClave->bindParam(2, $clave, PDO::PARAM_STR);
                $cmdValidateClave->execute();
                if ($cmdValidateClave->fetch()) {
                    $cmdLogin = Database::getInstance()->getDb()->prepare("SELECT 
                    u.idUsuario,
                    u.Nombres,
                    u.Apellidos,
                    u.Usuario,
                    u.Rol,
                    r.Nombre,
                    u.Estado,
                    u.Sistema 
                    FROM Usuario AS u  INNER JOIN Rol AS r
                    ON u.Rol = r.idRol 
                    WHERE u.Usuario = ? AND u.Clave = ? AND u.Estado = 1");
                    $cmdLogin->bindParam(1, $usuario, PDO::PARAM_STR);
                    $cmdLogin->bindParam(2, $clave, PDO::PARAM_STR);
                    $cmdLogin->execute();
                    $usuario = $cmdLogin->fetchObject();
                    if ($usuario) {
                        $cmdPermisos = Database::getInstance()->getDb()->prepare("SELECT * FROM Permiso where idRol = ?");
                        $cmdPermisos->bindParam(1, $usuario->Rol, PDO::PARAM_INT);
                        $cmdPermisos->execute();
                        $arrayPermisos = array();
                        while ($row = $cmdPermisos->fetch()) {
                            array_push($arrayPermisos, array(
                                "idModulo" => $row["idModulo"],
                                "ver" => $row["ver"],
                                "crear" => $row["crear"],
                                "actualizar" => $row["actualizar"],
                                "eliminar" => $row["eliminar"]
                            ));
                        }

                        // $cmdReporte = Database::getInstance()->getDb()->prepare("INSERT INTO Reporte(idUsuario,Tipo,Descripcion,Fecha,Hora) VALUES(?,?,?,GETDATE(),GETDATE())");
                        // $cmdReporte->execute(array());

                        array_push($array, $usuario, $arrayPermisos);
                        return $array;
                    } else {
                        return "disable";
                    }
                } else {
                    return "nopassword";
                }
            } else {
                return "nouser";
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
