<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;
use Exception;

class InscripcionAdo
{

    public function construct()
    {
    }

    public static function getAll($text, $idCurso, $posicionPagina, $filasPorPagina)
    {
        try {
            $arrayInscripcion = array();

            $comando = Database::getInstance()->getDb()->prepare("SELECT 
            i.idCurso,
            i.idParticipante,
            i.Serie,
            i.Correlativo,
            i.Fecha,
            i.Hora,
            i.Estado,

            p.NumDoc,
            p.CIP,
            p.Apellidos,
            p.Nombres,
            ISNULL(ca.Capitulo,'') AS Capitulo,
            ISNULL(e.Especialidad,'') AS Especialidad,
            
            u.Apellidos AS ApeUsuario,
            u.Nombres AS NomUsuario
            
            FROM Inscripcion AS i
            INNER JOIN Persona AS p
            ON p.idDNI = i.idParticipante
            LEFT JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            INNER JOIN Usuario AS u 
            ON u.idUsuario = i.idUsuario
            WHERE 
            p.Nombres LIKE CONCAT('%',?,'%') AND i.idCurso = ?
            OR
            p.Apellidos LIKE CONCAT('%',?,'%') AND i.idCurso = ?
            OR
            e.Especialidad LIKE concat('%',?,'%') AND i.idCurso = ?
            OR
            ca.Capitulo LIKE concat('%',?,'%') AND i.idCurso = ?
            ORDER BY i.Fecha DESC, i.Hora DESC
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY");
            $comando->bindParam(1, $text, PDO::PARAM_STR);
            $comando->bindParam(2, $idCurso, PDO::PARAM_STR);

            $comando->bindParam(3, $text, PDO::PARAM_STR);
            $comando->bindParam(4, $idCurso, PDO::PARAM_STR);

            $comando->bindParam(5, $text, PDO::PARAM_STR);
            $comando->bindParam(6, $idCurso, PDO::PARAM_STR);

            $comando->bindParam(7, $text, PDO::PARAM_STR);
            $comando->bindParam(8, $idCurso, PDO::PARAM_STR);

            $comando->bindParam(9, $posicionPagina, PDO::PARAM_INT);
            $comando->bindParam(10, $filasPorPagina, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayInscripcion, array(
                    "Id" => $count + $posicionPagina,
                    "idCurso" => $row["idCurso"],
                    "idParticipante" => $row["idParticipante"],
                    "Serie" => $row["Serie"],
                    "Correlativo" => $row["Correlativo"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"],
                    "Estado" => $row["Estado"],

                    "NumDoc" => $row["NumDoc"],
                    "CIP" => $row["CIP"],
                    "Apellidos" => $row["Apellidos"],
                    "Nombres" => $row["Nombres"],
                    "Capitulo" => $row["Capitulo"],
                    "Especialidad" => $row["Especialidad"],

                    "ApeUsuario" => $row["ApeUsuario"],
                    "NomUsuario" => $row["NomUsuario"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(*) AS Total
            FROM Inscripcion AS i
            INNER JOIN Persona AS p
            ON p.idDNI = i.idParticipante
            LEFT JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            INNER JOIN Usuario AS u 
            ON u.idUsuario = i.idUsuario
            WHERE  
            p.Nombres LIKE CONCAT('%',?,'%') AND i.idCurso = ?
            OR
            p.Apellidos LIKE CONCAT('%',?,'%') AND i.idCurso = ?
            OR
            e.Especialidad LIKE concat('%', ?,'%') AND i.idCurso = ?
            OR
            ca.Capitulo LIKE concat('%', ?,'%') AND i.idCurso = ?");
            $comandoTotal->bindParam(1, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $idCurso, PDO::PARAM_STR);

            $comandoTotal->bindParam(3, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $idCurso, PDO::PARAM_STR);

            $comandoTotal->bindParam(5, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(6, $idCurso, PDO::PARAM_STR);

            $comandoTotal->bindParam(7, $text, PDO::PARAM_STR);
            $comandoTotal->bindParam(8, $idCurso, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            return [
                "inscripcion" => $arrayInscripcion,
                "total" => $resultTotal
            ];
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insert($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Inscripcion WHERE idCurso = ? AND idParticipante = ?");
            $cmdValidate->bindParam(1, $body["idCurso"], PDO::PARAM_STR);
            $cmdValidate->bindParam(2, $body["idParticipante"], PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                Response::sendClient("El ingeniero(a) ya se encuentra registrado.");
            } else {
                $cmdCurso = Database::getInstance()->getDb()->prepare("SELECT Serie,Correlativo FROM Curso WHERE idCurso = ?");
                $cmdCurso->bindParam(1, $body["idCurso"], PDO::PARAM_STR);
                $cmdCurso->execute();
                $cmdResultCurso = $cmdCurso->fetchObject();
                if (!$cmdResultCurso) {
                    Database::getInstance()->getDb()->rollback();
                    Response::sendClient("No se encontro el curso, intente nuevamente.");
                }

                $cmdInscripcion = Database::getInstance()->getDb()->prepare("SELECT Correlativo FROM Inscripcion WHERE idCurso = ?");
                $cmdInscripcion->bindParam(1, $body["idCurso"], PDO::PARAM_STR);
                $cmdInscripcion->execute();
                $resultInscripcion = $cmdInscripcion->fetchAll();

                $correlativo = 0;
                if ($resultInscripcion) {
                    $array = array();
                    foreach ($resultInscripcion as $inscripcion) {
                        array_push($array, $inscripcion["Correlativo"]);
                    }

                    $valorActual = max($array);
                    $incremental = $valorActual + 1;
                    $correlativo = $incremental;
                } else {
                    $correlativo = $cmdResultCurso->Correlativo;
                }


                $cmdInscripcion = Database::getInstance()->getDb()->prepare("INSERT INTO Inscripcion(
                    idCurso,
                    idParticipante,
                    Serie,
                    Correlativo,
                    Hora,
                    Fecha,
                    Estado,
                    idUsuario
                ) VALUES(?,?,?,?,GETDATE(),GETDATE(),?,?)");
                $cmdInscripcion->execute(array(
                    $body["idCurso"],
                    $body["idParticipante"],
                    $cmdResultCurso->Serie,
                    $correlativo,
                    1,
                    $body["idUsuario"],
                ));
                Database::getInstance()->getDb()->commit();
                Response::sendSave("Se registró correctamente su inscripción.");
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }

    public static function delete($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            
            $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM Inscripcion WHERE idCurso = ? AND idParticipante = ?");
            $cmdDelete->bindParam(1, $body["idCurso"], PDO::PARAM_STR);
            $cmdDelete->bindParam(2, $body["idParticipante"], PDO::PARAM_STR);
            $cmdDelete->execute();

            Database::getInstance()->getDb()->commit();
            Response::sendSave("Se eliminó correctamente los datos.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            Response::sendError($ex->getMessage());
        }
    }
}
