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
            $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante");
            $comandoConcepto->execute();
            while ($row = $comandoConcepto->fetch()) {
                array_push($array, array(
                    "IdTipoComprobante" => $row["IdTipoComprobante"],
                    "Nombre" => $row["Nombre"],
                    "Predeterminado" => $row["Predeterminado"],
                ));
            }
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // public static function getAllConceptos()
    // {
    //     try {
    //         $array = array();
    //         $comandoConcepto = Database::getInstance()->getDb()->prepare("SELECT * FROM TipoComprobante");
    //         $comandoConcepto->execute();
    //         while ($row = $comandoConcepto->fetch()) {
    //             array_push($array, array(
    //                 "IdTipoComprobante" => $row["IdTipoComprobante"],
    //                 "Nombre" => $row["Nombre"],
    //                 "Predeterminado" => $row["Predeterminado"],
    //             ));
    //         }
    //         return $array;
    //     } catch (Exception $ex) {
    //         return $ex->getMessage();
    //     }
    // }

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
}
