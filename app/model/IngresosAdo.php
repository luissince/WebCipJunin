<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class IngresosAdo
{

    public function construct()
    {
    }

    public static function ListarIngresos($posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT i.idIngreso,
            convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,i.Serie,i.NumRecibo,
            i.Estado,p.CIP,p.idDNI,p.Apellidos,p.Nombres,sum(d.Monto) AS Total,
            isnull(i.Xmlsunat,'') as Xmlsunat,isnull(i.Xmldescripcion,'') as Xmldescripcion
            FROM Ingreso AS i INNER JOIN Persona AS p
            ON i.idDNI = p.idDNI
            INNER JOIN Detalle AS d 
            ON d.idIngreso = i.idIngreso
            GROUP BY i.idIngreso,i.Fecha,i.Serie,i.NumRecibo,i.Estado,
            p.CIP,p.idDNI,p.Apellidos,p.Nombres,i.Xmlsunat,i.Xmldescripcion
            ORDER BY CAST(Fecha AS DATE) ASC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdConcepto->bindParam(1, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(2, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "fecha" => $row["Fecha"],
                    "serie" => $row["Serie"],
                    "numRecibo" => $row["NumRecibo"],
                    "estado" => $row["Estado"],
                    "cip" => $row["CIP"],
                    "idDNI" => $row["idDNI"],
                    "apellidos" => $row["Apellidos"],
                    "nombres" => $row["Nombres"],
                    "total" => $row["Total"],
                    "xmlsunat" => $row["Xmlsunat"],
                    "xmldescripcion" => IngresosAdo::limitar_cadena($row["Xmldescripcion"], 100, "..."),
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

    private static function limitar_cadena($cadena, $limite, $sufijo)
    {
        if (strlen($cadena) > $limite) {
            return substr($cadena, 0, $limite) . $sufijo;
        }
        return $cadena;
    }

    public static function RegistrarIngresos($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $codigoSerieNumeracion = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Serie_Numero(?)");
            $codigoSerieNumeracion->bindParam(1, $body["idTipoDocumento"], PDO::PARAM_STR);
            $codigoSerieNumeracion->execute();
            $serie_numeracion = explode("-", $codigoSerieNumeracion->fetchColumn());

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

            if ($body["estadoCuotas"] == true) {
                $cmdCuota = Database::getInstance()->getDb()->prepare("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)");
                $cmdCuota->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdCuota->bindParam(2, $body["cuotasInicio"], PDO::PARAM_STR);
                $cmdCuota->bindParam(3, $body["cuotasFin"], PDO::PARAM_STR);
                $cmdCuota->execute();
            }

            if ($body["estadoColegiatura"] == true) {
                $cmdCuota = Database::getInstance()->getDb()->prepare("INSERT INTO AltaColegio(idIngreso) VALUES(?)");
                $cmdCuota->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdCuota->execute();
            }

            foreach ($body["ingresos"] as $value) {
                $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
                    idIngreso,
                    idConcepto,
                    Cantidad,
                     Monto
                    )VALUES(?,?,?,?)");
                $cmdDetalle->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdDetalle->bindParam(2, $value['idConcepto'], PDO::PARAM_INT);
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

    public static function ObtenerIngresoXML($idIngreso)
    {
        try {
            $array = array();
            $totalsinimpuesto = 0;
            $impuesto = 0;

            $cmdIngreso = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,t.CodigoAlterno as TipoComprobante,t.Nombre as Comprobante,
            i.Serie,i.NumRecibo as Numeracion,
            i.Fecha as FechaPago,convert(varchar,cast(i.Fecha as date), 103) as FechaEmision,
            i.Estado,isnull(i.CodigoHash,'') as CodigoHash,
            p.idDNI,p.CIP,p.Apellidos,p.Nombres
            from Ingreso as i inner join Persona as p on i.idDNI = p.idDNI
            inner join TipoComprobante as t 
			on i.TipoComprobante = t.IdTipoComprobante
            where i.idIngreso = ?");
            $cmdIngreso->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdIngreso->execute();
            $resultIngreso = $cmdIngreso->fetchObject();

            $cmdDetail = Database::getInstance()->getDb()->prepare("SELECT d.idDetalle,
            d.idIngreso,c.Concepto,            
            (d.Monto/d.Cantidad) as Precio,
            d.Cantidad,
            d.Monto as Total
            from Detalle as d inner join Concepto as c on d.idConcepto = c.idConcepto
            inner join Ingreso as i on d.idIngreso = i.idIngreso 
            where d.idIngreso  = ?");
            $cmdDetail->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdDetail->execute();
            $count = 0;
            $detalleIngreso = array();
            while ($row = $cmdDetail->fetch()) {
                $count++;
                array_push($detalleIngreso, array(
                    "Id" => $count,
                    "idDetalle" => $row["idDetalle"],
                    "idIngreso" => $row["idIngreso"],
                    "Concepto" => $row["Concepto"],
                    "Precio" => $row["Precio"],
                    "Cantidad" => $row["Cantidad"],
                    "Total" => $row["Total"]
                ));
                // if (floatval($row["Total"]) > 0) {
                //     $count++;
                //     array_push($detalleventa, array(
                //         "Id" => $count,
                //         "idDetalle" => $row["idDetalle"],
                //         "idIngreso" => $row["idIngreso"],
                //         "Concepto" => $row["Concepto"],
                //         "Precio" => $row["Precio"],
                //         "Cantidad" => $row["Cantidad"],
                //         "Total" => $row["Total"]
                //     ));
                // }
                $preciobruto = $row["Precio"] / 1.0;
                $totalsinimpuesto +=  $row["Cantidad"] * $preciobruto;
                $impuesto += $row["Cantidad"] * ($preciobruto * (0.00 / 100.00));
            }

            $cmdCuotas = Database::getInstance()->getDb()->prepare("SELECT CONCAT(DATENAME (MONTH, DATEADD(MONTH, MONTH(FechaIni) - 1, '1900-01-01')),' ', 
	        YEAR(FechaIni),' a ',DATENAME (MONTH, DATEADD(MONTH, MONTH(FechaFin) - 1, '1900-01-01')),' ',
            YEAR(FechaFin)) as Pago
	        FROM Cuota where idIngreso = ?");
            $cmdCuotas->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdCuotas->execute();
            $resultCuotas = $cmdCuotas->fetchObject();

            $cmdEmpresa = Database::getInstance()->getDb()->prepare("SELECT 
            TOP 1 NumeroDocumento,
            NombreComercial,
            RazonSocial,
            Domicilio,
            Telefono,
            PaginaWeb,
            Email,
            UsuarioSol,
            ClaveSol FROM Empresa");
            $cmdEmpresa->bindParam(1, $idVenta, PDO::PARAM_STR);
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();

            array_push($array, $resultIngreso, $detalleIngreso, $resultCuotas, $resultEmpresa, array(
                "totalsinimpuesto" => $totalsinimpuesto,
                "totalimpuesto" => $impuesto,
                "totalconimpuesto" => $totalsinimpuesto + $impuesto,
            ));
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function CambiarEstadoSunatVenta($idVenta, $codigo, $descripcion, $hash)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE Ingreso SET 
            Xmlsunat = ? , Xmldescripcion = ?, CodigoHash = ? WHERE idIngreso = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $hash, PDO::PARAM_STR);
            $comando->bindParam(4, $idVenta, PDO::PARAM_STR);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function CambiarEstadoSunatResumen($idVenta, $codigo, $descripcion, $hash)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE Ingreso SET 
            Xmlsunat = ? , Xmldescripcion = ?, CodigoHash = ? WHERE idIngreso = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $hash, PDO::PARAM_STR);
            $comando->bindParam(4, $idVenta, PDO::PARAM_STR);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function ResumenIngresosPorFecha()
    {
        try {

            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT 
            c.Codigo,
            c.Concepto,
            sum(d.Cantidad) AS 'Cantidad',
            CASE c.Propiedad 
            WHEN 16 then 0
            WHEN 48 then 0
            ELSE sum(d.Monto) END AS 'CIPJunin',
            CASE c.Propiedad 
            WHEN 16 then sum(d.Monto)
            WHEN 48 then sum(d.Monto)
            ELSE 0 END AS 'CIPNacional'
            FROM Ingreso AS i 
            INNER JOIN Detalle AS d
            ON i.idIngreso = d.idIngreso
            INNER JOIN Concepto AS c
            ON d.idConcepto = c.idConcepto
            GROUP BY c.Codigo,c.Concepto,c.Propiedad
            ORDER BY c.Concepto ASC");
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "Id" => $count,
                    "Codigo" => $row["Codigo"],
                    "Concepto" => $row["Concepto"],
                    "Cantidad" => $row["Cantidad"],
                    "CIPJunin" => $row["CIPJunin"],
                    "CIPNacional" => $row["CIPNacional"]
                ));
            }

            return $arrayIngresos;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function ResumenAporteCIN($fechaInicio,$fechaFinal)
    {
        try {
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("{CALL ResumenCobrosCIN(?,?)}");
            $cmdConcepto->bindParam(1,$fechaInicio,PDO::PARAM_STR);
            $cmdConcepto->bindParam(2,$fechaFinal,PDO::PARAM_STR);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "Id" => $count,
                    "Capitulo" => $row["Capitulo"],
                    "CIP" => $row["CIP"],
                    "Condicion" => ($row["Condicion"] == "F" ? "FALLECIDO" : $row["Condicion"] == "R" ? "RETIRADO" : $row["Condicion"] == "V" ? "VITALICIO" : "ORDINARIO"),
                    "Ingeniero" => $row["Ingeniero"],
                    "Anno" => $row["Anno"],
                    "X1" => $row["X1"],
                    "X2" => $row["X2"],
                    "X3" => $row["X3"],
                    "X4" => $row["X4"],
                    "X5" => $row["X5"],
                    "X6" => $row["X6"],
                    "X7" => $row["X7"],
                    "X8" => $row["X8"],
                    "X9" => $row["X9"],
                    "X10" => $row["X10"],
                    "X11" => $row["X11"],
                    "X12" => $row["X12"],
                    "XZ" => $row["XZ"],
                    "Y1" => $row["Y1"],
                    "Y2" => $row["Y2"],
                    "Y3" => $row["Y3"],
                    "Y4" => $row["Y4"],
                    "Y5" => $row["Y5"],
                    "Y6" => $row["Y6"],
                    "Y7" => $row["Y7"],
                    "Y8" => $row["Y8"],
                    "Y9" => $row["Y9"],
                    "Y10" => $row["Y10"],
                    "Y11" => $row["Y11"],
                    "Y12" => $row["Y12"],
                    "YZ" => $row["YZ"],
                    "XYZ" => $row["XYZ"]
                ));
            }

            return $arrayIngresos;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

}
