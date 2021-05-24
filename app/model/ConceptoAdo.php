<?php

require_once '../database/DataBaseConexion.php';
date_default_timezone_set('America/Lima');

class ConceptoAdo
{

    public function construct()
    {
    }

    public static function getAll($opcion, $nombres, $categoria, $posicionPagina, $filasPorPagina)
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
            Estado, 
            Asignado
            FROM Concepto 
            where 
            ? = 0
            OR
            ? = 1 AND Concepto like concat(?,'%') 
            OR
            ? = 2 AND Categoria = ?
            order by Categoria asc,Concepto asc,cast(Inicio as date) desc, cast(Fin as date) desc
            offset ? rows fetch next ? rows only");
            $comandoConcepto->bindParam(1, $opcion, PDO::PARAM_INT);

            $comandoConcepto->bindParam(2, $opcion, PDO::PARAM_INT);
            $comandoConcepto->bindParam(3, $nombres, PDO::PARAM_STR);

            $comandoConcepto->bindParam(4, $opcion, PDO::PARAM_INT);
            $comandoConcepto->bindParam(5, $categoria, PDO::PARAM_INT);

            $comandoConcepto->bindParam(6, $posicionPagina, PDO::PARAM_INT);
            $comandoConcepto->bindParam(7, $filasPorPagina, PDO::PARAM_INT);
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
                    "Asignado" => $row["Asignado"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Concepto 
            where 
            ? = 0
            OR
            ? = 1 AND Concepto like concat(?,'%') 
            OR
            ? = 2 AND Categoria = ?");
            $comandoTotal->bindParam(1, $opcion, PDO::PARAM_INT);

            $comandoTotal->bindParam(2, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(3, $nombres, PDO::PARAM_STR);

            $comandoTotal->bindParam(4, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(5, $categoria, PDO::PARAM_INT);
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
                Estado,
                Asignado       
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

                $cmdAltaColegiado = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona AS  p
                INNER JOIN Ingreso AS i ON i.idDNI = p.idDNI
                INNER JOIN Cuota as c on c.idIngreso = i.idIngreso
                WHERE i.idDNI = ? ");
                $cmdAltaColegiado->bindParam(1, $ingeniero, PDO::PARAM_INT);
                $cmdAltaColegiado->execute();
                if ($cmdAltaColegiado->fetch()) {
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
                } else {
                    if ($fechaactual >= $date) {
                        $inicio = $date;
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
            }

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getColegiatura($tipoCategoria)
    {
        try {
            $array = array();
            $cmdColegiatura = "SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = ? and Estado = 1 
            ORDER BY Concepto ASC";
            $cmdConcepto = Database::getInstance()->getDb()->prepare($cmdColegiatura);
            $cmdConcepto->bindParam(1, $tipoCategoria, PDO::PARAM_STR);
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

            $cmdIngeniero = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE idDNI = ? AND Condicion = 'T' ");
            $cmdIngeniero->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdIngeniero->execute();

            if (!$cmdIngeniero->fetch()) {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 0");
                $cmdConcepto->execute();
                $resultConcepto = $cmdConcepto->fetchObject();
                if (!$resultConcepto) {
                    throw new Exception('No se encontro ningún concepto para obtener.');
                }
            } else {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 1");
                $cmdConcepto->execute();
                $resultConcepto = $cmdConcepto->fetchObject();
                if (!$resultConcepto) {
                    throw new Exception('No se encontro ningún concepto para obtener.');
                }
            }


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

            if (empty($arrayEspecialidades)) {
                throw new Exception('Error en cargar en las espcialidad(es).');
            }

            $cmdUltimoPago = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
            from Persona as p inner join Colegiatura as c
            on p.idDNI = c.idDNI and c.Principal = 1
            left outer join ULTIMACuota as ul
            on p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdUltimoPago->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdUltimoPago->execute();
            $resultPago = $cmdUltimoPago->fetchColumn();

            $date = new DateTime($resultPago);
            $date->modify('+3 month');
            $date->modify('last day of this month');

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT ISNULL(MAX(Numero)+1,1) FROM CERTHabilidad");
            $cmdCorrelativo->execute();
            $resultCorrelativo = $cmdCorrelativo->fetchColumn();

            array_push($array, $resultConcepto, $arrayEspecialidades, $date->format('Y-m-d'), $resultCorrelativo);
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
            if (!$resultConcepto) {
                throw new Exception('No se encontro ningún concepto para obtener.');
            }

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

            if (empty($arrayEspecialidades)) {
                throw new Exception('Error en cargar en las espcialidad(es).');
            }

            $cmdUltimoPago = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
            from Persona as p inner join Colegiatura as c
            on p.idDNI = c.idDNI and c.Principal = 1
            left outer join ULTIMACuota as ul
            on p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdUltimoPago->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdUltimoPago->execute();
            $resultPago = $cmdUltimoPago->fetchColumn();

            $date = new DateTime($resultPago);
            $date->modify('+3 month');
            $date->modify('last day of this month');

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

            if (empty($arrayUbigeo)) {
                throw new Exception('Error en cargar el ubigeo.');
            }

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT ISNULL(MAX(Numero)+1,1) FROM CERTResidencia");
            $cmdCorrelativo->execute();
            $resultCorrelativo = $cmdCorrelativo->fetchColumn();

            array_push($array, $resultConcepto, $arrayEspecialidades, $date->format('Y-m-d'), $arrayUbigeo, $resultCorrelativo);
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
            if (!$resultConcepto) {
                throw new Exception('No se encontro ningún concepto para obtener.');
            }

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

            if (empty($arrayEspecialidades)) {
                throw new Exception('Error en cargar en las espcialidad(es).');
            }

            $cmdUltimoPago = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
            from Persona as p inner join Colegiatura as c
            on p.idDNI = c.idDNI and c.Principal = 1
            left outer join ULTIMACuota as ul
            on p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdUltimoPago->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdUltimoPago->execute();
            $resultPago = $cmdUltimoPago->fetchColumn();

            $date = new DateTime($resultPago);
            $date->modify('+3 month');
            $date->modify('last day of this month');

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

            if (empty($arrayUbigeo)) {
                throw new Exception('Error en cargar el ubigeo.');
            }

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT ISNULL(MAX(Numero)+1,1) FROM CERTProyecto");
            $cmdCorrelativo->execute();
            $resultCorrelativo = $cmdCorrelativo->fetchColumn();

            array_push($array, $resultConcepto, $arrayEspecialidades, $date->format('Y-m-d'), $arrayUbigeo, $resultCorrelativo);
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
            if (!$resultConcepto) {
                throw new Exception('No se encontro ningún concepto para obtener.');
            }
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

    public static function getUbigeo()
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
            Asignado,
            Observacion,
            Codigo,
            Estado          
            )VALUES(?,?,?,?,?,?,?,?,?,?)");

            // $dateTimeInicio = date('Y-d-m H:i:s', strtotime($data["Inicio"]));
            // $dateTimeFin = date('Y-d-m H:i:s', strtotime($data["Fin"]));

            $cmdConcepto->bindParam(1, $data["Categoria"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $data["Concepto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["Precio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["Propiedad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $data["Inicio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $data["Fin"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $data["Asignado"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(8, $data["Observacion"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(9, $data["Codigo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(10, $data["Estado"], PDO::PARAM_BOOL);

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
            Estado = ?,
            Asignado =?
            WHERE idConcepto = ?");

            $cmdConcepto->bindParam(1, $data["Categoria"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $data["Concepto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["Precio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["Propiedad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $data["Inicio"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $data["Fin"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $data["Observacion"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $data["Codigo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(9, $data["Estado"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(10, $data["Asignado"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(11, $data["IdConcepto"], PDO::PARAM_INT);
            $cmdConcepto->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteConcepto($concepto)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Detalle WHERE idConcepto = ?");
            $cmdValidate->bindParam(1, $concepto["idConcepto"], PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "use";
            } else {
                $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Concepto WHERE idConcepto = ?");
                $comandSelect->bindParam(1, $concepto["idConcepto"], PDO::PARAM_INT);
                $comandSelect->execute();
                Database::getInstance()->getDb()->commit();
                return "eliminado";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function validateCertNum($numero)
    {
        try {
            $comandSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM CERTHabilidad WHERE Numero = ?");
            $comandSelect->bindParam(1, $numero, PDO::PARAM_INT);
            $comandSelect->execute();
            if ($comandSelect->fetch()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return false;
        }
    }
}
