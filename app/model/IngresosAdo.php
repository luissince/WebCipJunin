<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class IngresosAdo
{

    public function construct()
    {
    }

    public static function ListarIngresos($opcion, $buscar, $fechaInicio, $fechaFinal, $comprobante, $estado, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayIngresos = array();
            $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,
            i.Hora,
			CONCAT(UPPER(u.Nombres),', ', UPPER(u.Apellidos)) as Usuario,
			r.Nombre AS Rol,
            tc.Nombre as Comprobante,
            i.Serie, 
            i.NumRecibo,
            i.Estado,
            p.CIP,
            case when not e.IdEmpresa is null then 'RUC' else 'DNI' end as NombreDocumento,
            isnull(e.NumeroRuc,p.NumDoc) as NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ', p.Nombres)) as Persona,
            sum(d.Monto) AS Total,
            isnull(i.Xmlsunat,'') as Xmlsunat,
            isnull(i.Xmldescripcion,'') as Xmldescripcion
            FROM Ingreso AS i 
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante
            LEFT JOIN Persona AS p ON i.idDNI = p.idDNI
            LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN Detalle AS d ON d.idIngreso = i.idIngreso
			INNER JOIN Usuario AS u ON u.idUsuario = i.idUsuario
			INNER JOIN Rol AS r ON r.idRol = u.Rol
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND i.Serie like CONCAT(?,'%')
            OR
            $opcion = 1 AND i.NumRecibo like CONCAT(?,'%')
            OR
            $opcion = 1 AND CONCAT(i.Serie,'-',i.NumRecibo) like CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.NumeroRuc,p.NumDoc) LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.Nombre,p.Apellidos) LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.Nombre,p.Nombres)  LIKE CONCAT(?,'%')
            OR
            $opcion = 2 AND i.TipoComprobante = ? AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 3 AND i.Estado = ? AND i.Fecha BETWEEN ? AND ?
            GROUP BY i.idIngreso,u.Nombres, u.Apellidos,i.Fecha,i.Hora,i.Serie,i.NumRecibo,i.Estado,
            p.CIP,p.NumDoc,p.Apellidos,r.Nombre, p.Nombres,e.NumeroRuc,e.Nombre,i.Xmlsunat,i.Xmldescripcion,e.IdEmpresa,tc.Nombre
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdConcepto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdConcepto->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(4, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(5, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(6, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(7, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(8, $buscar, PDO::PARAM_STR);
            $cmdConcepto->bindParam(9, $comprobante, PDO::PARAM_INT);
            $cmdConcepto->bindParam(10, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(11, $fechaFinal, PDO::PARAM_STR);
            $cmdConcepto->bindParam(12, $estado, PDO::PARAM_STR);
            $cmdConcepto->bindParam(13, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(14, $fechaFinal, PDO::PARAM_STR);
            $cmdConcepto->bindParam(15, $posicionPagina, PDO::PARAM_INT);
            $cmdConcepto->bindParam(16, $filasPorPagina, PDO::PARAM_INT);
            $cmdConcepto->execute();
            $count = 0;

            while ($row = $cmdConcepto->fetch()) {
                $count++;
                array_push($arrayIngresos, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "fecha" => $row["Fecha"],
                    "hora" => $row["Hora"],
                    "usuario" => $row["Usuario"],
                    "rol" => $row["Rol"],
                    "comprobante" => $row["Comprobante"],
                    "serie" => $row["Serie"],
                    "numRecibo" => $row["NumRecibo"],
                    "estado" => $row["Estado"],
                    "cip" => $row["CIP"],
                    "nombreDocumento" => $row["NombreDocumento"],
                    "numeroDocumento" => $row["NumeroDocumento"],
                    "persona" => $row["Persona"],
                    "total" => $row["Total"],
                    "xmlsunat" => $row["Xmlsunat"],
                    "xmldescripcion" => IngresosAdo::limitar_cadena($row["Xmldescripcion"], 100, "..."),
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) AS Total 
            FROM Ingreso AS i 
            INNER JOIN TipoComprobante AS tc ON tc.IdTipoComprobante = i.TipoComprobante
            LEFT JOIN Persona AS p ON i.idDNI = p.idDNI
            LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN Usuario AS u ON u.idUsuario = i.idUsuario
			INNER JOIN Rol AS r ON r.idRol = u.Rol
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND i.Serie like CONCAT(?,'%')
            OR
            $opcion = 1 AND i.NumRecibo like CONCAT(?,'%')
            OR
            $opcion = 1 AND CONCAT(i.Serie,'-',i.NumRecibo) like CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.NumeroRuc,p.NumDoc) LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.NumeroRuc,p.Apellidos) LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND isnull(e.NumeroRuc,p.Nombres)  LIKE CONCAT(?,'%')
            OR
            $opcion = 2 AND i.TipoComprobante = ? AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 3 AND i.Estado = ? AND i.Fecha BETWEEN ? AND ?");
            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(5, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(6, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(7, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(8, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(9, $comprobante, PDO::PARAM_INT);
            $comandoTotal->bindParam(10, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(11, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(12, $estado, PDO::PARAM_STR);
            $comandoTotal->bindParam(13, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(14, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayIngresos, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function ListarCertificadosHabilidad($opcion, $buscar, $fechaInicio, $fechaFinal, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayCertHabilidad = array();
            $cmdCertHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
            p.NumDoc, 
            p.Nombres,
            p.Apellidos,
			p.CIP,
            e.Especialidad, 
            ch.Numero, 
            ch.Asunto, 
            ch.Entidad, 
            ch.Lugar, 
            convert(VARCHAR, CAST(ch.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(ch.HastaFecha AS DATE),103) AS HastaFecha, 
            ch.idIngreso,ch.Anulado AS Estado 
            FROM CERTHabilidad AS ch
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = ch.idColegiatura
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND ch.Numero LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND  ch.Asunto LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND ch.Entidad LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND ch.Lugar LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND p.NumDoc = ?
            OR
            $opcion = 1 AND p.CIP = ?
            OR
            $opcion = 1 AND p.Nombres LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND p.Apellidos LIKE CONCAT(?,'%')
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdCertHabilidad->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(4, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(5, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(6, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(7, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(8, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(9, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(10, $buscar, PDO::PARAM_STR);
            $cmdCertHabilidad->bindParam(11, $posicionPagina, PDO::PARAM_INT);
            $cmdCertHabilidad->bindParam(12, $filasPorPagina, PDO::PARAM_INT);
            $cmdCertHabilidad->execute();
            $count = 0;

            while ($row = $cmdCertHabilidad->fetch()) {
                $count++;
                array_push($arrayCertHabilidad, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "numeroCip" => $row["CIP"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "asunto" => $row["Asunto"],
                    "entidad" => $row["Entidad"],
                    "lugar" => $row["Lugar"],
                    "fechaPago" => $row["Fecha"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "estado" => $row["Estado"] == 0
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM CERTHabilidad AS ch
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = ch.idColegiatura 
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND ch.Numero LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND  ch.Asunto LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND ch.Entidad LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND ch.Lugar LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND p.NumDoc = ?
            OR
            $opcion = 1 AND p.CIP = ?
            OR
            $opcion = 1 AND p.Nombres LIKE CONCAT(?,'%')
            OR
            $opcion = 1 AND p.Apellidos LIKE CONCAT(?,'%')");

            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(5, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(6, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(7, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(8, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(9, $buscar, PDO::PARAM_STR);
            $comandoTotal->bindParam(10, $buscar, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayCertHabilidad, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function ListarCertificadosProyecto($opcion, $buscar, $fechaInicio, $fechaFinal, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayCertProyecto = array();
            $cmdCertProyecto = Database::getInstance()->getDb()->prepare("SELECT 
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cp.Numero, 
            cp.Modalidad, 
            cp.Propietario, 
            cp.Proyecto, 
            cp.Monto, 
            CONCAT(U.Departamento,'-',U.Provincia,'-', u.Distrito) AS Ubigeo, 
            ISNULL(cp.Adicional1,'N/D') AS Adicional1, 
            ISNULL(cp.Adicional2,'N/D') AS Adicional2, 
            convert(VARCHAR, CAST(cp.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(cp.HastaFecha AS DATE),103) AS HastaFecha,
            cp.idIngreso, 
            cp.Anulado AS Estado  
            FROM CERTProyecto AS cp
            INNER JOIN Ingreso AS i ON i.idIngreso = cp.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cp.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cp.idUbigeo
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND cp.Numero LIKE CONCAT(?,'%')
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdCertProyecto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdCertProyecto->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdCertProyecto->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdCertProyecto->bindParam(4, $posicionPagina, PDO::PARAM_INT);
            $cmdCertProyecto->bindParam(5, $filasPorPagina, PDO::PARAM_INT);
            $cmdCertProyecto->execute();
            $count = 0;

            while ($row = $cmdCertProyecto->fetch()) {
                $count++;
                array_push($arrayCertProyecto, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "modalidad" => $row["Modalidad"],
                    "propietario" => $row["Propietario"],
                    "proyecto" => $row["Proyecto"],
                    "monto" => $row["Monto"],
                    "ubigeo" => $row["Ubigeo"],
                    "adicional1" => $row["Adicional1"],
                    "adicional2" => $row["Adicional2"],
                    "fechaPago" => $row["Fecha"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "estado" => $row["Estado"]
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM CERTProyecto  AS cp
            INNER JOIN Ingreso AS i ON i.idIngreso = cp.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cp.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cp.idUbigeo
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND cp.Numero LIKE CONCAT(?,'%')");
            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayCertProyecto, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function ListarCertificadosObra($opcion, $buscar, $fechaInicio, $fechaFinal, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayCertObra = array();
            $cmdCertObra = Database::getInstance()->getDb()->prepare("SELECT 
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cr.Numero, 
            cr.Modalidad, 
            cr.Propietario, 
            cr.Proyecto, 
            cr.Monto, 
            CONCAT(u.Departamento,'-',u.Provincia,'-', u.Distrito) AS Ubigeo, 
            convert(VARCHAR, CAST(cr.Fecha AS DATE),103) AS Fecha, 
            convert(VARCHAR, CAST(cr.HastaFecha AS DATE),103) AS HastaFecha, 
            cr.idIngreso, 
            cr.Anulado AS Estado
            FROM CERTResidencia AS cr
            INNER JOIN Ingreso AS i ON i.idIngreso = cr.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cr.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cr.idUbigeo
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND cr.Numero LIKE CONCAT(?,'%')
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdCertObra->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdCertObra->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdCertObra->bindParam(3, $buscar, PDO::PARAM_STR);
            $cmdCertObra->bindParam(4, $posicionPagina, PDO::PARAM_INT);
            $cmdCertObra->bindParam(5, $filasPorPagina, PDO::PARAM_INT);
            $cmdCertObra->execute();
            $count = 0;

            while ($row = $cmdCertObra->fetch()) {
                $count++;
                array_push($arrayCertObra, array(
                    "id" => $count + $posicionPagina,
                    "idIngreso" => $row["idIngreso"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "modalidad" => $row["Modalidad"],
                    "propietario" => $row["Propietario"],
                    "proyecto" => $row["Proyecto"],
                    "monto" => $row["Monto"],
                    "ubigeo" => $row["Ubigeo"],
                    "fechaPago" => $row["Fecha"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "estado" => $row["Estado"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM CERTResidencia AS cr
            INNER JOIN Ingreso AS i ON i.idIngreso = cr.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cr.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cr.idUbigeo
            WHERE
            $opcion = 0 AND i.Fecha BETWEEN ? AND ?
            OR
            $opcion = 1 AND cr.Numero LIKE CONCAT(?,'%')");
            $comandoTotal->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $buscar, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayCertObra, $resultTotal);
            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function limitar_cadena($cadena, $limite, $sufijo)
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

            $array = array();
            $resultCliente = null;

            $codigoSerieNumeracion = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Serie_Numero(?)");
            $codigoSerieNumeracion->bindParam(1, $body["idTipoDocumento"], PDO::PARAM_STR);
            $codigoSerieNumeracion->execute();
            $serie_numeracion = explode("-", $codigoSerieNumeracion->fetchColumn());

            $cmdIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO Ingreso(
            idDni,
            idEmpresaPersona,
            TipoComprobante,
            Serie,
            NumRecibo,
            Fecha,
            Hora,
            idUsuario,
            Estado,
            Deposito,
            Observacion
            )VALUES(?,?,?,?,?,GETDATE(),GETDATE(),?,?,0,'')");
            $cmdIngreso->bindParam(1, $body["idCliente"], PDO::PARAM_STR);
            $cmdIngreso->bindParam(2, $body["idEmpresaPersona"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(3, $body["idTipoDocumento"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(4, $serie_numeracion[0], PDO::PARAM_STR);
            $cmdIngreso->bindParam(5, $serie_numeracion[1], PDO::PARAM_STR);
            $cmdIngreso->bindParam(6, $body["idUsuario"], PDO::PARAM_INT);
            $cmdIngreso->bindParam(7, $body["estado"], PDO::PARAM_STR);
            $cmdIngreso->execute();

            $idIngreso = Database::getInstance()->getDb()->lastInsertId();

            if ($body["estadoCuotas"] == true) {
                $cmdCuota = Database::getInstance()->getDb()->prepare("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)");
                $cmdCuota->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdCuota->bindParam(2, $body["cuotasInicio"], PDO::PARAM_STR);
                $cmdCuota->bindParam(3, $body["cuotasFin"], PDO::PARAM_STR);
                $cmdCuota->execute();

                $cmdPersona = Database::getInstance()->getDb()->prepare("SELECT 
                p.CIP,
                p.Nombres,
                p.Apellidos,
                p.Sexo,
                p.Condicion,
                ca.Capitulo,
                e.Especialidad,
                c.FechaColegiado
                FROM Persona AS p 
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                WHERE p.idDNI = ?");
                $cmdPersona->bindParam(1, $body["idCliente"], PDO::PARAM_STR);
                $cmdPersona->execute();
                $resultCliente = $cmdPersona->fetchObject();
                if (!$resultCliente) {
                    throw new Exception("No se pudo completar el ingreso porque el colegiado no tiene registrado todo sus datos de colegiatura, comuníquese con el área de sistemas.");
                }

                $countResolucion15 = 0;
                foreach ($body["ingresos"] as $value) {
                    if ($value["categoria"] == 12) {
                        $countResolucion15++;
                    }
                }

                if ($countResolucion15 > 0) {
                    $date1 = new DateTime($body["cuotasInicio"] . " 00:00:00");
                    $date2 = new DateTime($body["cuotasFin"] . " 00:00:00");
                    $years = $date2->format("Y") - $date1->format("Y");
                    $monthini = $date1->format("m");
                    $monthfin = $date2->format("m");
                    $monthaum = ((12 * $years) - $monthini) + $monthfin + 1;

                    $cmdResolucion15 = Database::getInstance()->getDb()->prepare("UPDATE Colegiatura SET Resolucion15 = 1, MesAumento = ? WHERE idDNI = ?");
                    $cmdResolucion15->bindParam(1, $monthaum, PDO::PARAM_INT);
                    $cmdResolucion15->bindParam(2, $body["idCliente"], PDO::PARAM_STR);
                    $cmdResolucion15->execute();
                }
            }

            if ($body["estadoColegiatura"] == true) {
                $cmdAltaColegio = Database::getInstance()->getDb()->prepare("INSERT INTO AltaColegio(idIngreso) VALUES(?)");
                $cmdAltaColegio->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdAltaColegio->execute();
            }

            if ($body["estadoCertificadoHabilidad"] == true) {
                $cmdCertHabilidad = Database::getInstance()->getDb()->prepare("INSERT INTO CERTHabilidad(idIUsuario,idColegiatura,Numero,Asunto,Entidad,Lugar,Fecha,HastaFecha,Anulado,idIngreso) VALUES(?,?,?,?,?,?,?,?,?,?)");
                $cmdCertHabilidad->bindParam(1, $body["idUsuario"], PDO::PARAM_INT);
                $cmdCertHabilidad->bindParam(2, $body["objectCertificadoHabilidad"]["idEspecialidad"], PDO::PARAM_INT);
                $cmdCertHabilidad->bindParam(3, $body["objectCertificadoHabilidad"]["numero"], PDO::PARAM_INT);
                $cmdCertHabilidad->bindParam(4, $body["objectCertificadoHabilidad"]["asunto"], PDO::PARAM_STR);
                $cmdCertHabilidad->bindParam(5, $body["objectCertificadoHabilidad"]["entidad"], PDO::PARAM_STR);
                $cmdCertHabilidad->bindParam(6, $body["objectCertificadoHabilidad"]["lugar"], PDO::PARAM_INT);
                $cmdCertHabilidad->bindParam(7, $body["objectCertificadoHabilidad"]["fechaPago"], PDO::PARAM_STR);
                $cmdCertHabilidad->bindParam(8, $body["objectCertificadoHabilidad"]["ultimoPago"], PDO::PARAM_STR);
                $cmdCertHabilidad->bindParam(9, $body["objectCertificadoHabilidad"]["anulado"], PDO::PARAM_BOOL);
                $cmdCertHabilidad->bindParam(10, $idIngreso, PDO::PARAM_INT);
                $cmdCertHabilidad->execute();
            }

            if ($body["estadoCertificadoResidenciaObra"] == true) {
                $cmdCertResidenciaObra = Database::getInstance()->getDb()->prepare("INSERT INTO CERTResidencia(idUsuario,idColegiatura,Numero,Modalidad,Propietario,Proyecto,Monto,idUbigeo,Fecha,HastaFecha,Anulado,idIngreso) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
                $cmdCertResidenciaObra->bindParam(1, $body["idUsuario"], PDO::PARAM_INT);
                $cmdCertResidenciaObra->bindParam(2, $body["objectCertificadoResidenciaObra"]["idEspecialidad"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(3, $body["objectCertificadoResidenciaObra"]["numero"], PDO::PARAM_INT);
                $cmdCertResidenciaObra->bindParam(4, $body["objectCertificadoResidenciaObra"]["modalidad"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(5, $body["objectCertificadoResidenciaObra"]["propietario"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(6, $body["objectCertificadoResidenciaObra"]["proyecto"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(7, $body["objectCertificadoResidenciaObra"]["montocontrato"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(8, $body["objectCertificadoResidenciaObra"]["ubigeo"], PDO::PARAM_INT);
                $cmdCertResidenciaObra->bindParam(9, $body["objectCertificadoResidenciaObra"]["fechaPago"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(10, $body["objectCertificadoResidenciaObra"]["ultimoPago"], PDO::PARAM_STR);
                $cmdCertResidenciaObra->bindParam(11, $body["objectCertificadoResidenciaObra"]["anulado"], PDO::PARAM_BOOL);
                $cmdCertResidenciaObra->bindParam(12, $idIngreso, PDO::PARAM_INT);
                $cmdCertResidenciaObra->execute();
            }


            if ($body["estadoCertificadoProyecto"] == true) {
                $cmdCertProyecto = Database::getInstance()->getDb()->prepare("INSERT INTO CERTProyecto(idUsuario,idColegiatura,Numero,Modalidad,Propietario,Proyecto,Monto,idUbigeo,Adicional1,Adicional2,Fecha,HastaFecha,Anulado,idIngreso) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $cmdCertProyecto->bindParam(1, $body["idUsuario"], PDO::PARAM_INT);
                $cmdCertProyecto->bindParam(2, $body["objectCertificadoProyecto"]["idEspecialidad"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(3, $body["objectCertificadoProyecto"]["numero"], PDO::PARAM_INT);
                $cmdCertProyecto->bindParam(4, $body["objectCertificadoProyecto"]["modalidad"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(5, $body["objectCertificadoProyecto"]["propietario"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(6, $body["objectCertificadoProyecto"]["proyecto"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(7, $body["objectCertificadoProyecto"]["montocontrato"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(8, $body["objectCertificadoProyecto"]["ubigeo"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(9, $body["objectCertificadoProyecto"]["asociacion"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(10, $body["objectCertificadoProyecto"]["pasaje"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(11, $body["objectCertificadoProyecto"]["fechaPago"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(12, $body["objectCertificadoProyecto"]["ultimoPago"], PDO::PARAM_STR);
                $cmdCertProyecto->bindParam(13, $body["objectCertificadoProyecto"]["anulado"], PDO::PARAM_BOOL);
                $cmdCertProyecto->bindParam(14, $idIngreso, PDO::PARAM_INT);
                $cmdCertProyecto->execute();
            }

            if ($body["estadoPeritaje"] == true) {
                $cmdCertPeritaje = Database::getInstance()->getDb()->prepare("INSERT INTO Peritaje(idIngreso,Detalle) VALUES(?,?)");
                $cmdCertPeritaje->bindParam(1, $idIngreso, PDO::PARAM_INT);
                $cmdCertPeritaje->bindParam(2, $body["objectPeritaje"]["descripcion"], PDO::PARAM_STR);
                $cmdCertPeritaje->execute();
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

            array_push($array, "inserted", $idIngreso, $body["estadoCertificadoHabilidad"], $body["estadoCertificadoResidenciaObra"], $body["estadoCertificadoProyecto"], $body["estadoCuotas"], $body["cuotasFin"], $resultCliente);
            return $array;
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function EliminarIngreso($idIngreso, $idUsuario, $fecha, $hora, $motivo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Ingreso WHERE idIngreso = ?");
            $cmdValidate->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdValidate->execute();
            if ($row = $cmdValidate->fetch()) {
                if ($row["Estado"] == "A") {
                    Database::getInstance()->getDb()->rollBack();
                    return "anulado";
                } else {
                    $cmdIngreso = Database::getInstance()->getDb()->prepare("UPDATE Ingreso SET Estado = 'A' WHERE idIngreso = ?");
                    $cmdIngreso->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdIngreso->execute();

                    $countResolucion15 = 0;

                    $cmdDetalle = Database::getInstance()->getDb()->prepare("SELECT c.Categoria FROM Detalle AS d INNER JOIN Concepto AS c ON c.idConcepto = d.idConcepto
                    WHERE d.idIngreso = ? ");
                    $cmdDetalle->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdDetalle->execute();
                    while ($rowd = $cmdDetalle->fetch()) {
                        if ($rowd["Categoria"] == 12) {
                            $countResolucion15++;
                        }
                    }

                    if ($countResolucion15 > 0) {
                        $cmdResolucion15 = Database::getInstance()->getDb()->prepare("UPDATE Colegiatura SET Resolucion15 = 0, MesAumento = 0 WHERE idDNI = ?");
                        $cmdResolucion15->bindParam(1, $row["idDNI"], PDO::PARAM_STR);
                        $cmdResolucion15->execute();
                    }

                    $cmdAnular = Database::getInstance()->getDb()->prepare("INSERT INTO Anulado(Tipo,idDocumento,idUsuario,Motivo,Fecha,Hora)VALUES('R',?,?,?,?,?)");
                    $cmdAnular->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdAnular->bindParam(2, $idUsuario, PDO::PARAM_INT);
                    $cmdAnular->bindParam(3, $motivo, PDO::PARAM_INT);
                    $cmdAnular->bindParam(4, $fecha, PDO::PARAM_INT);
                    $cmdAnular->bindParam(5, $hora, PDO::PARAM_INT);
                    $cmdAnular->execute();

                    $cmdCuotas = Database::getInstance()->getDb()->prepare("DELETE FROM Cuota WHERE idIngreso = ?");
                    $cmdCuotas->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdCuotas->execute();

                    $cmdHabilidad = Database::getInstance()->getDb()->prepare("UPDATE CERTHabilidad SET Anulado = 1 WHERE idIngreso = ?");
                    $cmdHabilidad->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdHabilidad->execute();

                    $cmdObra = Database::getInstance()->getDb()->prepare("UPDATE CERTResidencia SET Anulado = 1 WHERE idIngreso = ?");
                    $cmdObra->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdObra->execute();

                    $cmdProyecto = Database::getInstance()->getDb()->prepare("UPDATE CERTProyecto SET Anulado = 1 WHERE idIngreso = ?");
                    $cmdProyecto->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdProyecto->execute();

                    Database::getInstance()->getDb()->commit();
                    return "deleted";
                }
            } else {
                Database::getInstance()->getDb()->rollBack();
                return "nodata";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function addAfiliacion($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdAfiliacion = Database::getInstance()->getDb()->prepare("INSERT INTO Afiliacion(idDni,Descripcion,Monto,Fecha,Hora,idUsuario, Estado)VALUES(?,?,?,GETDATE(),GETDATE(),?,'1')");
            $cmdAfiliacion->bindParam(1, $data["colegiado"], PDO::PARAM_STR);
            $cmdAfiliacion->bindParam(2, $data["concepto"], PDO::PARAM_STR);
            $cmdAfiliacion->bindParam(3, $data["monto"], PDO::PARAM_STR);
            $cmdAfiliacion->bindParam(4, $data["usuario"], PDO::PARAM_INT);
            $cmdAfiliacion->execute();
            Database::getInstance()->getDb()->commit();
            return "inserted";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }

    public static function ObtenerIngresoXML($idIngreso)
    {
        try {
            $array = array();
            $totalsinimpuesto = 0;
            $opegravada =  0;
            $opeexogenerada = 0;
            $impuesto = 0;

            $cmdIngreso = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            t.CodigoAlterno AS TipoComprobante,
            t.Nombre AS Comprobante,
            i.Serie,
            i.NumRecibo AS Numeracion,
            i.Fecha AS FechaPago,
            i.Hora as HoraPago,
            CONVERT(VARCHAR,cast(i.Fecha AS DATE), 103) AS FechaEmision,
            i.Estado,isnull(i.CodigoHash,'') AS CodigoHash,
            case when not e.IdEmpresa is null then 6 else 1 end as TipoDocumento,
            case when not e.IdEmpresa is null then 'R.U.C' else 'D.N.I' end as NombreDocumento,
            case when not e.IdEmpresa is null then 'Razón Social' else 'Nombres' end as TipoNombrePersona,
            isnull(e.NumeroRuc,p.NumDoc) as NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ',p.Nombres)) as DatosPersona,
            isnull(e.Direccion,ISNULL((select top 1 Direccion from Direccion where idDNI = p.idDNI),'')) as Direccion,
			p.CIP,
            p.NumDoc, 
            p.Apellidos,
            p.Nombres,
			ISNULL(es.Especialidad, 'SIN ESPECIALIDAD') AS Especialidad,
			ISNULL(ca.Capitulo, 'SIN CAPITULO') AS Capitulo,
            ISNULL(i.Correlativo,0) as Correlativo
            FROM Ingreso AS i 
            LEFT JOIN Persona AS p ON p.idDNI = i.idDNI
			LEFT JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
			LEFT JOIN Especialidad AS es ON es.idEspecialidad = c.idEspecialidad
			LEFT JOIN Capitulo AS ca ON ca.idCapitulo = es.idCapitulo
			LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN TipoComprobante AS t ON t.IdTipoComprobante = i.TipoComprobante 
            WHERE i.idIngreso = ?");
            $cmdIngreso->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdIngreso->execute();
            $resultIngreso = $cmdIngreso->fetchObject();

            $cmdDetail = Database::getInstance()->getDb()->prepare("SELECT 
            d.idDetalle,
            d.idIngreso,
            IIF(c.Categoria =8, p.Detalle, c.Concepto) AS Concepto,			            
            (d.Monto/d.Cantidad) AS Precio,
            d.Cantidad,
            d.Monto AS Total,
            i.Nombre,
            i.Valor,
            i.Codigo
            FROM Detalle AS d 
            INNER JOIN Concepto AS c ON d.idConcepto = c.idConcepto
			LEFT JOIN Peritaje as p ON p.idIngreso = d.idIngreso
            INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto
            WHERE d.idIngreso  = ?");
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
                    "Total" => $row["Total"],
                    "Nombre" => $row["Nombre"],
                    "Valor" => $row["Valor"],
                    "Codigo" => $row["Codigo"],
                ));
                $cantidad = $row["Cantidad"];
                $valorImpuesto = $row['Valor'];
                $preciobruto = $row['Precio'] / (($valorImpuesto / 100.00) + 1);

                $opegravada +=  $valorImpuesto == 0 ? 0 : $cantidad * $preciobruto;
                $opeexogenerada += $valorImpuesto == 0 ? $cantidad * $preciobruto : 0;

                $totalsinimpuesto += $cantidad * $preciobruto;
                $impuesto += $cantidad  * ($preciobruto * ($valorImpuesto / 100.00));
            }

            $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT 
            MAX(ISNULL(Correlativo,0)) as Correlativo 
            FROM Ingreso WHERE FechaCorrelativo = CAST(GETDATE() AS DATE)");
            $cmdCorrelativo->execute();
            $resultCorrelativo = $cmdCorrelativo->fetchColumn();

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
            ClaveSol
            FROM Empresa");
            $cmdEmpresa->execute();
            $resultEmpresa = $cmdEmpresa->fetchObject();

            array_push(
                $array,
                $resultIngreso,
                $detalleIngreso,
                $resultCuotas,
                $resultEmpresa,
                array(
                    "opgravada" => $opegravada,
                    "opexonerada" =>   $opeexogenerada,
                    "totalsinimpuesto" => $totalsinimpuesto,
                    "totalimpuesto" => $impuesto,
                    "totalconimpuesto" => $totalsinimpuesto + $impuesto,
                ),
                $resultCorrelativo
            );
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ObtenerDatosPdfCertHabilidad($idIngreso)
    {
        try {
            $arrayCertHabilidad = array();
            $cmdCertHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
            p.CIP,
            p.NumDoc, 
            p.Nombres,
            p.Apellidos,
            e.Especialidad, 
            ch.Numero, 
            ch.Asunto, ch.Entidad, ch.Lugar, 
            convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103) AS FechaIncorporacion,
			DATEPART(DAY, (convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103))) AS FIDia, 
			DATEPART(MONTH, (convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103))) AS FIMes, 
            DATEPART(YEAR, (convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103))) AS FIAnio, 
            convert(VARCHAR, CAST(ch.Fecha AS DATE),103) AS FechaRegistro,
            DATEPART(DAY, (convert(VARCHAR, CAST(ch.Fecha AS DATE),103))) AS FRDia, 
            DATEPART(MONTH, (convert(VARCHAR, CAST(ch.Fecha AS DATE),103))) AS FRMes, 
            DATEPART(YEAR, (convert(VARCHAR, CAST(ch.Fecha AS DATE),103))) AS FRAnio, 
            convert(VARCHAR, CAST(ch.HastaFecha AS DATE),103) AS HastaFecha, 
            DATEPART(DAY, ch.HastaFecha) AS FVDia,
            DATEPART(MONTH, ch.HastaFecha) AS FVMes, 
            DATEPART(YEAR, ch.HastaFecha) AS FVAnio,
            ch.idIngreso from CERTHabilidad AS ch
            INNER JOIN Ingreso AS i ON i.idIngreso = ch.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND  c.Principal = 1
			INNER JOIN Especialidad AS e On e.idEspecialidad = ch.idColegiatura
            WHERE ch.idIngreso = ?");
            $cmdCertHabilidad->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdCertHabilidad->execute();

            while ($row = $cmdCertHabilidad->fetch()) {
                array_push($arrayCertHabilidad, array(
                    "idIngreso" => $row["idIngreso"],
                    "cip" => $row["CIP"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "asunto" => $row["Asunto"],
                    "entidad" => $row["Entidad"],
                    "lugar" => $row["Lugar"],
                    "fechaIncorporacion" => $row["FechaIncorporacion"],
                    "fiDia" => $row["FIDia"],
                    "fiMes" => $row["FIMes"],
                    "fiAnio" => $row["FIAnio"],
                    "fechaRegistro" => $row["FechaRegistro"],
                    "frDia" => $row["FRDia"],
                    "frMes" => $row["FRMes"],
                    "frAnio" => $row["FRAnio"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "fvDia" => $row["FVDia"],
                    "fvMes" => $row["FVMes"],
                    "fvAnio" => $row["FVAnio"],
                ));
            }

            return $arrayCertHabilidad;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ObtenerDatosPdfCertObra($idIngreso)
    {
        try {
            $arrayCertObra = array();
            $cmdCertObra = Database::getInstance()->getDb()->prepare("SELECT 
            p.CIP,
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cr.Numero, 
            cr.Modalidad, 
            cr.Propietario, 
            cr.Proyecto, 
            cr.Monto, 
            u.Departamento,
            u.Provincia,
            u.Distrito, 
            convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103) AS FechaIncorporacion, DATEPART(DAY, c.FechaColegiado) AS FIDia, 
            DATEPART(MONTH, c.FechaColegiado) AS FIMes, DATEPART(YEAR, c.FechaColegiado) AS FIAnio, 
            convert(VARCHAR, CAST(cr.Fecha AS DATE),103) AS FechaRegistro, DATEPART(DAY, cr.Fecha) AS FRDia, 
            DATEPART(MONTH, cr.Fecha) AS FRMes, DATEPART(YEAR, cr.Fecha ) AS FRAnio, 
            convert(VARCHAR, CAST(cr.HastaFecha AS DATE),103) AS HastaFecha, DATEPART(DAY, cr.HastaFecha ) AS FVDia,
            DATEPART(MONTH, cr.HastaFecha ) AS FVMes, DATEPART(YEAR, cr.HastaFecha ) AS FVAnio,
            cr.idIngreso  from CERTResidencia AS cr
            INNER JOIN Ingreso AS i ON i.idIngreso = cr.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cr.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cr.idUbigeo
            INNER JOIN Colegiatura AS c ON c.idEspecialidad = cr.idColegiatura
            WHERE cr.idIngreso = ?");
            $cmdCertObra->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdCertObra->execute();

            while ($row = $cmdCertObra->fetch()) {
                array_push($arrayCertObra, array(
                    "idIngreso" => $row["idIngreso"],
                    "cip" => $row["CIP"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "modalidad" => $row["Modalidad"],
                    "propietario" => $row["Propietario"],
                    "proyecto" => $row["Proyecto"],
                    "monto" => $row["Monto"],
                    "departamento" => $row["Departamento"],
                    "provincia" => $row["Provincia"],
                    "distrito" => $row["Distrito"],
                    "fechaIncorporacion" => $row["FechaIncorporacion"],
                    "fiDia" => $row["FIDia"],
                    "fiMes" => $row["FIMes"],
                    "fiAnio" => $row["FIAnio"],
                    "fechaRegistro" => $row["FechaRegistro"],
                    "frDia" => $row["FRDia"],
                    "frMes" => $row["FRMes"],
                    "frAnio" => $row["FRAnio"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "fvDia" => $row["FVDia"],
                    "fvMes" => $row["FVMes"],
                    "fvAnio" => $row["FVAnio"],
                ));
            }

            return $arrayCertObra;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ObtenerDatosPdfCertProyecto($idIngreso)
    {
        try {
            $arrayCertProyecto = array();
            $cmdCertProyecto = Database::getInstance()->getDb()->prepare("SELECT 
            p.CIP,
            p.NumDoc, 
            p.Nombres,
            p.Apellidos, 
            e.Especialidad, 
            cp.Numero, 
            cp.Modalidad, 
            cp.Propietario, 
            cp.Proyecto, 
            cp.Monto, 
            u.Departamento, 
            u.Provincia, 
            u.Distrito, 
            ISNULL(cp.Adicional1,'N/D') AS Adicional1, ISNULL(cp.Adicional2,'N/D') AS Adicional2, convert(VARCHAR, CAST(c.FechaColegiado AS DATE),103) AS FechaIncorporacion, 
            DATEPART(DAY, c.FechaColegiado) AS FIDia, DATEPART(MONTH, c.FechaColegiado ) AS FIMes, 
            DATEPART(YEAR, c.FechaColegiado) AS FIAnio, convert(VARCHAR, CAST(cp.Fecha AS DATE),103) AS FechaRegistro, 
            DATEPART(DAY, cp.Fecha) AS FRDia, DATEPART(MONTH,cp.Fecha) AS FRMes, 
            DATEPART(YEAR, cp.Fecha ) AS FRAnio, CONVERT(VARCHAR, CAST(cp.HastaFecha AS DATE),103) AS HastaFecha, 
            DATEPART(DAY, cp.HastaFecha) AS FVDia, DATEPART(MONTH, cp.HastaFecha) AS FVMes, 
            DATEPART(YEAR,cp.HastaFecha) AS FVAnio,cp.idIngreso  from CERTProyecto AS cp
            INNER JOIN Ingreso AS i ON i.idIngreso = cp.idIngreso
            INNER JOIN Persona AS p On p.idDNI = i.idDNI
            INNER JOIN Especialidad AS e On e.idEspecialidad = cp.idColegiatura
            INNER JOIN Ubigeo AS u ON u.IdUbigeo = cp.idUbigeo
            INNER JOIN Colegiatura AS c ON c.idEspecialidad = cp.idColegiatura
            WHERE cp.idIngreso = ?");
            $cmdCertProyecto->bindParam(1, $idIngreso, PDO::PARAM_INT);
            $cmdCertProyecto->execute();

            while ($row = $cmdCertProyecto->fetch()) {
                array_push($arrayCertProyecto, array(
                    "idIngreso" => $row["idIngreso"],
                    "cip" => $row["CIP"],
                    "dni" => $row["NumDoc"],
                    "usuario" => $row["Nombres"],
                    "apellidos" => $row["Apellidos"],
                    "especialidad" => $row["Especialidad"],
                    "numCertificado" => $row["Numero"],
                    "modalidad" => $row["Modalidad"],
                    "propietario" => $row["Propietario"],
                    "proyecto" => $row["Proyecto"],
                    "monto" => $row["Monto"],
                    "departamento" => $row["Departamento"],
                    "provincia" => $row["Provincia"],
                    "distrito" => $row["Distrito"],
                    "adicional1" => $row["Adicional1"],
                    "adicional2" => $row["Adicional2"],
                    "fechaIncorporacion" => $row["FechaIncorporacion"],
                    "fiDia" => $row["FIDia"],
                    "fiMes" => $row["FIMes"],
                    "fiAnio" => $row["FIAnio"],
                    "fechaRegistro" => $row["FechaRegistro"],
                    "frDia" => $row["FRDia"],
                    "frMes" => $row["FRMes"],
                    "frAnio" => $row["FRAnio"],
                    "fechaVencimiento" => $row["HastaFecha"],
                    "fvDia" => $row["FVDia"],
                    "fvMes" => $row["FVMes"],
                    "fvAnio" => $row["FVAnio"],
                ));
            }

            return $arrayCertProyecto;
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

    public static function CambiarEstadoSunatResumen($idIngreso, $codigo, $descripcion, $hash, $correlativo, $fechaCorrelativo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comando = Database::getInstance()->getDb()->prepare("UPDATE 
            Ingreso SET 
            Xmlsunat = ? , 
            Xmldescripcion = ?, 
            CodigoHash = ?,
            Correlativo = ?,
            FechaCorrelativo = ? 
            WHERE idIngreso = ?");
            $comando->bindParam(1, $codigo, PDO::PARAM_STR);
            $comando->bindParam(2, $descripcion, PDO::PARAM_STR);
            $comando->bindParam(3, $hash, PDO::PARAM_STR);
            $comando->bindParam(4, $correlativo, PDO::PARAM_INT);
            $comando->bindParam(5, $fechaCorrelativo, PDO::PARAM_STR);
            $comando->bindParam(6, $idIngreso, PDO::PARAM_INT);
            $comando->execute();
            Database::getInstance()->getDb()->commit();
            return "updated";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function DetalleIngresoPorIdIngreso($idIngreso)
    {
        try {
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
                    "Precio" => floatval($row["Precio"]),
                    "Cantidad" => floatval($row["Cantidad"]),
                    "Total" => floatval($row["Total"])
                ));
            }

            return $detalleIngreso;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ResumenIngresosPorFecha($fechaInicio, $fechaFinal)
    {
        try {
            $array = array();

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
            WHERE i.Estado = 'C' AND  i.Fecha  >= ? and i.Fecha  <= ? 
            GROUP BY c.Codigo,c.Concepto,c.Propiedad
            ORDER BY c.Concepto ASC");
            $cmdConcepto->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdConcepto->bindParam(2, $fechaFinal, PDO::PARAM_STR);
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

            $cmdMinMaxRecibos = Database::getInstance()->getDb()->prepare("SELECT 
            min(Serie) as SerieMin,
            min(NumRecibo) NumReciboMin,
            max(Serie) as SerieMax,
            max(NumRecibo) as NumReciboMax 
            from Ingreso 
            where Estado = 'C' AND Fecha >= ? and Fecha  <= ?");
            $cmdMinMaxRecibos->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdMinMaxRecibos->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdMinMaxRecibos->execute();
            $resultRecibos = $cmdMinMaxRecibos->fetchObject();

            array_push($array, $arrayIngresos, $resultRecibos);

            return $array;
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

    public static function ResumenAporteCIN($data)
    {
        try {
            $arrayIngresos = array();
            if ($data['Opcion'] == 0) {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT  Persona.CIP, 
                MAX (CASE WHEN Concepto.Concepto = 'Cuotas al ISS CIP'
                        THEN  Concepto.Concepto
                        ELSE 'Cuotas al ISS CIP'      
                    END) AS Concepto1,
                Max (CASE WHEN Concepto.Concepto = 'Cuotas Sociales CIP'
                        THEN  Concepto.Concepto	
                        ELSE 'Cuotas Sociales CIP'     
                    END) AS Concepto2, 
                Ingreso.idIngreso, 
                Cuota.FechaIni,
                Cuota.FechaFin,
                Ingreso.Fecha,
                Ingreso.idDNI,
                Persona.Condicion, 
                Persona.Apellidos+' '+Persona.Nombres AS Ingeniero,
                Especialidad.Especialidad,
                Capitulo.Capitulo,
                --MAX(CASE WHEN Condicion='V' and Concepto.concepto <> 'Cuotas Sociales CIP' THEN 0 ELSE Monto2 END) AS Monto2,
                --MAX(Monto1) AS Monto1,
                MAX(CASE WHEN Concepto.Concepto = 'Cuotas al ISS CIP'
                        THEN  Detalle.Monto/Detalle.Cantidad 
                        ELSE 0		    
                    END) AS Monto1,	
                MAX(CASE WHEN Concepto.Concepto = 'Cuotas Sociales CIP'
                        THEN  Detalle.Monto/Detalle.Cantidad 
                        ELSE 0		      
                    END) AS Monto2
                FROM Ingreso
                INNER JOIN Cuota ON Cuota.idIngreso=Ingreso.idIngreso
                INNER JOIN Detalle ON Detalle.idIngreso=Ingreso.idIngreso
                INNER JOIN Concepto ON Concepto.idConcepto=Detalle.idConcepto 	
                INNER JOIN Persona ON Persona.idDNI=Ingreso.idDNI
                INNER JOIN Colegiatura ON Colegiatura.idDNI=PERSONA.idDNI AND Colegiatura.Principal=1
                INNER JOIN Especialidad ON Especialidad.idEspecialidad = Colegiatura.idEspecialidad
                INNER JOIN Capitulo ON Capitulo.idCapitulo = Especialidad.idCapitulo
                WHERE Ingreso.Fecha  BETWEEN ? AND ? AND Ingreso.Estado<>'A'
                AND (Concepto.Concepto = 'Cuotas al ISS CIP' or Concepto.Concepto =  'Cuotas Sociales CIP')
                GROUP BY Persona.CIP, Concepto.Concepto, Ingreso.idIngreso, Ingreso.idDNI,Persona.Condicion, Persona.Apellidos+' '+Persona.Nombres,
                Cuota.FechaIni,Cuota.FechaFin,Ingreso.Fecha,Especialidad.Especialidad,Capitulo.Capitulo
                ORDER BY Persona.Apellidos+' '+Persona.Nombres ASC");
                $cmdConcepto->bindParam(1, $data['FechaInicial'], PDO::PARAM_STR);
                $cmdConcepto->bindParam(2, $data['FechaFinal'], PDO::PARAM_STR);
                $cmdConcepto->execute();
            } else {
                $cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT  Persona.CIP, 
                MAX (CASE WHEN Concepto.Concepto = 'Cuotas al ISS CIP'
                    THEN  Concepto.Concepto
                    ELSE 'Cuotas al ISS CIP'      
                END) AS Concepto1,
                Max (CASE WHEN Concepto.Concepto = 'Cuotas Sociales CIP'
                    THEN  Concepto.Concepto	
                    ELSE 'Cuotas Sociales CIP'     
                END) AS Concepto2, 
                Ingreso.idIngreso, 
                Cuota.FechaIni,
                Cuota.FechaFin,
                Ingreso.Fecha,
                Ingreso.idDNI,
                Persona.Condicion, 
                Persona.Apellidos+' '+Persona.Nombres AS Ingeniero,
                Especialidad.Especialidad,
                Capitulo.Capitulo,
                --MAX(CASE WHEN Condicion='V' and Concepto.concepto <> 'Cuotas Sociales CIP' THEN 0 ELSE Monto2 END) AS Monto2,
                --MAX(Monto1) AS Monto1,
                MAX(CASE WHEN Concepto.Concepto = 'Cuotas al ISS CIP'
                    THEN  Detalle.Monto/Detalle.Cantidad 
                    ELSE 0		    
                END) AS Monto1,	
                MAX(CASE WHEN Concepto.Concepto = 'Cuotas Sociales CIP'
                    THEN  Detalle.Monto/Detalle.Cantidad 
                    ELSE 0		      
                END) AS Monto2
                FROM Ingreso
                INNER JOIN Cuota ON Cuota.idIngreso=Ingreso.idIngreso
                INNER JOIN Detalle ON Detalle.idIngreso=Ingreso.idIngreso
                INNER JOIN Concepto ON Concepto.idConcepto=Detalle.idConcepto 	
                INNER JOIN Persona ON Persona.idDNI=Ingreso.idDNI
                INNER JOIN Colegiatura ON Colegiatura.idDNI=PERSONA.idDNI AND Colegiatura.Principal=1
                INNER JOIN Especialidad ON Especialidad.idEspecialidad = Colegiatura.idEspecialidad
                INNER JOIN Capitulo ON Capitulo.idCapitulo = Especialidad.idCapitulo
                WHERE Persona.NumDoc = ? AND Ingreso.Fecha  BETWEEN ? AND ? AND Ingreso.Estado<>'A'
                AND (Concepto.Concepto = 'Cuotas al ISS CIP' or Concepto.Concepto =  'Cuotas Sociales CIP')
                GROUP BY Persona.CIP, Concepto.Concepto, Ingreso.idIngreso, Ingreso.idDNI,Persona.Condicion, Persona.Apellidos+' '+Persona.Nombres,
                Cuota.FechaIni,Cuota.FechaFin,Ingreso.Fecha,Especialidad.Especialidad,Capitulo.Capitulo
                ORDER BY Persona.Apellidos+' '+Persona.Nombres ASC");
                $cmdConcepto->bindParam(1, $data['Colegiado'], PDO::PARAM_STR);
                $cmdConcepto->bindParam(2, $data['FechaInicial'], PDO::PARAM_STR);
                $cmdConcepto->bindParam(3, $data['FechaFinal'], PDO::PARAM_STR);
                $cmdConcepto->execute();
            }


            while ($row = $cmdConcepto->fetch(PDO::FETCH_ASSOC)) {
                array_push($arrayIngresos, $row);
            }

            return $arrayIngresos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function isValidate($array, $objec)
    {
        $ret = false;
        foreach ($array as $value) {
            if ($value["idDNI"] == $objec["idDNI"] && $value["Year"] == $objec["Year"]) {
                $ret = true;
                break;
            }
        }
        return $ret;
    }

    public static function ReporteGeneralIngresosPorFechas($fechaInicio, $fechaFinal)
    {
        try {
            $cmdDetalle = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            isnull(a.Motivo,'') as MotivoAnulacion,
            isnull(a.Fecha,'') as FechaAnulacion,
            i.Serie,
            i.NumRecibo,
            convert(varchar, cast(i.Fecha as date), 103) as FechaPago,
			CASE 
             WHEN NOT cu.idCuota IS NULL THEN 1
             WHEN NOT ac.idAltaColegio IS NULL THEN 4 
             WHEN NOT ch.idHabilidad IS NULL THEN 5 
             WHEN NOT cr.idResidencia IS NULL THEN 6 
             WHEN NOT cp.idProyecto IS NULL THEN 7 
             WHEN NOT pe.idPeritaje IS NULL THEN 8 
             ELSE 100 END AS TipoIngreso,
            i.Estado,
            p.CIP,
            isnull(e.NumeroRuc,p.NumDoc) as NumeroDocumento,            
            isnull(e.Nombre, concat(p.Apellidos,' ',p.Nombres)) as Persona,
            sum(d.Monto) as Total,
            isnull(i.Xmlsunat,'') as Xmlsunat,
            isnull(i.Xmldescripcion,'') as Xmldescripcion							
            from Ingreso as i 
			LEFT OUTER JOIN Cuota AS cu ON cu.idIngreso = i.idIngreso 
            LEFT OUTER JOIN AltaColegio AS ac ON ac.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTHabilidad AS ch ON ch.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTResidencia AS cr ON cr.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTProyecto AS cp ON cp.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Peritaje AS pe ON pe.idIngreso = i.idIngreso
            left join Persona as p on i.idDNI = p.idDNI
            left join EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona 
            inner join Detalle as d on d.idIngreso = i.idIngreso 
            inner join Concepto as c on d.idConcepto = c.idConcepto
            left join Anulado as a on a.idDocumento = i.idIngreso
            where
            cast(i.Fecha as date) between ? and ?
            group by i.idIngreso,
            i.Serie,
            i.NumRecibo,
            i.Fecha,
            i.Estado,
            p.NumDoc,
            p.CIP,
            p.Apellidos,
            p.Nombres,
            e.NumeroRuc,
            e.Nombre,
            i.Xmlsunat,
            i.Xmldescripcion,
            a.Motivo,
            a.Fecha,
			cu.idCuota,
			ac.idAltaColegio,
			ch.idHabilidad,
			cr.idResidencia,
			cp.idProyecto,
			pe.idPeritaje
            order by CAST(i.Fecha as date) desc, i.NumRecibo desc");
            $cmdDetalle->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdDetalle->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdDetalle->execute();

            $arrayDetalle = array();
            $count = 0;
            while ($row = $cmdDetalle->fetch()) {
                $count++;
                array_push($arrayDetalle, array(
                    "Id" => $count,
                    "idIngreso" => $row["idIngreso"],
                    "MotivoAnulacion" => $row["MotivoAnulacion"],
                    "FechaAnulacion" => $row["FechaAnulacion"],
                    "Serie" => $row["Serie"],
                    "NumRecibo" => $row["NumRecibo"],
                    "FechaPago" => $row["FechaPago"],
                    "Concepto" => $row["TipoIngreso"],
                    "Estado" => $row["Estado"],
                    "NumeroDocumento" => $row["NumeroDocumento"],
                    "CIP" => $row["CIP"],
                    "Persona" => $row["Persona"],
                    "Total" => floatval($row["Total"]),
                    "Xmlsunat" => $row["Xmlsunat"],
                    "Xmldescripcion" => $row["Xmldescripcion"],
                ));
            }

            return $arrayDetalle;
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public static function ReporteGeneralIngresosPorFechasyTipoDocumento($fechaInicio, $fechaFinal, $tipoDocumento)
    {
        try {
            $cmdDetalle = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            isnull(a.Motivo,'') as MotivoAnulacion,
            isnull(a.Fecha,'') as FechaAnulacion,
            i.Serie,
            i.NumRecibo,
            convert(varchar, cast(i.Fecha as date), 103) as FechaPago,
			CASE 
             WHEN NOT cu.idCuota IS NULL THEN 1
             WHEN NOT ac.idAltaColegio IS NULL THEN 4 
             WHEN NOT ch.idHabilidad IS NULL THEN 5 
             WHEN NOT cr.idResidencia IS NULL THEN 6 
             WHEN NOT cp.idProyecto IS NULL THEN 7 
             WHEN NOT pe.idPeritaje IS NULL THEN 8 
             ELSE 100 END AS TipoIngreso,
            i.Estado,
            p.CIP,
            isnull(e.NumeroRuc,p.NumDoc) as NumeroDocumento,            
            isnull(e.Nombre, concat(p.Apellidos,' ',p.Nombres)) as Persona,
            sum(d.Monto) as Total,
            isnull(i.Xmlsunat,'') as Xmlsunat,
            isnull(i.Xmldescripcion,'') as Xmldescripcion							
            from Ingreso as i 
			LEFT OUTER JOIN Cuota AS cu ON cu.idIngreso = i.idIngreso 
            LEFT OUTER JOIN AltaColegio AS ac ON ac.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTHabilidad AS ch ON ch.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTResidencia AS cr ON cr.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTProyecto AS cp ON cp.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Peritaje AS pe ON pe.idIngreso = i.idIngreso
            left join Persona as p on i.idDNI = p.idDNI
            left join EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona 
            inner join Detalle as d on d.idIngreso = i.idIngreso 
            inner join Concepto as c on d.idConcepto = c.idConcepto
            left join Anulado as a on a.idDocumento = i.idIngreso
            where
            (cast(i.Fecha as date) between ? and ?) and i.TipoComprobante = ?
            group by i.idIngreso,
            i.Serie,
            i.NumRecibo,
            i.Fecha,
            i.Estado,
            p.NumDoc,
            p.CIP,
            p.Apellidos,
            p.Nombres,
            e.NumeroRuc,
            e.Nombre,
            i.Xmlsunat,
            i.Xmldescripcion,
            a.Motivo,
            a.Fecha,
			cu.idCuota,
			ac.idAltaColegio,
			ch.idHabilidad,
			cr.idResidencia,
			cp.idProyecto,
			pe.idPeritaje
            order by CAST(i.Fecha as date) desc, i.NumRecibo desc");
            $cmdDetalle->bindParam(1, $fechaInicio, PDO::PARAM_STR);
            $cmdDetalle->bindParam(2, $fechaFinal, PDO::PARAM_STR);
            $cmdDetalle->bindParam(3, $tipoDocumento, PDO::PARAM_STR);
            $cmdDetalle->execute();

            $arrayDetalle = array();
            $count = 0;
            while ($row = $cmdDetalle->fetch()) {
                $count++;
                array_push($arrayDetalle, array(
                    "Id" => $count,
                    "idIngreso" => $row["idIngreso"],
                    "MotivoAnulacion" => $row["MotivoAnulacion"],
                    "FechaAnulacion" => $row["FechaAnulacion"],
                    "Serie" => $row["Serie"],
                    "NumRecibo" => $row["NumRecibo"],
                    "FechaPago" => $row["FechaPago"],
                    "Estado" => $row["Estado"],
                    "Concepto" => $row["TipoIngreso"],
                    "NumeroDocumento" => $row["NumeroDocumento"],
                    "CIP" => $row["CIP"],
                    "Persona" => $row["Persona"],
                    "Total" => floatval($row["Total"]),
                    "Xmlsunat" => $row["Xmlsunat"],
                    "Xmldescripcion" => $row["Xmldescripcion"],
                ));
            }

            return $arrayDetalle;
        } catch (Exception $ex) {
            return $ex;
        }
    }


    public static function ObtenerIngresoForNotaCredito($comprobante)
    {
        try {
            $array = array();

            $arrayNotaCredito = array();
            $cmdNotaCredito = Database::getInstance()->getDb()->prepare("SELECT IdTipoComprobante,Nombre FROM TipoComprobante WHERE Estado = 1 and ComprobanteAfiliado = 3");
            $cmdNotaCredito->execute();

            while ($row = $cmdNotaCredito->fetch()) {
                array_push($arrayNotaCredito, array(
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"]
                ));
            }

            $arrayFacturado = array();
            $cmdFacturado = Database::getInstance()->getDb()->prepare("SELECT IdTipoComprobante,Nombre FROM TipoComprobante WHERE Estado = 1 and ComprobanteAfiliado = 2");
            $cmdFacturado->execute();
            while ($row = $cmdFacturado->fetch()) {
                array_push($arrayFacturado, array(
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"],
                ));
            }

            $arrayMotivo = array();
            $cmdMotivoAnulacion = Database::getInstance()->getDb()->prepare("SELECT IdTablaMotivoAnulacion,Nombre FROM TablaMotivoAnulacion");
            $cmdMotivoAnulacion->execute();
            while ($row = $cmdMotivoAnulacion->fetch()) {
                array_push($arrayMotivo, $row);
            }


            $cmdIngreso = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso,
            t.IdTipoComprobante AS TipoComprobante,
            t.Nombre AS Comprobante,
            i.Serie,i.NumRecibo AS Numeracion,
            i.Fecha AS FechaPago,
            i.Hora as HoraPago,
            isnull(e.IdEmpresa,p.idDNI) as IdPersona,
            case when not e.IdEmpresa is null then 6 else 1 end as TipoDocumento,
            isnull(e.NumeroRuc,p.NumDoc) as NumeroDocumento,
            isnull(e.Nombre,concat(p.Apellidos,' ',p.Nombres)) as DatosPersona,
            isnull(e.Direccion,p.RUC) as Direccion
            FROM Ingreso AS i 
            INNER JOIN Persona AS p ON p.idDNI = i.idDNI
			LEFT JOIN EmpresaPersona AS e ON e.IdEmpresa = i.idEmpresaPersona
            INNER JOIN TipoComprobante AS t ON t.IdTipoComprobante = i.TipoComprobante          
            WHERE CONCAT(i.Serie,'-', i.NumRecibo) = ? AND i.Estado = 'C' ");
            $cmdIngreso->bindParam(1, $comprobante, PDO::PARAM_STR);
            $cmdIngreso->execute();
            $resultIngreso = $cmdIngreso->fetchObject();

            if (!is_object($resultIngreso)) {
                throw new Exception("No se puedo encontrar el comprobante, ingrese correctamente la serie y numeración.");
            }

            $detalleIngreso = array();
            $cmdDetail = Database::getInstance()->getDb()->prepare("SELECT 
            d.idConcepto,
            c.Concepto,            
            (d.Monto/d.Cantidad) AS Precio,
            d.Cantidad,
            d.Monto AS Total,
            i.Valor
            FROM Detalle AS d 
            INNER JOIN Concepto AS c ON d.idConcepto = c.idConcepto
            INNER JOIN Impuesto AS i ON i.IdImpuesto = c.IdImpuesto
            WHERE d.idIngreso  = ?");
            $cmdDetail->bindParam(1, $resultIngreso->idIngreso, PDO::PARAM_INT);
            $cmdDetail->execute();
            while ($row = $cmdDetail->fetch(PDO::FETCH_ASSOC)) {
                array_push($detalleIngreso, array(
                    "idConcepto" => $row["idConcepto"],
                    "Concepto" => $row["Concepto"],
                    "Cantidad" => floatval($row["Cantidad"]),
                    "Precio" => floatval($row["Precio"]),
                    "Total" => floatval($row["Total"]),
                    "Valor" => floatval($row["Valor"])
                ));
            }

            array_push($array, $arrayNotaCredito, $arrayFacturado, $arrayMotivo, $resultIngreso,  $detalleIngreso);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function Notificaciones()
    {
        try {
            $array = array();

            $cmdIngreso = Database::getInstance()->getDb()->prepare("SELECT 
            td.Nombre,       
            CASE i.Estado WHEN 'A' THEN 'Dar de Baja' ELSE 'Por Declarar' END AS Estado,
            count(i.Serie) AS Cantidad
            FROM Ingreso AS i
            INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = i.TipoComprobante
            WHERE
            ISNULL(i.Xmlsunat,'') <> '0' AND ISNULL(i.Xmlsunat,'') <> '1032'	           
            GROUP BY td.Nombre,i.Estado ");
            $cmdIngreso->execute();
            while ($row = $cmdIngreso->fetch()) {
                array_push($array, array(
                    "Nombre" => $row["Nombre"],
                    "Estado" => $row["Estado"],
                    "Cantidad" => $row["Cantidad"]
                ));
            }

            $cmdNotaCredito  = Database::getInstance()->getDb()->prepare("SELECT 
            td.Nombre,        
            'Por Declarar' AS Estado,
            count(nc.Serie) AS Cantidad
            FROM NotaCredito AS nc
            INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = nc.TipoComprobante
            WHERE
            ISNULL(nc.Xmlsunat,'') <> '0' AND ISNULL(nc.Xmlsunat,'') <> '1032'	           
            GROUP BY td.Nombre");
            $cmdNotaCredito->execute();
            while ($row = $cmdNotaCredito->fetch()) {
                array_push($array, array(
                    "Nombre" => $row["Nombre"],
                    "Estado" => $row["Estado"],
                    "Cantidad" => $row["Cantidad"]
                ));
            }

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function ListarNotificaciones($posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();


            $cmdIngreso = Database::getInstance()->getDb()->prepare("SELECT 
            td.Nombre,       
			i.Serie,
			i.NumRecibo,
            CASE i.Estado WHEN 'A' THEN 'Dar de Baja' ELSE 'Por Declarar' END AS Estado,
			i.Fecha,
			i.Hora
            FROM Ingreso AS i
            INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = i.TipoComprobante
			WHERE ISNULL(i.Xmlsunat,'') <> '0' AND ISNULL(i.Xmlsunat,'') <> '1032'
			UNION
            SELECT 
            td.Nombre,       
			i.Serie,
			i.NumRecibo,
            'Por Declarar' AS Estado,
			i.Fecha,
			i.Hora
            FROM NotaCredito AS i
            INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = i.TipoComprobante
			WHERE ISNULL(i.Xmlsunat,'') <> '0' AND ISNULL(i.Xmlsunat,'') <> '1032'
			ORDER BY Fecha DESC,Hora DESC 
			offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdIngreso->bindParam(1, $posicionPagina, PDO::PARAM_INT);
            $cmdIngreso->bindParam(2, $filasPorPagina, PDO::PARAM_INT);
            $cmdIngreso->execute();
            $arrayNotificaciones = array();
            $count = 0;
            while ($row = $cmdIngreso->fetch()) {
                $count++;
                array_push($arrayNotificaciones, array(
                    "Id" => $count + $posicionPagina,
                    "Nombre" => $row["Nombre"],
                    "Serie" => $row["Serie"],
                    "NumRecibo" => $row["NumRecibo"],
                    "Estado" => $row["Estado"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"]
                ));
            }


            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT 
            count(i.idIngreso) as Total
               FROM Ingreso AS i
               INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = i.TipoComprobante
               WHERE ISNULL(i.Xmlsunat,'') <> '0' AND ISNULL(i.Xmlsunat,'') <> '1032'
               union
            SELECT 
               count(i.idNotaCredito) as Total
               FROM NotaCredito AS i
               INNER JOIN TipoComprobante AS td ON td.IdTipoComprobante = i.TipoComprobante
               WHERE ISNULL(i.Xmlsunat,'') <> '0' AND ISNULL(i.Xmlsunat,'') <> '1032'");
            $comandoTotal->execute();
            $resultTotal = 0;
            while ($row = $comandoTotal->fetch()) {
                $resultTotal +=  $row["Total"];
            }

            array_push($array, $arrayNotificaciones, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
