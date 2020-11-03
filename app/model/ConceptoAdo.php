<?php

require_once '../database/DataBaseConexion.php';

class ConceptoAdo{

    public function construct()
    {
    } 

    public static function getAll($nombres,$posicionPagina,$filasPorPagina){
        try {
            $array = array();
            $arrayConcepto = array();
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM Concepto 
            where Concepto like concat(?,'%')
            order by CAST(Inicio as date) DESC
            offset ? rows fetch next ? rows only");
            $comandoConcepto->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoConcepto->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $comandoConcepto->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $comandoConcepto->execute();
            $count = 0;
            while ($row = $comandoConcepto->fetch()) {
                $count++;
                array_push($arrayConcepto, array(
                    "Id" => $count+$posicionPagina,
                    "idConcepto"=>$row["idConcepto"],
                    "Categoria"=>$row["Categoria"],
                    "Concepto"=>$row["Concepto"],
                    "Precio"=>number_format($row["Precio"],2,".",""),
                    "Propiedad"=>$row["Propiedad"],
                    "Inicio"=>$row["Inicio"],
                    "Fin"=>$row["Fin"],
                    "Observacion"=>$row["Observacion"],
                    "Codigo"=>$row["Codigo"]
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

    public static function getId($idConcepto){
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
                Codigo              
            FROM Concepto WHERE idConcepto = ?");
            $comandoConcepto->bindParam(1, $idConcepto, PDO::PARAM_STR);
            $comandoConcepto->execute();
            $object = $comandoConcepto->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}