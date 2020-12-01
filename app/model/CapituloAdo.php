<?php

require_once __DIR__.'./../database/DataBaseConexion.php';

class CapituloAdo {

    public function construct()
    {
    }

    public static function getAllEspecialidades($nombres, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayEspecialidades = array();
            $comandoEspecialidades = Database::getInstance()->getDb()->prepare("SELECT * FROM Especialidad 
            where Capitulo like concat(?,'%') or Especialidad like concat(?,'%')
            order by Capitulo asc
            offset ? rows fetch next ? rows only");
            $comandoEspecialidades->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoEspecialidades->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoEspecialidades->bindParam(3, $posicionPagina, PDO::PARAM_INT);
            $comandoEspecialidades->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
            $comandoEspecialidades->execute();
            $count = 0;
            while ($row = $comandoEspecialidades->fetch()) {
                $count++;
                array_push($arrayEspecialidades, array(
                    "Id" => $count + $posicionPagina,
                    "idEspecialidad" => $row["idEspecialidad"],
                    "Capitulo" => $row["Capitulo"],
                    "Especialidad" => $row["Especialidad"]
                    
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM Especialidad 
            where Capitulo like concat(?,'%') or Especialidad like concat(?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayEspecialidades, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllDistinctCapitulos(){
        try{
            $comandoCapitulo = Database::getInstance()->getDb()->prepare("SELECT DISTINCT Capitulo from Especialidad");

            $comandoCapitulo->execute();
            $resultado = $comandoCapitulo->fetchAll();
            return $resultado;
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getAllDistinctEspecialidades(){
        try{ 
            $comandoEspecialidad = Database::getInstance()->getDb()->prepare("SELECT DISTINCT Especialidad from Especialidad");
            $comandoEspecialidad->execute();
            $resultado = $comandoEspecialidad->fetchAll();
            return $resultado;
        }
        catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getAllCountCapAndEsp(){
        try {
            $comandoEsp = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Especialidad");
            $comandoCap = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Capitulo");
            $comandoEsp->execute();
            $comandoCap->execute();

            $resulCountCapAndEsp = [
                "Especialidad" => $comandoEsp->fetchColumn(),
                "Capitulo" => $comandoCap->fetchColumn()
            ];
            return $resulCountCapAndEsp;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
