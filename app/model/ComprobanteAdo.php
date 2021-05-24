<?php

require_once '../database/DataBaseConexion.php';

class ComprobanteAdo
{

    public function construct()
    {
    }

    public static function getAllComprobates()
    {
        try {
            $array = array();
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante WHERE Estado = 1 and ComprobanteAfiliado = 2");
            $comandoConcepto->execute();
            while ($row = $comandoConcepto->fetch()) {
                array_push($array, array(
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"],
                    "Predeterminado" => $row["Predeterminado"],
                    "UsarRuc" => $row["UsarRuc"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllEmpresaPersona()
    {
        try {
            $array = array();
            $comandoEmpresa = Database::getInstance()->getDb()->prepare("SELECT idEmpresa, NumeroRuc, Nombre FROM EmpresaPersona");
            $comandoEmpresa->execute();

            while ($row = $comandoEmpresa->fetch()) {
                array_push($array, array(
                    "IdEmpresa" => $row["idEmpresa"],
                    "NumeroDocumento" => $row["NumeroRuc"],
                    "RazonSocial" => $row["Nombre"],
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getListComprobantes($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayListComprobante = array();
            $cmdListComprobante = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante
            WHERE 
            Nombre like concat('%', ?,'%')
            OR
            Serie = ?
            OR
            Numeracion = ?  
            ORDER BY IdTipoComprobante ASC
            offset ? rows fetch next ? rows only");
            $cmdListComprobante->bindParam(1, $nombres, PDO::PARAM_STR);

            $cmdListComprobante->bindParam(2, $nombres, PDO::PARAM_STR);

            $cmdListComprobante->bindParam(3, $nombres, PDO::PARAM_STR);

            $cmdListComprobante->bindParam(4, $posicionPagina, PDO::PARAM_INT);
            $cmdListComprobante->bindParam(5, $filasPorPagina, PDO::PARAM_INT);
            $cmdListComprobante->execute();
            $count = 0;
            while ($row = $cmdListComprobante->fetch()) {
                $count++;
                array_push($arrayListComprobante, array(
                    "Id" => $count + $posicionPagina,
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"],
                    "Serie" => $row["Serie"],
                    "Numeracion" => $row["Numeracion"],
                    "CodigoAlterno" => $row["CodigoAlterno"],
                    "Predeterminado" => $row["Predeterminado"] == 1 ? 'SI' : 'NO',
                    "Estado" => $row["Estado"] == 1 ? 'ACTIVO' : 'INACTIVO',
                    "Usa_ruc" => $row["UsarRuc"] == 1 ? 'SI' : 'NO'
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM TipoComprobante 
            WHERE
            Nombre like concat('%', ?,'%')
            OR
            Serie = ?
            OR
            Numeracion = ?");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);

            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);

            $comandoTotal->bindParam(3, $nombres, PDO::PARAM_STR);

            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayListComprobante, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function RegistrarComprobante($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM TipoComprobante where IdTipoComprobante = ?');
            $cmdSelect->bindParam(1, $data['IdComprobante'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante WHERE IdTipoComprobante <> ? AND Nombre =?");
                $cmdSelect->bindParam(1, $data["IdComprobante"], PDO::PARAM_INT);
                $cmdSelect->bindParam(2, $data["Nombre"], PDO::PARAM_STR);
                $cmdSelect->execute();
                if ($cmdSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return 'Duplicado';
                } else {
                    $cmdInsert = Database::getInstance()->getDb()->prepare("UPDATE TipoComprobante SET Nombre = UPPER(?), Serie =UPPER(?), Numeracion = ?, CodigoAlterno = ?, 
                    Predeterminado = ?, Estado = ?, UsarRuc = ?, ComprobanteAfiliado = ? WHERE IdTipoComprobante = ?");
                    $cmdInsert->bindParam(1, $data["Nombre"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(2, $data["Serie"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(3, $data["Numeracion"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(4, $data["CodigoAlterno"], PDO::PARAM_STR);
                    $cmdInsert->bindParam(5, $data["Predeterminado"], PDO::PARAM_BOOL);
                    $cmdInsert->bindParam(6, $data["Estado"], PDO::PARAM_BOOL);
                    $cmdInsert->bindParam(7, $data["UsaRuc"], PDO::PARAM_BOOL);
                    $cmdInsert->bindParam(8, $data["Asignado"], PDO::PARAM_INT);
                    $cmdInsert->bindParam(9, $data["IdComprobante"], PDO::PARAM_INT);

                    $cmdInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return "Actualizado";
                }
            } else {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante WHERE Nombre = ?");
                $cmdSelect->bindParam(1, $data["Nombre"], PDO::PARAM_STR);
                $cmdSelect->execute();
                if ($cmdSelect->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return 'Duplicado';
                } else {
                    $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO TipoComprobante (
                        Nombre,
                        Serie,
                        Numeracion,
                        CodigoAlterno, 
                        Predeterminado,
                        Estado, 
                        UsarRuc,
                        ComprobanteAfiliado)
                    VALUES(UPPER(?),UPPER(?),?,?,?,?,?,?)");

                    $comandoInsert->bindParam(1, $data["Nombre"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(2, $data["Serie"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(3, $data["Numeracion"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(4, $data["CodigoAlterno"], PDO::PARAM_STR);
                    $comandoInsert->bindParam(5, $data["Predeterminado"], PDO::PARAM_BOOL);
                    $comandoInsert->bindParam(6, $data["Estado"], PDO::PARAM_BOOL);
                    $comandoInsert->bindParam(7, $data["UsaRuc"], PDO::PARAM_BOOL);
                    $comandoInsert->bindParam(8, $data["Asignado"], PDO::PARAM_INT);

                    $comandoInsert->execute();
                    Database::getInstance()->getDb()->commit();
                    return 'Insertado';
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getDataByIdComprobante($idComprobante)
    {
        try {
            $cmdComprobante = Database::getInstance()->getDb()->prepare("SELECT IdTipoComprobante, UPPER(Nombre) As Nombre, UPPER(Serie) AS Serie, Numeracion, CodigoAlterno, Predeterminado, 
            Estado, UsarRuc, ComprobanteAfiliado from TipoComprobante            
            WHERE IdTipoComprobante = ?");
            $cmdComprobante->bindParam(1, $idComprobante, PDO::PARAM_INT);
            $cmdComprobante->execute();
            $resultComprobante = $cmdComprobante->fetchObject();
            return $resultComprobante;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllNotasCredito()
    {
        try {
            $array = array();
            $cmdComprobante = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante WHERE Estado = 1 and ComprobanteAfiliado = 3");
            $cmdComprobante->execute();

            while ($row = $cmdComprobante->fetch()) {
                array_push($array, array(
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"],
                    "Serie" => $row["Serie"],
                    "Numeracion" => $row["Numeracion"],
                    "CodigoAlterno" => $row["CodigoAlterno"],
                    "Predeterminado" => $row["Predeterminado"] == 1 ? 'SI' : 'NO',
                    "Estado" => $row["Estado"] == 1 ? 'ACTIVO' : 'INACTIVO',
                    "Usa_ruc" => $row["UsarRuc"] == 1 ? 'SI' : 'NO',
                    "ComprobanteAfiliado" => $row["ComprobanteAfiliado"]
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
