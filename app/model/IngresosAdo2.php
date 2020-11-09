<?php

require_once '../database/DataBaseConexion.php';

class IngresosAdo2
{

    public function construct()
    {
    }


    public static function RegistrarIngresos($posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT i.idIngreso,convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,i.Serie,i.NumRecibo,
            p.CIP,p.idDNI,p.Apellidos,p.Nombres,sum(d.Monto) AS Total
            FROM Ingreso AS i INNER JOIN Persona AS p
            ON i.idDNI = p.idDNI
            INNER JOIN Detalle AS d 
            ON d.idIngreso = i.idIngreso
            GROUP BY i.idIngreso,i.Fecha,i.Serie,i.NumRecibo,
            p.CIP,p.idDNI,p.Apellidos,p.Nombres
            ORDER BY CAST(Fecha AS DATE) ASC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdConcepto->bindParam(1, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id"=>$count+$posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "fecha" => $row["Fecha"],
                    "serie" => $row["Serie"],
                    "numRecibo" => $row["NumRecibo"],
                    "cip" => $row["CIP"],
                    "idDNI" => $row["idDNI"],
                    "apellidos" => $row["Apellidos"],
                    "nombres" => $row["Nombres"],
                    "total" => $row["Total"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Ingreso");
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayIngresos, $resultTotal);
            return $array;

        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }
}
