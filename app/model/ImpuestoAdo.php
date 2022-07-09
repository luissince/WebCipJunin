<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use PDOException;
use Exception;
use DateTime;

class ImpuestoAdo
{

    public function construct()
    {
    }

    public static function AllImpuestoForComboBox()
    {
        try {
            $arrayImpuestos = array();
            $cmdImpuesto = Database::getInstance()->getDb()->prepare("SELECT IdImpuesto,Nombre FROM Impuesto");
            $cmdImpuesto->execute();
            while ($row =  $cmdImpuesto->fetch(PDO::FETCH_ASSOC)) {
                array_push($arrayImpuestos, $row);
            }
            return $arrayImpuestos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
