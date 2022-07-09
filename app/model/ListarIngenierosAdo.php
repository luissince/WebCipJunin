<?php

namespace SysSoftIntegra\Model;

use PDO;
use SysSoftIntegra\DataBase\Database;
use Exception;

class ListarIngenierosAdo
{

    public static function allIngenieros($data)
    {
        try {

            if ($data['opcion'] == 1) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT 
                p.NumDoc as idDNI, 
                p.CIP, 
                p.Apellidos, 
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE' 
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO' 
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
                ca.Capitulo,
                e.Especialidad  
                FROM Persona AS p
                INNER JOIN Colegiatura AS c ON c.Principal = 1 AND p.idDNI = c.idDNI				
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                -- ORDER BY p.idDNI DESC
                -- offset 10 ROWS FETCH NEXT 10 ROWS only
                ");
                $cmdSelect->execute();
            } else if ($data['opcion'] == 2) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT 
                p.NumDoc as idDNI, 
                p.CIP, p.Apellidos, 
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE'  
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO'  
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
                ca.Capitulo,
                e.Especialidad  
                FROM Persona AS p
                inner join Colegiatura as c on c.Principal = 1 AND p.idDNI = c.idDNI
                inner join Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                inner join Capitulo as ca on ca.idCapitulo = e.idCapitulo
                WHERE p.Condicion = UPPER(?)");
                $cmdSelect->bindParam(1, $data['condicion'], PDO::PARAM_STR);
                $cmdSelect->execute();
            } else if ($data['opcion'] == 3) {
                if ($data['condicion'] == "1") {
                    $condicion =  25;
                } else if ($data['condicion'] == "2") {
                    $condicion =  30;
                } else {
                    $condicion =  50;
                }

                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT 
                p.NumDoc as idDNI,
                p.CIP,
                p.Apellidos, 
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,         
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE'  
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO'  
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
                CONVERT(VARCHAR,CAST(CONVERT(date,dateadd(month,c.MesAumento,dateadd(year, $condicion,c.FechaColegiado))) AS DATE), 103) AS Cumple,
                ca.Capitulo,
                e.Especialidad  
                FROM Persona AS p
                inner join Colegiatura as c on c.Principal = 1 AND p.idDNI = c.idDNI
                inner join Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                inner join Capitulo as ca on ca.idCapitulo = e.idCapitulo
                WHERE year(convert(date,dateadd(month,c.MesAumento,dateadd(year,?,c.FechaColegiado)))) = ?
                ORDER BY CONVERT(date,dateadd(month,c.MesAumento,dateadd(year, $condicion,c.FechaColegiado))) ASC");
                $cmdSelect->bindParam(1,  $condicion, PDO::PARAM_INT);
                $cmdSelect->bindParam(2,  $data['fiColegiado'], PDO::PARAM_STR);
                $cmdSelect->execute();
            } else  if ($data['opcion'] == 4) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT 
                p.NumDoc as idDNI,
                p.CIP,
                p.Apellidos, 
                p.Nombres,        
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,    
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE'  
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO'  
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
                CONVERT(VARCHAR,CAST(CONVERT(date,dateadd(month,c.MesAumento,dateadd(year, 30,c.FechaColegiado))) AS DATE), 103) AS Cumple,
                ca.Capitulo,
                e.Especialidad,
                c.MesAumento
                FROM Persona AS p
                inner join Colegiatura as c on c.Principal = 1 AND p.idDNI = c.idDNI
                inner join Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                inner join Capitulo as ca on ca.idCapitulo = e.idCapitulo
                 where Resolucion15 <> 0 and Principal = 1");
                $cmdSelect->execute();
            } else if ($data['opcion'] == 5) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT 
                p.NumDoc as idDNI, 
                p.CIP, 
                p.Apellidos, 
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE' 
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO' 
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
				CONVERT(VARCHAR,CAST(P.FechaReg AS DATE), 103) AS FechaRegistro,
                ca.Capitulo,
                e.Especialidad  
                from Persona AS p
                INNER JOIN Colegiatura AS c ON c.Principal = 1 AND p.idDNI = c.idDNI
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
				where FechaReg between ? and ? ");
                $cmdSelect->bindParam(1,  $data['fiColegiado'], PDO::PARAM_STR);
                $cmdSelect->bindParam(2,  $data['ffColegiado'], PDO::PARAM_STR);
                $cmdSelect->execute();
            }

            $arrayIngenieros = array();
            while ($row = $cmdSelect->fetch(PDO::FETCH_ASSOC)) {
                array_push($arrayIngenieros, $row);
            }
            return $arrayIngenieros;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function IngenierosNombres($search)
    {
        try {
            $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT idDNI, CONCAT(Apellidos,', ',Nombres) AS Ingeniero 
            FROM Persona 
            WHERE 
            ? = ''
            OR
            CIP LIKE ? 
            OR
            idDNI LIKE ?
            OR
            Apellidos LIKE ?
            OR
            Nombres LIKE ?");
            $cmdSelect->bindParam(1, $search, PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $search, PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $search, PDO::PARAM_STR);
            $cmdSelect->bindParam(4, $search, PDO::PARAM_STR);
            $cmdSelect->bindParam(5, $search, PDO::PARAM_STR);
            $cmdSelect->execute();

            $arrayIngenieros = array();
            $count = 0;
            while ($row = $cmdSelect->fetch()) {
                $count++;
                array_push($arrayIngenieros, array(
                    'id' => $row['idDNI'],
                    'text' => $row['Ingeniero']
                ));
            }
            return $arrayIngenieros;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
