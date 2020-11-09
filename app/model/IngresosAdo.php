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
            
            $codigoSerieNumeracion = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Serie_Numero(?)");
            $codigoSerieNumeracion->bindParam(1,$body["idTipoDocumento"],PDO::PARAM_STR);
            $codigoSerieNumeracion->execute();
            $serie_numeracion = explode("-",$codigoSerieNumeracion->fetchColumn());
            
            $cmdIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO Ingreso(
            idDni,
            TipoComprobante,
            Serie,
            NumRecibo,
            Fecha,
            idUsuario,
            Estado,
            Deposito,
            Observacion
            )VALUES(?,?,?,?,GETDATE(),?,?,0,'')");
            $cmdIngreso->bindParam(1, $body["idCliente"], PDO::PARAM_STR);
            $cmdIngreso->bindParam(2, $body["idTipoDocumento"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(3, $serie_numeracion[0], PDO::PARAM_STR);
            $cmdIngreso->bindParam(4, $serie_numeracion[1], PDO::PARAM_STR);
            $cmdIngreso->bindParam(5, $body["idUsuario"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(6, $body["estado"], PDO::PARAM_STR);
            $cmdIngreso->execute();

            $idIngreso = Database::getInstance()->getDb()->lastInsertId();
            foreach ($body["ingresos"] as $value) {
                $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
                    idIngreso,
                    idConcepto,
                    Cantidad,
                     Monto
                    )VALUES(?,?,?,?)");
                $cmdDetalle->bindParam(1, $idIngreso,PDO::PARAM_INT);
                $cmdDetalle->bindParam(2, $value['idConcepto'],PDO::PARAM_INT);
                $cmdDetalle->bindParam(3, $value['cantidad'], PDO::PARAM_INT);
                $cmdDetalle->bindParam(4, $value['monto'], PDO::PARAM_INT);
                $cmdDetalle->execute();
            }
            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }
}
