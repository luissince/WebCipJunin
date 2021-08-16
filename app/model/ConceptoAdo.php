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
            c.idConcepto,
            c.Categoria,
            c.Concepto,
            c.Precio,
            c.Propiedad,
            CONVERT(VARCHAR,CAST(Inicio AS DATE), 103) AS Inicio,
            CONVERT(VARCHAR,CAST(Fin AS DATE), 103) AS Fin,
            c.Observacion,
            c.Codigo,
            c.Estado, 
            c.Asignado,
            i.Nombre AS Impuesto
            FROM Concepto AS c INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto
            WHERE 
            ? = 0
            OR
            ? = 1 AND c.Codigo = ?
            OR
            ? = 1 AND c.Concepto LIKE CONCAT(?,'%') 
            OR
            ? = 2 AND c.Categoria = ?
            ORDER BY c.Categoria ASC,c.Concepto ASC,CAST(c.Inicio AS DATE) DESC, CAST(c.Fin AS DATE) DESC
            OFFSET ? ROWS FETCH NEXT ? ROWS ONLY");
            $comandoConcepto->bindParam(1, $opcion, PDO::PARAM_INT);

            $comandoConcepto->bindParam(2, $opcion, PDO::PARAM_INT);
            $comandoConcepto->bindParam(3, $nombres, PDO::PARAM_STR);

            $comandoConcepto->bindParam(4, $opcion, PDO::PARAM_INT);
            $comandoConcepto->bindParam(5, $nombres, PDO::PARAM_STR);

            $comandoConcepto->bindParam(6, $opcion, PDO::PARAM_INT);
            $comandoConcepto->bindParam(7, $categoria, PDO::PARAM_INT);

            $comandoConcepto->bindParam(8, $posicionPagina, PDO::PARAM_INT);
            $comandoConcepto->bindParam(9, $filasPorPagina, PDO::PARAM_INT);
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
                    "Impuesto" => $row["Impuesto"]
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) 
            FROM Concepto AS c INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto 
            WHERE 
            ? = 0
            OR
            ? = 1 AND c.Codigo = ?
            OR
            ? = 1 AND c.Concepto LIKE concat(?,'%') 
            OR
            ? = 2 AND c.Categoria = ?");
            $comandoTotal->bindParam(1, $opcion, PDO::PARAM_INT);

            $comandoTotal->bindParam(2, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(3, $nombres, PDO::PARAM_STR);

            $comandoTotal->bindParam(4, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(5, $nombres, PDO::PARAM_STR);

            $comandoTotal->bindParam(6, $opcion, PDO::PARAM_INT);
            $comandoTotal->bindParam(7, $categoria, PDO::PARAM_INT);
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
            $array = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT 
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
                Asignado,
                IdImpuesto       
            FROM Concepto WHERE idConcepto = ?");
            $cmdConcepto->bindParam(1, $idConcepto, PDO::PARAM_STR);
            $cmdConcepto->execute();
            $object = $cmdConcepto->fetchObject();

            $cmdImpuesto = Database::getInstance()->getDb()->prepare("SELECT IdImpuesto,Nombre FROM Impuesto");
            $cmdImpuesto->execute();
            $impuestos = $cmdImpuesto->fetchAll(PDO::FETCH_ASSOC);

            array_push($array, $object, $impuestos);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCuotas($ingeniero, $categoria, $mes, $yearCurrentView, $monthCurrentView)
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

                $date = new DateTime($row["UltimoPago"]);
                $date->setDate($date->format("Y"), $date->format("m"), 1);

                $fechaactual = new DateTime('now');
                if ($fechaactual < $date) {
                    $fechaactual = new DateTime($row["UltimoPago"]);
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
                    $fechaactual->modify('+ ' . $mes  . ' month');
                } else {
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
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
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
                                FROM Concepto as co
                                WHERE  Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $categoria, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
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
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $categoria, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
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

    // public static function getCuotasMob($ingeniero, $categoria, $mes, $yearCurrentView, $monthCurrentView)
    // {
    //     try {

    //         $array = array();
    //         $cmdCuota = Database::getInstance()->getDb()->prepare("SELECT 
    //         cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
    //         from Persona as p inner join Colegiatura as c
    //         on p.idDNI = c.idDNI and c.Principal = 1
    //         left outer join ULTIMACuota as ul
    //         on p.idDNI = ul.idDNI
    //         WHERE p.idDNI = ?");
    //         $cmdCuota->bindParam(1, $ingeniero, PDO::PARAM_INT);
    //         $cmdCuota->execute();

    //         if ($row = $cmdCuota->fetch()) {

    //             $ano = new DateTime($row["UltimoPago"]);
    //             $hoy =  new DateTime('now');

    //             while ($ano <= $hoy) {

    //                 $formatano =  $ano->format('Y') . '-' . $ano->format('m') . '-' . $ano->format('d');

    //                 $cmdConceptos = "SELECT co.idConcepto,co.Concepto,co.Categoria,co.Precio       
    //                 from Concepto as co
    //                 WHERE  Categoria = ? and ? between Inicio and Fin";
    //                 $cmdConceptos = Database::getInstance()->getDb()->prepare($cmdConceptos);
    //                 $cmdConceptos->bindParam(1, $categoria, PDO::PARAM_INT);
    //                 $cmdConceptos->bindParam(2, $formatano, PDO::PARAM_STR);
    //                 $cmdConceptos->execute();

    //                 $arryConcepto = array();
    //                 while ($rowc = $cmdConceptos->fetch()) {
    //                     array_push($arryConcepto, array(
    //                         "IdConcepto" => $rowc["idConcepto"],
    //                         "Categoria" => $rowc["Categoria"],
    //                         "Concepto" => $rowc["Concepto"],
    //                         "Precio" => $rowc["Precio"],
    //                     ));
    //                 }

    //                 $date = new DateTime($row["UltimoPago"]);
    //                 $date->setDate($date->format("Y"), $date->format("m"), 1);

    //                 $fechaactual = new DateTime('now');
    //                 if ($fechaactual < $date) {
    //                     $fechaactual = new DateTime($row["UltimoPago"]);
    //                     if ($yearCurrentView == "" && $monthCurrentView == "") {
    //                         $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
    //                     } else {
    //                         $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
    //                     }
    //                     $fechaactual->modify('+ ' . $mes  . ' month');
    //                 } else {
    //                     if ($yearCurrentView == "" && $monthCurrentView == "") {
    //                         $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
    //                     } else {
    //                         $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
    //                     }
    //                     $fechaactual->modify('+ ' . $mes  . ' month');
    //                 }

    //                 $cmdAltaColegiado = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona AS  p
    //                 INNER JOIN Ingreso AS i ON i.idDNI = p.idDNI
    //                 INNER JOIN Cuota as c on c.idIngreso = i.idIngreso
    //                 WHERE i.idDNI = ? ");
    //                 $cmdAltaColegiado->bindParam(1, $ingeniero, PDO::PARAM_INT);
    //                 $cmdAltaColegiado->execute();

    //                 if ($cmdAltaColegiado->fetch()) {
    //                     // if ($fechaactual >= $date) {
    //                     $inicio = $ano;
    //                     // $inicio = $ano->modify('+ 1 month');
    //                     // if ($inicio <= $fechaactual) {
    //                     // while ($inicio <= $fechaactual) {
    //                     array_push($array, array(
    //                         "day" => $inicio->format('d'),
    //                         "mes" => $inicio->format('m'),
    //                         "year" => $inicio->format('Y'),
    //                         "concepto" => $arryConcepto
    //                     ));
    //                     // $inicio->modify('+ 1 month');
    //                     // }
    //                     // }
    //                     // }
    //                 } else {
    //                     // if ($fechaactual >= $date) {
    //                     $inicio = $ano;
    //                     // if ($inicio <= $fechaactual) {
    //                     // while ($inicio <= $fechaactual) {
    //                     array_push($array, array(
    //                         "day" => $inicio->format('d'),
    //                         "mes" => $inicio->format('m'),
    //                         "year" => $inicio->format('Y'),
    //                         "concepto" => $arryConcepto
    //                     ));
    //                     // $inicio->modify('+ 1 month');
    //                     // }
    //                     // }
    //                     // }
    //                 }


    //                 $ano->modify('+ 1 month');
    //             }
    //         }

    //         return $array;
    //     } catch (Exception $ex) {
    //         return $ex->getMessage();
    //     }
    // }

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

            $cmdIngeniero = Database::getInstance()->getDb()->prepare("SELECT Condicion FROM Persona WHERE idDNI = ?");
            $cmdIngeniero->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdIngeniero->execute();
            $resultIngeniero = $cmdIngeniero->fetch(PDO::FETCH_ASSOC);

            if ($resultIngeniero["Condicion"] == "T") {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 1");
                $cmdConcepto->execute();
                $resultConcepto = $cmdConcepto->fetchObject();
                if (!$resultConcepto) {
                    throw new Exception('No se encontro ningún concepto para obtener.');
                }
            } else {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT idConcepto,Categoria,Concepto,Precio FROM Concepto WHERE Categoria = 5 AND Estado = 1 AND Asignado = 0");
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
            if ($resultIngeniero["Condicion"] == "V") {
                $date->modify('+9 month');
                $date->modify('last day of this month');
            } else {
                $date->modify('+3 month');
                $date->modify('last day of this month');
            }


            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 1");
            $cmdCorrelativo->execute();
            if (!$cmdCorrelativo->fetch()) {
                $resultCorrelativo = 1;
            } else {
                $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT MAX(Numero)+1 FROM CorrelativoCERT WHERE TipoCert = 1");
                $cmdCorrelativo->execute();
                $resultCorrelativo = $cmdCorrelativo->fetchColumn();
            }


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

            $cmdIngeniero = Database::getInstance()->getDb()->prepare("SELECT Condicion FROM Persona WHERE idDNI = ?");
            $cmdIngeniero->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdIngeniero->execute();
            $resultIngeniero = $cmdIngeniero->fetch(PDO::FETCH_ASSOC);

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
            if ($resultIngeniero["Condicion"] == "V") {
                $date->modify('+9 month');
                $date->modify('last day of this month');
            } else {
                $date->modify('+3 month');
                $date->modify('last day of this month');
            }

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

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 2");
            $cmdCorrelativo->execute();
            if (!$cmdCorrelativo->fetch()) {
                $resultCorrelativo = 1;
            } else {
                $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT MAX(Numero)+1 FROM CorrelativoCERT WHERE TipoCert = 2");
                $cmdCorrelativo->execute();
                $resultCorrelativo = $cmdCorrelativo->fetchColumn();
            }

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

            $cmdIngeniero = Database::getInstance()->getDb()->prepare("SELECT Condicion FROM Persona WHERE idDNI = ?");
            $cmdIngeniero->bindParam(1, $dni, PDO::PARAM_STR);
            $cmdIngeniero->execute();
            $resultIngeniero = $cmdIngeniero->fetch(PDO::FETCH_ASSOC);

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
            if ($resultIngeniero["Condicion"] == "V") {
                $date->modify('+9 month');
                $date->modify('last day of this month');
            } else {
                $date->modify('+3 month');
                $date->modify('last day of this month');
            }

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

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 3");
            $cmdCorrelativo->execute();
            if (!$cmdCorrelativo->fetch()) {
                $resultCorrelativo = 1;
            } else {
                $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT MAX(Numero)+1 FROM CorrelativoCERT WHERE TipoCert = 3");
                $cmdCorrelativo->execute();
                $resultCorrelativo = $cmdCorrelativo->fetchColumn();
            }

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

    public static function getCertHabilidad($idIngreso)
    {
        try {
            $array = array();
            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT 
            ch.idHabilidad, 
            ch.HastaFecha as Fecha, 
            ch.Numero, 
            ch.Asunto, 
            ch.Lugar, 
            ch.Entidad, 
            ch.idColegiatura, 
            e.Especialidad, 
            p.idDNI, 
            p.Apellidos, 
            p.Nombres 
            FROM CERTHabilidad AS ch  
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = ch.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            WHERE ch.idIngreso = ? ");
            $cmdCertificado->bindParam(1, $idIngreso, PDO::PARAM_STR);
            $cmdCertificado->execute();

            $objetCertificado = $cmdCertificado->fetchObject();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado, 
            c.idEspecialidad, 
            e.Especialidad 
            FROM Colegiatura AS c 
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad 
            WHERE c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $objetCertificado->idDNI, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

            array_push($array, $objetCertificado, $arrayEspecialidades);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCertObra($idIngreso)
    {
        try {
            $array = array();
            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.Apellidos, 
            p.Nombres, 
            co.idColegiatura, 
            co.idResidencia, 
            co.HastaFecha, 
            co.Numero, 
            co.Modalidad, 
            co.Proyecto, 
            co.Propietario,
            co.idUbigeo 
            FROM CERTResidencia AS co 
            INNER JOIN Ingreso AS i ON i.idIngreso = co.idIngreso
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = co.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            where co.idIngreso = ? ");
            $cmdCertificado->bindParam(1, $idIngreso, PDO::PARAM_STR);
            $cmdCertificado->execute();

            $objetCertificado = $cmdCertificado->fetchObject();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado, 
            c.idEspecialidad, 
            e.Especialidad 
            FROM Colegiatura AS c 
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad where c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $objetCertificado->idDNI, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

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

            array_push($array, $objetCertificado, $arrayEspecialidades, $arrayUbigeo);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCertProyecto($idIngreso)
    {
        try {
            $array = array();
            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.Apellidos, 
            p.Nombres, 
            cp.idColegiatura, 
            cp.idProyecto, 
            cp.HastaFecha, 
            cp.Numero, 
            cp.Modalidad, 
            cp.Proyecto, 
            cp.Propietario,
            cp.idUbigeo, 
            cp.Adicional1, 
            cp.Adicional2 
            FROM CERTProyecto AS cp 
            INNER JOIN Ingreso AS i ON i.idIngreso = cp.idIngreso
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND  c.idColegiado = cp.idColegiatura
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            where cp.idIngreso = ?");
            $cmdCertificado->bindParam(1, $idIngreso, PDO::PARAM_STR);
            $cmdCertificado->execute();

            $objetCertificado = $cmdCertificado->fetchObject();

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado, 
            c.idEspecialidad, 
            e.Especialidad 
            FROM Colegiatura AS c 
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad 
            WHERE c.idDNI = ?");
            $cmdEspecialidad->bindParam(1, $objetCertificado->idDNI, PDO::PARAM_STR);
            $cmdEspecialidad->execute();

            $arrayEspecialidades = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidades, array(
                    "idColegiado" => $row["idColegiado"],
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Especialidad" => $row["Especialidad"]
                ));
            }

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

            array_push($array, $objetCertificado, $arrayEspecialidades, $arrayUbigeo);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function updateCertHabilidad($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("UPDATE CERTHabilidad SET
                Asunto = ?,
                Entidad = ?,
                Lugar = ?,
                idColegiatura = ?
                WHERE idHabilidad = ?");

            $cmdConcepto->bindParam(1, $data["asunto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $data["entidad"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["lugar"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["especialidad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $data["idCertHabilidad"], PDO::PARAM_INT);
            $cmdConcepto->execute();

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateCertObra($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("UPDATE CERTResidencia SET
                Modalidad = ?,
                Propietario = ?,
                Proyecto = ?,
                idColegiatura = ?,
                idUbigeo = ?
                WHERE idResidencia = ?");

            $cmdConcepto->bindParam(1, $data["modalidad"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $data["propietario"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["proyecto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["especialidad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $data["ubigeo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(6, $data["idCertObra"], PDO::PARAM_INT);
            $cmdConcepto->execute();

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateCertProyecto($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdConcepto = Database::getInstance()->getDb()->prepare("UPDATE CERTProyecto SET
                Modalidad = ?,
                Propietario = ?,
                Proyecto = ?,
                idColegiatura = ?,
                idUbigeo = ?,
                Adicional1 = ?,
                Adicional2 = ?
                WHERE idProyecto = ?");

            $cmdConcepto->bindParam(1, $data["modalidad"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $data["propietario"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $data["proyecto"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $data["especialidad"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(5, $data["ubigeo"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(6, $data["adicional1"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $data["adicional2"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $data["idCertProyecto"], PDO::PARAM_INT);
            $cmdConcepto->execute();

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
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
            Estado,
            IdImpuesto          
            )VALUES(?,?,?,?,?,?,?,?,?,?,?)");

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
            $cmdConcepto->bindParam(11, $data["Impuesto"], PDO::PARAM_INT);

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
            Asignado =?,
            IdImpuesto =?
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
            $cmdConcepto->bindParam(11, $data["Impuesto"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(12, $data["IdConcepto"], PDO::PARAM_INT);
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

    public static function getAllCorrelativoCert()
    {
        try {
            $array = array();

            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 1");
            $cmdCertificado->execute();

            if (!$cmdCertificado->fetch()) {
                array_push($array, array(
                    "Id" => 1,
                    "Nombre" => "Certificado de Habilidad",
                    "Numero" => "0",
                ));
            } else {
                $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT MIN(Numero) FROM CorrelativoCERT WHERE TipoCert = 1");
                $cmdCertificado->execute();
                $numeracion = $cmdCertificado->fetchColumn();
                array_push($array, array(
                    "Id" => 1,
                    "Nombre" => "Certificado de Habilidad",
                    "Numero" => $numeracion + 1,
                ));
            }

            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 2");
            $cmdCertificado->execute();

            if (!$cmdCertificado->fetch()) {
                array_push($array, array(
                    "Id" => 2,
                    "Nombre" => "Certificado de Obra Pública",
                    "Numero" => "0",
                ));
            } else {
                $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT MIN(Numero) FROM CorrelativoCERT WHERE TipoCert = 2");
                $cmdCertificado->execute();
                $numeracion = $cmdCertificado->fetchColumn();
                array_push($array, array(
                    "Id" => 2,
                    "Nombre" => "Certificado de Obra Pública",
                    "Numero" => $numeracion + 1,
                ));
            }

            $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 3");
            $cmdCertificado->execute();

            if (!$cmdCertificado->fetch()) {
                array_push($array, array(
                    "Id" => 3,
                    "Nombre" => "Certificado de Proyecto",
                    "Numero" => "0",
                ));
            } else {
                $cmdCertificado = Database::getInstance()->getDb()->prepare("SELECT MIN(Numero) FROM CorrelativoCERT WHERE TipoCert = 3");
                $cmdCertificado->execute();
                $numeracion = $cmdCertificado->fetchColumn();
                array_push($array, array(
                    "Id" => 3,
                    "Nombre" => "Certificado de Proyecto",
                    "Numero" => $numeracion + 1,
                ));
            }

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function updateResetCorrelativo($tipo, $correlativo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdDelete = Database::getInstance()->getDb()->prepare("DELETE FROM CorrelativoCERT WHERE TipoCert = ?");
            $cmdDelete->bindParam(1, $tipo, PDO::PARAM_INT);
            $cmdDelete->execute();

            $cmdUpdate = Database::getInstance()->getDb()->prepare("INSERT INTO CorrelativoCERT(TipoCert,Numero) VALUES(?,?)");
            $cmdUpdate->bindParam(1, $tipo, PDO::PARAM_INT);
            $cmdUpdate->bindParam(2, $correlativo, PDO::PARAM_INT);
            $cmdUpdate->execute();

            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
