<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\DataBase\Database;

require __DIR__ . './../src/autoload.php';

date_default_timezone_set('America/Lima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    $mes = $body["mes"];
    $yearCurrentView = $body["yearCurrentView"];
    $monthCurrentView = $body["monthCurrentView"];
    echo json_encode(Cuotas::getCuotas($idDni, $mes, $yearCurrentView, $monthCurrentView));
    exit;
}

class Cuotas
{
    public static function getCuotas($idDni, $mes, $yearCurrentView, $monthCurrentView)
    {
        try {

            $array = array();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            CASE p.Condicion 
            WHEN 'V' THEN 'VITALICIO' 
            WHEN 'R' THEN 'RETIRADO' 
            WHEN 'F' THEN 'FALLECIDO' 
            WHEN 'T' THEN 'TRANSEUNTE' 
            ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
            WHERE p.idDNI = ?");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultInformacion = $cmdValidate->fetch(PDO::FETCH_ASSOC);

            $cmdCuota = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado) AS DATE) AS UltimoPago     
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdCuota->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdCuota->execute();

            if ($resultInformacion["Condicion"] == "ORDINARIO") {
                $condicion =  1;
            } else if ($resultInformacion["Condicion"] == "VITALICIO") {
                $condicion =  3;
            } else {
                $condicion =  0;
            }


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


                $cmdAltaColegiado = Database::getInstance()->getDb()->prepare("SELECT * FROM 
                Persona AS  p
                INNER JOIN Ingreso AS i ON i.idDNI = p.idDNI
                INNER JOIN Cuota as c ON c.idIngreso = i.idIngreso
                WHERE i.idDNI = ? ");
                $cmdAltaColegiado->bindParam(1, $idDni, PDO::PARAM_INT);
                $cmdAltaColegiado->execute();
                if ($cmdAltaColegiado->fetch()) {
                    if ($fechaactual >= $date) {
                        $inicio = $date->modify('+ 1 month');
                        if ($inicio <= $fechaactual) {
                            while ($inicio <= $fechaactual) {
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT 
                                co.idConcepto,
                                co.Concepto,
                                co.Categoria,
                                co.Precio       
                                FROM Concepto AS co
                                WHERE Categoria = ? AND ? BETWEEN Inicio AND Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();
                                $resultConcepto =  $cmdConceptos->fetchAll();

                                if (count($resultConcepto) != 0) {
                                    $arryConcepto = array();
                                    foreach ($resultConcepto as $rowc) {
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
                                }
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

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT 
                                co.idConcepto,
                                co.Concepto,
                                co.Categoria,
                                co.Precio       
                                FROM Concepto AS co
                                WHERE Categoria = ? AND ? BETWEEN Inicio AND Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();
                                $resultConcepto =  $cmdConceptos->fetchAll();

                                if (count($resultConcepto) != 0) {
                                    $arryConcepto = array();
                                    foreach ($resultConcepto as $rowc) {
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
                                }
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return array("state" => 1, "data" => $array);
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }
}
