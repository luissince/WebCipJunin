<?php

require_once '../database/DataBaseConexion.php';

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
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM Concepto 
            where Concepto like concat(?,'%') 
            order by Categoria asc,cast(Inicio as date) desc, cast(Fin as date) desc
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
                    "Codigo" => $row["Codigo"]
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

    public static function getColegiatura(){
        try{
            $array = array();
            $cmdColegiatura = "SELECT * FROM Concepto 
            WHERE Categoria = 4 and Fin < GETDATE()  
            ORDER BY Concepto ASC";
            $cmdConcepto =Database::getInstance()->getDb()->prepare($cmdColegiatura);
            $cmdConcepto->execute();
            while($row = $cmdConcepto->fetch()){
                array_push($array,array(
                    "idConcepto"=>$row["idConcepto"],
                    "Concepto"=>$row["Concepto"],
                    "Precio"=>number_format($row["Precio"],2,".","")
                ));
            }
            return $array;
        }catch(Exception $ex){
             return $ex->getMessage();
        }
    }

    public static function getCuotas(){
        try{
            $array = array();
            $cmdCuotas = "SELECT 10 as Fechas,SUM(Precio) AS Precio FROM Concepto 
            WHERE Categoria = 1 and Inicio <= GETDATE() and Fin >= GETDATE()";
            $cmdConcepto =Database::getInstance()->getDb()->prepare($cmdCuotas);
            $cmdConcepto->execute();
            if($row = $cmdConcepto->fetch()){
               for($i = 0; $i < intval($row["Fechas"]); $i++){
                    array_push($array,array(
                        "Fechas"=>($i+1),
                        "Precio"=>number_format($row["Precio"],2,".","")
                    ));
               }                
            }
            return $array;
        }catch(Exception $ex){
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
            Codigo
            )VALUES(?,?,?,?,?,?,?,?)");

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
            Codigo = ?
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
            $cmdConcepto->bindParam(9, $data["IdConcepto"], PDO::PARAM_INT);
            $cmdConcepto->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

}
