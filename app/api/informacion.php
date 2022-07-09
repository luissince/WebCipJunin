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
    echo json_encode(Informacion::getPersonaInformacion($idDni, $mes, $yearCurrentView, $monthCurrentView));
    exit;
}

class Informacion
{
    public static function getPersonaInformacion($idDni, $mes, $yearCurrentView, $monthCurrentView)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI,
            p.Nombres,
            p.Apellidos,
            p.CIP ,
            e.Especialidad,
            ca.Capitulo,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion,
            CAST(ISNULL(uc.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,
            CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 1
            ELSE 0 END AS Habilidad,
            DATEDIFF(YEAR,GETDATE(),DATEADD(MONTH,c.MesAumento,DATEADD(YEAR,30,c.FechaColegiado))) CumplirTreinta
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca ON ca.idCapitulo = e.idCapitulo
            LEFT OUTER JOIN ULTIMACuota AS uc ON uc.idDNI = p.idDNI
            WHERE p.idDNI = ?");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultInformacion = $cmdValidate->fetch(PDO::FETCH_ASSOC);

            $web = Database::getInstance()->getDb()->prepare("SELECT TOP 1 w.Direccion 
            FROM Persona AS p
            INNER JOIN Web AS w
            ON p.idDNI = w.idDNI
            WHERE p.idDNI = ?");
            $web->bindParam(1, $idDni, PDO::PARAM_STR);
            $web->execute();

            $email = "";
            if ($row = $web->fetchObject()) {
                $email = $row->Direccion;
            }

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

            $montodeuda = 0;

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
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();

                                while ($rowc = $cmdConceptos->fetch()) {
                                    $montodeuda += floatval($rowc["Precio"]);
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
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();

                                while ($rowc = $cmdConceptos->fetch()) {
                                    $montodeuda += floatval($rowc["Precio"]);
                                }
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return array("state" => 1, "persona" => $resultInformacion, "email" => $email, "deuda" => $montodeuda);
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }
}


// $body = json_decode(file_get_contents("php://input"), true);
// $postdata = http_build_query(
//     array(
//         'idDni' => $body["idDni"],
//     )
// );
// $opts = array(
//     'http' =>
//     array(
//         'method'  => 'POST',
//         'header'  => 'Content-Type: application/x-www-form-urlencoded',
//         'content' => $postdata
//     )
// );

// $context  = stream_context_create($opts);
// $data = file_get_contents('http://localhost:5000/api/informacion', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
