<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class ModuloAdo{

    public function construct(){}

    public static function getAllRoles($nombres, $posicionPagina, $filasPorPagina){
        try {
            $array = array();
            $arrayModulos = array();
            $comando = Database::getInstance()->getDb()->prepare("SELECT * FROM Modulo 
            where Nombre like concat('%', ?,'%')
            ORDER BY idModulo ASC
            offset ? rows fetch next ? rows only");
            $comando->bindParam(1, $nombres, PDO::PARAM_STR);
            $comando->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $comando->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $comando->execute();
            $count = 0;
            while ($row = $comando->fetch()) {
                $count++;
                array_push($arrayModulos, array(
                    "Id" => $count + $posicionPagina,
                    "IdModulo" => $row["idModulo"],
                    "Nombre" => $row["Nombre"],
                    "Estado" => $row["Estado"] 

                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Modulo 
            where Nombre like concat('%',?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayModulos, $resultTotal);

            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }

    }

}