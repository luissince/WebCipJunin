<?php

require_once '../database/DataBaseConexion.php';

class PersonaAdo{

    public function construct()
    {
    } 


    public static function getAll($posicionPagina,$filasPorPagina){
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona 
            order by CAST(FechaReg as date) asc
            offset ? rows fetch next ? rows only");
            $comandoPersona->bindParam(1, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(2, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    "Id" => $count+$posicionPagina,
                    "idDNI"=>$row["idDNI"],
                    "Nombres"=>$row["Nombres"],
                    "Apellidos"=>$row["Apellidos"],
                    "EstadoCivil"=>$row["EstadoCivil"],
                    "Ruc"=>$row["RUC"],
                    "Cip"=>$row["CIP"],
                    "Condicion"=>$row["Condicion"]
                    
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Persona");
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();
           
            array_push($array, $arrayPersonas, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getId($idPersona){
        try {
            $object = null;
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
                idDNI,
                idUsuario,
                Nombres,
                Apellidos,
                Sexo,
                cast(FechaNac as date) as FechaNacimiento,
                EstadoCivil,
                FechaReg,
                RUC,
                CIP,
                Condicion,
                TEMP,
                RAZONSOCIAL,
                DIRECCION
            FROM Persona WHERE idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insert(){

    }

    public static function update(){

    }

    public static function delete(){

    }


}