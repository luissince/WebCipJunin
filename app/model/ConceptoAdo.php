<?php

require_once '../database/DataBaseConexion.php';
date_default_timezone_set('America/Lima');

class ConceptoAdo
{

    public function construct()
    {
    }

    public static function getAll($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayConcepto = array();
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT 
            idConcepto,
            Categoria,
            Concepto,
            Precio,
            Propiedad,
            convert(varchar,cast(Inicio as date), 103) as Inicio,
            convert(varchar,cast(Fin as date), 103) as Fin,
            Observacion,
            Codigo,
            Estado
            FROM Concepto 
            where Concepto like concat(?,'%') 
            order by Categoria asc,Concepto asc,cast(Inicio as date) desc, cast(Fin as date) desc
            offset ? rows fetch next ? rows only");
            $comandoConcepto->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoConcepto->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $comandoConcepto->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $comandoConcepto->execute();
            $count = 0;
            while ($row = $comandoConcepto->fetch()) {
                $count++;
                array_push($arrayConcepto, array(
                    "Id" => $count + $posicionPagina,
                    "idConcepto" => $row["idConcepto"],
                    "Categoria" => $row["Categoria"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => number_format($row["Precio"], 2, ".", ""),
                    "Propiedad" => $row["Propiedad"],
                    "Inicio" => $row["Inicio"],
                    "Fin" => $row["Fin"],
                    "Observacion" => $row["Observacion"],
                    "Codigo" => $row["Codigo"],
                    "Estado" => $row["Estado"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Concepto 
            where Concepto like concat(?,'%') ");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayConcepto, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getId($idConcepto)
    {
        try {
            $object = null;
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT 
                idConcepto,
                Categoria,
                Concepto,
                Precio,
                Propiedad,
                cast(Inicio as date) as Inicio,
                cast(Fin as date) as Fin,
                Observacion,
                Codigo,
                Estado              
            FROM Concepto WHERE idConcepto = ?");
            $comandoConcepto->bindParam(1, $idConcepto, PDO::PARAM_STR);
            $comandoConcepto->execute();
            $object = $comandoConcepto->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCuotas($ingeniero, $categoria, $mes)
    {
        try {

            $array = array();
            $cmdCuota = Database::getInstance()->getDb()->prepare("SELECT 
                cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
                from Persona as p inner join Colegiatura as c
                on p.idDNI = c.idDNI and c.Principal = 1
                left outer join ULTIMACuota as ul
                on p.idDNI = ul.idDNI
                WHERE p.idDNI = ?");
            $cmdCuota->bindParam(1, $ingeniero, PDO::PARAM_INT);
            $cmdCuota->execute();

            if ($row = $cmdCuota->fetch()) {

                $cmdConceptos = "SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
                from Concepto as co
                WHERE  Categoria = ? and Estado = 1 ";
                $cmdConceptos = Database::getInstance()->getDb()->prepare($cmdConceptos);
                $cmdConceptos->bindParam(1, $categoria, PDO::PARAM_INT);
                $cmdConceptos->execute();

                $arryConcepto = array();
                while ($rowc = $cmdConceptos->fetch()) {
                    array_push($arryConcepto, array(
                        "IdConcepto" => $rowc["idConcepto"],
                        "Categoria" => $rowc["Categoria"],
                        "Concepto" => $rowc["Concepto"],
                        "Precio" => $rowc["Precio"],
                    ));
                }

                $date = new DateTime($row["UltimoPago"]);
                $date->setDate($date->format("Y"), $date->format("m"), 1);

                $fechaactual = new DateTime('now');
                if ($fechaactual < $date) {
                    $fechaactual = new DateTime($row["UltimoPago"]);
                    $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    $fechaactual->modify('+ ' . $mes  . ' month');
                } else {
                    $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    $fechaactual->modify('+ ' . $mes  . ' month');
                }

                if ($fechaactual >= $date) {
                    $inicio = $date->modify('+ 1 month');
                    if ($inicio <= $fechaactual) {
                        while ($inicio <= $fechaactual) {
                            array_push($array, array(
                                "day" => $inicio->format('d'),
                                "mes" => $inicio->format('m'),
                                "year" => $inicio->format('Y'),
                                "concepto" => $arryConcepto
                            ));
                            $inicio->modify('+ 1 month');
                        }
                    }
                }
            }

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getColegiatura()
    {
        try {
            $array = array();
            $cmdColegiatura = "SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 4 and Estado = 1 
            ORDER BY Concepto ASC";
            $cmdConcepto = Database::getInstance()->getDb()->prepare($cmdColegiatura);
            $cmdConcepto->execute();
            while ($row = $cmdConcepto->fetch()) {
                array_push($array, array(
                    "IdConcepto" => $row["idConcepto"],
                    "Categoria" => $row["Categoria"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => $row["Precio"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCertificadoHabilidad($dni)
    {
        try {
            $array = array();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1");
            $cmdConcepto->execute();
            $resultConcepto = $cmdConcepto->fetchAll();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT c.idColegiado, c.idEspecialidad, e.Especialidad FROM Colegiatura AS c 
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

            array_push($array, $resultConcepto, $arrayEspecialidades);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCertificadoHabilidadObraPublica($dni)
    {
        try {
            $array = array();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto, Precio FROM Concepto WHERE Categoria = 6 AND Estado = 1");
            $cmdConcepto->execute();
            $resultConcepto = $cmdConcepto->fetchObject();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT c.idColegiado, c.idEspecialidad, e.Especialidad FROM Colegiatura AS c 
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

            array_push($array, $resultConcepto, $arrayEspecialidades);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCertificadoHabilidadProyecto($dni)
    {
        try {
            $array = array();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto, Precio FROM Concepto WHERE Categoria = 7 AND Estado = 1");
            $cmdConcepto->execute();
            $resultConcepto = $cmdConcepto->fetchObject();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT c.idColegiado, c.idEspecialidad, e.Especialidad FROM Colegiatura AS c 
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

            array_push($array, $resultConcepto, $arrayEspecialidades);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getPeritaje()
    {
        try {
            $cmdPeritaje = "SELECT idConcepto,Categoria,Concepto, Precio FROM Concepto WHERE Categoria = 8 AND Estado = 1";
            $cmdConcepto = Database::getInstance()->getDb()->prepare($cmdPeritaje);
            $cmdConcepto->execute();
            $resultConcepto = $cmdConcepto->fetchObject();
            return $resultConcepto;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getOtrosConceptos()
    {
        try {
            $array = array();
            $cmdOtrosConceptos = "SELECT idConcepto ,Categoria,Concepto, Precio FROM Concepto WHERE Categoria = 100 AND Estado = 1
            ORDER BY Concepto ASC";
            $cmdConcepto = Database::getInstance()->getDb()->prepare($cmdOtrosConceptos);
            $cmdConcepto->execute();
            while ($row = $cmdConcepto->fetch()) {
                array_push($array, array(
                    "IdConcepto" => $row["idConcepto"],
                    "Categoria" => $row["Categoria"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => $row["Precio"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public function getUbigeo()
    {
        try {
            $arrayUbigeo = array();

            $cmdUbigeo = Database::getInstance()->getDb()->prepare(" SELECT idUbigeo, CONCAT(Departamento, ' - ', Provincia, ' - ', 
            Distrito) AS Ubicacion FROM Ubigeo ");
            $cmdUbigeo->execute();

            while ($row = $cmdUbigeo->fetch()) {
                array_push($arrayUbigeo, array(
                    'IdUbicacion' => $row['idUbigeo'],
                    'Ubicacion' => $row['Ubicacion'],
                ));
            }

            return $arrayUbigeo;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insert($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("INSERT INTO Concepto(
            Categoria,
            Concepto,
            Precio,
            Propiedad,
            Inicio,
            Fin,
            Observacion,
            Codigo,
            Estado
            )VALUES(?,?,?,?,?,?,?,?,?)");

            $dateTimeInicio = date('Y-d-m H:i:s', strtotime($data["Inicio"]));
            $dateTimeFin = date('Y-d-m H:i:s', strtotime($data["Fin"]));

            $cmdConcepto->bindParam(1, $data["Categoria"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $data["Concepto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["Precio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["Propiedad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $dateTimeInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $dateTimeFin, PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $data["Observacion"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $data["Codigo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(9, $data["Estado"], PDO::PARAM_BOOL);
            $cmdConcepto->execute();
            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function update($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("UPDATE Concepto SET
            Categoria = ?,
            Concepto = ?,
            Precio = ?,
            Propiedad = ?,
            Inicio = ?,
            Fin = ?,
            Observacion = ?,
            Codigo = ?,
            Estado = ?
            WHERE idConcepto = ?");

            $dateTimeInicio = date('Y-d-m H:i:s', strtotime($data["Inicio"]));

            $dateTimeFin = date('Y-d-m H:i:s', strtotime($data["Fin"]));

            $cmdConcepto->bindParam(1, $data["Categoria"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $data["Concepto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["Precio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["Propiedad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $dateTimeInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $dateTimeFin, PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $data["Observacion"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $data["Codigo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(9, $data["Estado"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(10, $data["IdConcepto"], PDO::PARAM_INT);
            $cmdConcepto->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
