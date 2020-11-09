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

}
