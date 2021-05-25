<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class NotaCreditoAdo
{
    public static function ListarNotasCredito($opcion, $buscar, $fechaInicio, $fechaFinal, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT nc.idNotaCredito, (SELECT NOMBRE FROM TipoComprobante WHERE IdTipoComprobante = nc.TipoNotaCredito) AS TipoNotaCredito, convert(VARCHAR, CAST(nc.FechaRegistro AS DATE),103) AS FechadeRegistro, 
            nc.Hora, nc.TipoComprobante, tc.Nombre AS NombreComprobante, nc.Serie, nc.Correlativo, nc.IdIngreso, nc.MotivoNotaCredito, nc.NumeroDocIdentidad, 
            nc.NombreRazonSocial, sum(dn.Monto) AS Total
            FROM NotaCredito AS nc
            INNER JOIN TipoComprobante AS tc ON tc.CodigoAlterno = nc.TipoComprobante
            INNER JOIN DetalleNotaCredito AS dn ON dn.idIngreso = nc.IdIngreso
            WHERE
            ($opcion = 0 AND nc.FechaRegistro BETWEEN ? AND ?)
            OR
            ($opcion = 1 AND nc.Serie LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND nc.Correlativo LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND CONCAT(nc.Serie,'-',nc.Correlativo) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND nc.NumeroDocIdentidad LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND nc.NombreRazonSocial LIKE CONCAT(?,'%'))
            GROUP BY nc.idNotaCredito, nc.TipoNotaCredito, nc.FechaRegistro, nc.Hora, nc.TipoComprobante, tc.Nombre, nc.Serie,
            nc.Correlativo, nc.IdIngreso, nc.MotivoNotaCredito, nc.NumeroDocIdentidad, nc.NombreRazonSocial
            ORDER BY nc.FechaRegistro DESC, nc.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdConcepto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(5, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(9, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $posicionPagina,
                    "idNotaCredito" => $row["idNotaCredito"],
                    "tipoNotaCredito" => $row["TipoNotaCredito"],
                    "idIngreso" => $row["IdIngreso"],
                    "fechadeRegistro" => $row["FechadeRegistro"],
                    "hora" => $row["Hora"],
                    "serie" => $row["Serie"],
                    "correlativo" => $row["Correlativo"],
                    "numeroDocIdent" => $row["NumeroDocIdentidad"],
                    "nombres" => $row["NombreRazonSocial"],
                    "total" => $row["Total"],
                    "motivoNotaCredito" => $row["MotivoNotaCredito"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) AS Total FROM NotaCredito  
            WHERE
            $opcion = 0 AND FechaRegistro BETWEEN ? AND ?
            OR
            ($opcion = 1 AND Serie LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND correlativo LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND CONCAT(Serie,'-',correlativo) LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND NumeroDocIdentidad LIKE CONCAT(?,'%'))
            OR
            ($opcion = 1 AND NombreRazonSocial LIKE CONCAT(?,'%'))");
            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(5, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(6, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(7, $buscar, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayIngresos, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function registrarNotaCredito($dataNotaCredito)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM NotaCredito WHERE Serie = ? AND Correlativo = ?');
            $cmdSelect->bindParam(1, $dataNotaCredito['serie'], PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $dataNotaCredito['correlativo'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO NotaCredito (TipoNotaCredito, FechaRegistro, Hora, TipoComprobante, 
                Serie, Correlativo, IdIngreso, MotivoNotaCredito, DocIdentidad, NumeroDocIdentidad, NombreRazonSocial, Direccion, Celular, Correo, 
                Comentario) VALUES (?,?,GETDATE(),?,UPPER(?),?,?,?,?,?,UPPER(?),UPPER(?),?,UPPER(?),UPPER(?));');

                $comandoInsert->bindParam(1, $dataNotaCredito['tipoNotaCredito'], PDO::PARAM_INT);
                $comandoInsert->bindParam(2, $dataNotaCredito['fechaRegistro'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $dataNotaCredito['tipoComprobante'], PDO::PARAM_INT);
                $comandoInsert->bindParam(4, $dataNotaCredito['serie'], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $dataNotaCredito['correlativo'], PDO::PARAM_STR);
                $comandoInsert->bindParam(6, $dataNotaCredito['idIngreso'], PDO::PARAM_INT);
                $comandoInsert->bindParam(7, $dataNotaCredito['motivoNotaCredito'], PDO::PARAM_INT);
                $comandoInsert->bindParam(8, $dataNotaCredito['tipoDocumentoIdentidad'], PDO::PARAM_INT);
                $comandoInsert->bindParam(9, $dataNotaCredito['numeroDocumentoIdentidad'], PDO::PARAM_STR);
                $comandoInsert->bindParam(10, $dataNotaCredito['nombreRazonSocial'], PDO::PARAM_STR);
                $comandoInsert->bindParam(11, $dataNotaCredito['direccion'], PDO::PARAM_STR);
                $comandoInsert->bindParam(12, $dataNotaCredito['celular'], PDO::PARAM_STR);
                $comandoInsert->bindParam(13, $dataNotaCredito['correo'], PDO::PARAM_STR);
                $comandoInsert->bindParam(14, $dataNotaCredito['comentario'], PDO::PARAM_STR);
                $comandoInsert->execute();

                foreach ($dataNotaCredito["detalleComprobante"] as $value) {
                    $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO detalleNotaCredito(
                        idIngreso,
                        idConcepto,
                        Cantidad,
                         Monto
                        )VALUES(?,?,?,?)");
                    $cmdDetalle->bindParam(1, $value['idIngreso'], PDO::PARAM_INT);
                    $cmdDetalle->bindParam(2, $value['idConcepto'], PDO::PARAM_INT);
                    $cmdDetalle->bindParam(3, $value['Cantidad'], PDO::PARAM_INT);
                    $cmdDetalle->bindParam(4, $value['Total'], PDO::PARAM_INT);
                    $cmdDetalle->execute();
                }
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }
}
