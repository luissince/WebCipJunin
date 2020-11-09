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
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM Ingreso
            order by CAST(Fecha as date) asc
            offset ? rows fetch next ? rows only");
            $cmdConcepto->bindParam(1, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id"=>$count+$posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "idDNI" => $row["idDNI"],
                    "numRecibo" => $row["NumRecibo"],
                    "fecha" => $row["Fecha"],
                    "idUsuario" => $row["idUsuario"],
                    "estado" => $row["Estado"],
                    "deposito" => $row["Deposito"],
                    "observacion" => $row["Observacion"],
                    "onlyFecha" => $row["OnlyFecha"]
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
