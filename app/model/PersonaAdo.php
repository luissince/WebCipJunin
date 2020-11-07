<?php

require_once '../database/DataBaseConexion.php';

class PersonaAdo
{

    public function construct()
    {
    }


    public static function getAll($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona 
            where Nombres like concat(?,'%') or Apellidos like concat(?,'%')
            order by CAST(FechaReg as date) asc
            offset ? rows fetch next ? rows only");
            $comandoPersona->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    "Id" => $count + $posicionPagina,
                    "idDNI" => $row["idDNI"],
                    "Nombres" => $row["Nombres"],
                    "Apellidos" => $row["Apellidos"],
                    "EstadoCivil" => $row["EstadoCivil"],
                    "Ruc" => $row["RUC"],
                    "Cip" => $row["CIP"],
                    "Condicion" => $row["Condicion"]

                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Persona
            where Nombres like concat(?,'%') or Apellidos like concat(?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayPersonas, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getId($idPersona)
    {
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
                RAZONSOCIAL
            FROM Persona WHERE idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();
            return $object;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    // public static function insert(){

    // }

    public static function update($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona
            WHERE idDNI = ?");
            $comandoValidate->bindParam(1, $persona["dni"], PDO::PARAM_STR);
            $comandoValidate->execute();
            $resultValue = $comandoValidate->fetchColumn();
            if ($resultValue > 0) {
                $comandoPersona = Database::getInstance()->getDb()->prepare("UPDATE Persona SET 
                Nombres = ?,
                Apellidos = ?,
                Sexo = ?,
                FechaNac = ?,
                EstadoCivil = ?,
                RUC = ?,
                RAZONSOCIAL = ?,
                CIP = ?,
                Condicion = ?      
                WHERE idDNI = ?");

                $dateTime = date('Y-d-m H:i:s', strtotime($persona["nacimiento"]));

                $comandoPersona->bindParam(1, $persona["nombres"], PDO::PARAM_STR);
                $comandoPersona->bindParam(2, $persona["apellidos"], PDO::PARAM_STR);
                $comandoPersona->bindParam(3, $persona["sexo"], PDO::PARAM_STR);
                $comandoPersona->bindParam(4, $dateTime, PDO::PARAM_STR);
                $comandoPersona->bindParam(5, $persona["estado_civil"], PDO::PARAM_STR);
                $comandoPersona->bindParam(6, $persona["ruc"], PDO::PARAM_STR);
                $comandoPersona->bindParam(7, $persona["rason_social"], PDO::PARAM_STR);
                $comandoPersona->bindParam(8, $persona["cip"], PDO::PARAM_STR);
                $comandoPersona->bindParam(9, $persona["condicion"], PDO::PARAM_STR);
                $comandoPersona->bindParam(10, $persona["dni"], PDO::PARAM_STR);
                $comandoPersona->execute();
                Database::getInstance()->getDb()->commit();
                return "updated";
            }else{
                Database::getInstance()->getDb()->rollback();
                return "noexists";
            }            
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insert($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoPersona = Database::getInstance()->getDb()->prepare("INSERT INTO Persona (idDNI,idUsuario,Nombres,Apellidos,Sexo,FechaNac,EstadoCivil,RUC,RAZONSOCIAL,CIP,Condicion)
                VALUES (?,'-1',?,?,?,?,?,?,?,?,?)");

            $dateTime = date('Y-d-m H:i:s', strtotime($persona["nacimiento"]));

            $comandoPersona->bindParam(1, $persona["dni"], PDO::PARAM_STR);
            $comandoPersona->bindParam(2, strtoupper($persona["nombres"]), PDO::PARAM_STR);
            $comandoPersona->bindParam(3, strtoupper($persona["apellidos"]), PDO::PARAM_STR);
            $comandoPersona->bindParam(4, $persona["sexo"], PDO::PARAM_STR);
            $comandoPersona->bindParam(5, $dateTime, PDO::PARAM_STR);
            $comandoPersona->bindParam(6, $persona["estado_civil"], PDO::PARAM_STR);
            $comandoPersona->bindParam(7, $persona["ruc"], PDO::PARAM_STR);
            $comandoPersona->bindParam(8, $persona["rason_social"], PDO::PARAM_STR);
            $comandoPersona->bindParam(9, $persona["cip"], PDO::PARAM_STR);
            $comandoPersona->bindParam(10, $persona["condicion"], PDO::PARAM_STR);

            $comandoPersona->execute();
            Database::getInstance()->getDb()->commit();
            return "create";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function delete()
    {
    }
}
