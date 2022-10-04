<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;
use PDOException;

class CursoAdo
{

    public function construct()
    {
    }

    public static function getAll($text, $posicionPagina, $filasPorPagina)
    {
        try {
            $arrayCurso = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            c.idCurso, 
            c.Nombre, 
            c.Serie,
            c.Correlativo,
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
            WHERE 
            c.Nombre LIKE concat('%', ?,'%') 
            OR 
            cap.Capitulo LIKE concat('%', ?,'%')
            OR
            c.Serie LIKE concat('%', ?,'%') 

            ORDER BY c.Fecha DESC, c.Hora DESC
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY");
            $comando->bindParam(1, $text, PDO::PARAM_STR);
            $comando->bindParam(2, $text, PDO::PARAM_STR);
            $comando->bindParam(3, $text, PDO::PARAM_STR);
            $comando->bindParam(4, $posicionPagina, PDO::PARAM_INT);
            $comando->bindParam(5, $filasPorPagina, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayCurso, array(
                    "Id" => $count + $posicionPagina,
                    "idCurso" => $row["idCurso"],
                    "Nombre" => $row["Nombre"],
                    "Serie" => $row["Serie"],
                    "Correlativo" => $row["Correlativo"],
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

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Curso AS c INNER JOIN Capitulo AS cap ON c.idCapitulo = cap.idCapitulo
            WHERE 
            c.Nombre LIKE concat('%', ?,'%') 
            OR 
            cap.Capitulo LIKE concat('%', ?,'%')
            OR
            c.Serie LIKE concat('%', ?,'%') ");
            $comandoTotal->bindParam(1, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $text, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            Response::sendSuccess([
                "cursos" => $arrayCurso,
                "total" => $resultTotal
            ]);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function insert($curso)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Curso(
            Nombre,
            Serie,
            Correlativo,
            Instructor, 
            Organizador,
            idCapitulo,
            Modalidad,
            Direccion,
            FechaInicio, 
            HoraInicio,
            FechaFin,
            HoraFin,
            FechaEmision,
            PrecioCurso,
            PrecioCertificado,
            Celular, 
            Correo,
            Descripcion,
            Estado,
            Titulo,
            Detalle,
            Fecha,
            Hora,
            UFecha,
            UHora,
            idUsuario) 
            VALUES (UPPER(?),?,?,UPPER(?),UPPER(?),?,?, UPPER(?), ?,?,?,?,?, ?,?,?,?,UPPER(?),?,?,?,GETDATE(),GETDATE(),GETDATE(),GETDATE(),?)");
            $comandoInsert->bindParam(1, $curso["Nombre"], PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $curso["Serie"], PDO::PARAM_STR);
            $comandoInsert->bindParam(3, $curso["Correlativo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(4, $curso["Instructor"], PDO::PARAM_STR);
            $comandoInsert->bindParam(5, $curso["Organizador"], PDO::PARAM_STR);
            $comandoInsert->bindParam(6, $curso["idCapitulo"], PDO::PARAM_INT);
            $comandoInsert->bindParam(7, $curso["Modalidad"], PDO::PARAM_INT);
            $comandoInsert->bindParam(8, $curso["Direccion"], PDO::PARAM_STR);

            $comandoInsert->bindParam(9, $curso["FechaInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(10, $curso["HoraInicio"], PDO::PARAM_STR);
            $comandoInsert->bindParam(11, $curso["FechaFin"], PDO::PARAM_STR);
            $comandoInsert->bindParam(12, $curso["HoraFin"], PDO::PARAM_STR);
            $comandoInsert->bindParam(13, $curso["FechaEmision"], PDO::PARAM_STR);

            $comandoInsert->bindParam(14, $curso["PrecioCurso"], PDO::PARAM_STR);
            $comandoInsert->bindParam(15, $curso["PrecioCertificado"], PDO::PARAM_STR);
            $comandoInsert->bindParam(16, $curso["Celular"], PDO::PARAM_STR);
            $comandoInsert->bindParam(17, $curso["Correo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(18, $curso["Descripcion"], PDO::PARAM_STR);
            $comandoInsert->bindParam(19, $curso["Estado"], PDO::PARAM_BOOL);
            $comandoInsert->bindParam(20, $curso["Titulo"], PDO::PARAM_STR);
            $comandoInsert->bindParam(21, $curso["Detalle"], PDO::PARAM_STR);
            $comandoInsert->bindParam(22, $curso["idUsuario"], PDO::PARAM_INT);

            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            Response::sendSave("Curso registrado correctamente.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function id($id)
    {
        try {
            $cmd = Database::getInstance()->getDb()->prepare("SELECT 
            c.idCurso,
            c.Nombre, 
            c.Serie,
            c.Correlativo,
            c.Instructor, 
            c.Organizador, 
            c.idCapitulo, 
            ca.Capitulo,
            c.Modalidad, 
            c.Direccion, 
            CAST(c.FechaInicio AS DATE) AS FechaInicio,
            CONVERT(VARCHAR, c.HoraInicio, 24) AS HoraInicio,
            CAST(FechaFin AS DATE) AS FechaFin,
            CONVERT(VARCHAR,HoraFin, 24) AS HoraFin,
            CAST(FechaEmision AS DATE) AS FechaEmision,
            c.PrecioCurso, 
            c.PrecioCertificado, 
            c.Celular, 
            c.Correo, 
            c.Descripcion, 
            c.Estado,
            c.Titulo,
            c.Detalle
            FROM Curso AS c INNER JOIN Capitulo AS ca ON ca.idCapitulo = c.idCapitulo
            
            WHERE c.idCurso = ?");
            $cmd->bindParam(1, $id, PDO::PARAM_INT);
            $cmd->execute();
            $result = $cmd->fetchObject();
            Response::sendSuccess($result);
        } catch (Exception $ex) {
            Response::sendError($ex->getMessage());
        } catch (PDOException $ex) {
            Response::sendError($ex->getMessage());
        }
    }

    public static function update($curso)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoUpdate = Database::getInstance()->getDb()->prepare("UPDATE Curso SET 
            Nombre = UPPER(?), 
            Serie = ?, 
            Correlativo = ?, 
            Instructor = UPPER(?), 
            Organizador = UPPER(?), 
            idCapitulo = ?, 
            Modalidad = ?, 
            Direccion = UPPER(?), 
            FechaInicio = ?, 
            HoraInicio = ?, 
            FechaFin = ?, 
            HoraFin = ?,
            FechaEmision = ?,
            PrecioCurso = ?, 
            PrecioCertificado = ?, 
            Celular = ?, 
            Correo = ?, 
            Descripcion = UPPER(?), 
            Estado = ?, 
            Titulo = ?,
            Detalle = ?,
            idUsuario = ?,
            UFecha = GETDATE(), 
            UHora = GETDATE()
            WHERE idCurso = ?");

            $comandoUpdate->bindParam(1, $curso["Nombre"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(2, $curso["Serie"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(3, $curso["Correlativo"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(4, $curso["Instructor"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(5, $curso["Organizador"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(6, $curso["idCapitulo"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(7, $curso["Modalidad"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(8, $curso["Direccion"], PDO::PARAM_STR);

            $comandoUpdate->bindParam(9, $curso["FechaInicio"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(10, $curso["HoraInicio"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(11, $curso["FechaFin"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(12, $curso["HoraFin"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(13, $curso["FechaEmision"], PDO::PARAM_STR);

            $comandoUpdate->bindParam(14, $curso["PrecioCurso"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(15, $curso["PrecioCertificado"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(16, $curso["Celular"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(17, $curso["Correo"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(18, $curso["Descripcion"], PDO::PARAM_STR);
            $comandoUpdate->bindParam(19, $curso["Estado"], PDO::PARAM_BOOL);
            $comandoUpdate->bindParam(20, $curso["Titulo"], PDO::PARAM_BOOL);
            $comandoUpdate->bindParam(21, $curso["Detalle"], PDO::PARAM_BOOL);
            $comandoUpdate->bindParam(22, $curso["idUsuario"], PDO::PARAM_INT);
            $comandoUpdate->bindParam(23, $curso["idCurso"], PDO::PARAM_INT);

            $comandoUpdate->execute();
            Database::getInstance()->getDb()->commit();
            Response::sendSave("Curso actualizado correctamente.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
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
                Response::sendClient("No se pudo eliminar el curso por que tiene estado activo.");
            } else {
                $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT idCurso FROM Inscripcion WHERE idCurso = ?");
                $cmdValidate->bindParam(1, $curso["idCurso"], PDO::PARAM_INT);
                $cmdValidate->execute();
                if ($cmdValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    Response::sendClient("No se pudo eliminar el curso ya que tiene ligado inscripciones.");
                } else {
                    $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Curso WHERE idCurso = ?");
                    $cmdDelete->bindParam(1, $curso["idCurso"], PDO::PARAM_INT);
                    $cmdDelete->execute();
                    Database::getInstance()->getDb()->commit();
                    Response::sendSave("Curso eliminado correctamente.");
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    /**
     * @param string $idCurso
     * @param string $idParticipante
     *
     * @return array|string
     * @throws \Exception
     */
    public static function generarCertificado(string $idCurso, string $idParticipante)
    {
        try {
            $cmdCurso = Database::getInstance()->getDb()->prepare("SELECT
            c.idCurso,
            c.Nombre,
            c.Titulo,
            c.Detalle,
            ic.Serie,
            ic.Correlativo,
            CONCAT(es.Nombres,' ',es.Apellidos) AS Estudiante,
            CONCAT(org.Nombres,' ',org.Apellidos) AS Presidente,
            pe.Ruta,
            ca.Capitulo,
            YEAR(c.FechaEmision) AS FechaYear,
            MONTH(c.FechaEmision) AS FechaMoth
            FROM 
            Curso AS c 
            INNER JOIN Capitulo AS ca ON c.idCapitulo = ca.idCapitulo
            INNER JOIN Presidente AS pe ON ca.idCapitulo = pe.idCapitulo
            INNER JOIN Persona AS org ON org.IdDNI = pe.IdDNI
            INNER JOIN Inscripcion AS ic ON ic.idCurso = c.idCurso
            INNER JOIN Persona AS es ON es.IdDNI = ic.idParticipante
            WHERE c.idCurso = ? AND ic.idParticipante = ? AND pe.Estado = 1");
            $cmdCurso->bindParam(1, $idCurso, PDO::PARAM_STR);
            $cmdCurso->bindParam(2, $idParticipante, PDO::PARAM_STR);
            $cmdCurso->execute();

            $cmdDecano = Database::getInstance()->getDb()->prepare("SELECT 
            d.IdDirectivo,
            CONCAT(p.Nombres,' ',p.Apellidos) AS Decano,
            d.Ruta
            FROM Directivo AS d
            INNER JOIN Persona AS p on p.idDNI = d.IdDNI
            WHERE d.IdTablaTipoDirectivo = 1 AND d.Estado = 1 AND d.Firma = 1");
            $cmdDecano->execute();

            return [
                $cmdCurso->fetchObject(),
                $cmdDecano->fetchObject()
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
