<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use Exception;

class CursoAdo
{

    public function construct()
    {
    }

    public static function getAll($text, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayCurso = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.idCurso, 
            c.Nombre, 
            c.Instructor, 
            c.Organizador, 
            c.idCapitulo, 
            cap.Capitulo,
            c.Modalidad, 
            c.Direccion, 
            convert(VARCHAR, CAST(c.FechaInicio AS DATE), 103) AS FechaInicio, 
            c.HoraInicio, 
            c.PrecioCurso, 
            c.PrecioCertificado, 
            c.Celular, 
            c.Correo, 
            c.Descripcion, 
            c.Estado
            FROM Curso AS c INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
            where c.Nombre like concat('%', ?,'%') or cap.Capitulo like concat('%', ?,'%')
            order by c.FechaInicio desc
            offset ? rows fetch next ? rows only");
            $comando->bindParam(1, $text, PDO::PARAM_STR);
            $comando->bindParam(2, $text, PDO::PARAM_STR);
            $comando->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comando->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayCurso, array(
                    "Id" => $count + $posicionPagina,
                    "idCurso" => $row["idCurso"],
                    "Nombre" => $row["Nombre"],
                    "Instructor" => $row["Instructor"],
                    "Organizador" => $row["Organizador"],
                    "idCapitulo" => $row["idCapitulo"],
                    "Capitulo" => $row["Capitulo"],
                    "Modalidad" => $row["Modalidad"],
                    "Direccion" => $row["Direccion"],

                    "FechaInicio" => $row["FechaInicio"],
                    "HoraInicio" => $row["HoraInicio"],
                    "PrecioCurso" => $row["PrecioCurso"],
                    "PrecioCertificado" => $row["PrecioCertificado"],
                    "Celular" => $row["Celular"],
                    "Correo" => $row["Correo"],
                    "Descripcion" => $row["Descripcion"],
                    "Estado" => $row["Estado"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Curso AS c INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
            where c.Nombre like concat('%',?,'%') or cap.Capitulo like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $text, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayCurso, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insert($curso)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Curso 
            (Nombre, Instructor, Organizador, idCapitulo, Modalidad, Direccion, FechaInicio, HoraInicio, PrecioCurso, PrecioCertificado, Celular, Correo, Descripcion, Estado, idUsuario) 
            VALUES (UPPER(?), UPPER(?), UPPER(?), ?,?, UPPER(?), ?,?,?,?,?,?,UPPER(?),?,?)");
            $comandoInsert->bindParam(1, $curso["Nombre"], PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $curso["Instructor"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $curso["Organizador"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $curso["idCapitulo"], PDO::PARAM_INT);
            $comandoInsert->bindParam(5, $curso["Modalidad"], PDO::PARAM_INT);
            $comandoInsert->bindParam(6, $curso["Direccion"], PDO::PARAM_STR);

            $comandoInsert->bindParam(7, $curso["FechaInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(8, $curso["HoraInicio"], PDO::PARAM_STR);

            $comandoInsert->bindParam(9, $curso["PrecioCurso"], PDO::PARAM_STR);
            $comandoInsert->bindParam(10, $curso["PrecioCertificado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(11, $curso["Celular"], PDO::PARAM_STR);
            $comandoInsert->bindParam(12, $curso["Correo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(13, $curso["Descripcion"], PDO::PARAM_STR);
            $comandoInsert->bindParam(14, $curso["Estado"], PDO::PARAM_BOOL);
            $comandoInsert->bindParam(15, $curso["idUsuario"], PDO::PARAM_INT);

            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return "insertado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function id($id){
        try {
            $cmd = Database::getInstance()->getDb()->prepare("SELECT 
            idCurso,
            Nombre, 
            Instructor, 
            Organizador, 
            idCapitulo, 
            Modalidad, 
            Direccion, 
            CAST(FechaInicio AS DATE) AS FechaInicio,
            CONVERT(VARCHAR, HoraInicio, 24) AS HoraInicio,
            PrecioCurso, 
            PrecioCertificado, 
            Celular, 
            Correo, 
            Descripcion, 
            Estado
            from Curso WHERE idCurso = ?");
            $cmd->bindParam(1, $id, PDO::PARAM_INT);
            $cmd->execute();
            $result = $cmd->fetchObject();
            return $result;

        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

    public static function update($curso)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoUpdate = Database::getInstance()->getDb()->prepare("UPDATE Curso SET 
            Nombre = UPPER(?), 
            Instructor = UPPER(?), 
            Organizador = UPPER(?), 
            idCapitulo = ?, 
            Modalidad = ?, 
            Direccion = UPPER(?), 
            FechaInicio = ?, 
            HoraInicio = ?, 
            PrecioCurso = ?, 
            PrecioCertificado = ?, 
            Celular = ?, 
            Correo = ?, 
            Descripcion = UPPER(?), 
            Estado = ?, 
            idUsuario = ?
            WHERE idCurso = ?");

            $comandoUpdate->bindParam(1, $curso["Nombre"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(2, $curso["Instructor"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(3, $curso["Organizador"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(4, $curso["idCapitulo"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(5, $curso["Modalidad"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(6, $curso["Direccion"], PDO::PARAM_STR);

            $comandoUpdate->bindParam(7, $curso["FechaInicio"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(8, $curso["HoraInicio"], PDO::PARAM_STR);

            $comandoUpdate->bindParam(9, $curso["PrecioCurso"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(10, $curso["PrecioCertificado"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(11, $curso["Celular"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(12, $curso["Correo"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(13, $curso["Descripcion"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(14, $curso["Estado"], PDO::PARAM_BOOL);
            $comandoUpdate->bindParam(15, $curso["idUsuario"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(16, $curso["idCurso"], PDO::PARAM_INT);

            $comandoUpdate->execute();
            Database::getInstance()->getDb()->commit();
            return "actualizado";

        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function delete($curso)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Curso WHERE idCurso = ? AND Estado = 1");
            $cmdValidate->bindParam(1, $curso["idCurso"], PDO::PARAM_INT);
            $cmdValidate->execute();

            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "activo";
            } else {

                $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Curso WHERE idCurso = ?");
                $cmdDelete->bindParam(1, $curso["idCurso"], PDO::PARAM_INT);
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
