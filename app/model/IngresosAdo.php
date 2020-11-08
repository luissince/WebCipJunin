<?php

require_once '../database/DataBaseConexion.php';

class IngresosAdo
{

    public function construct()
    {
    }


    public static function RegistrarIngresos($body)
    {
        try {

            Database::getInstance()->getDb()->beginTransaction();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("INSERT INTO Ingreso(
            idDni,
            NumRecibo,
            Fecha,
            idUsuario,
            Estado,
            Deposito,
            Observacion
            )VALUES(?,?,GETDATE(),?,?,0,'')");
            $cmdConcepto->bindParam(1, $body["idCliente"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $body["numRecibo"], PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $body["idUsuario"], PDO::PARAM_INT);
            $cmdConcepto->bindParam(4, $body["estado"], PDO::PARAM_STR);
            $cmdConcepto->execute();
            $idIngreso = Database::getInstance()->getDb()->lastInsertId();
            foreach ($body["ingresos"] as $value) {
                $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
                    idIngreso,
                    idConcepto,
                    Cantidad,
                     Monto
                    )VALUES(?,1,?,?)");
                $cmdDetalle->bindParam(1, $idIngreso,PDO::PARAM_INT);
                $cmdDetalle->bindParam(2, $value['cantidad'], PDO::PARAM_INT);
                $cmdDetalle->bindParam(3, $value['monto'], PDO::PARAM_INT);
                $cmdDetalle->execute();
            }

            // $cmdDetalle->bindParam(1, $body["idIngreso"], PDO::PARAM_INT);
            // $cmdDetalle->bindParam(2, $body["idConcepto"], PDO::PARAM_INT);
            // $cmdDetalle->bindParam(3, $body["Cantidad"], PDO::PARAM_INT);
            // $cmdDetalle->bindParam(4, $body["Monto"], PDO::PARAM_STR);


            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }
}
