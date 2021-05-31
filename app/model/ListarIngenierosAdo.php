<?php

require_once __DIR__ . './../database/DataBaseConexion.php';

class ListarIngenierosAdo
{

    public static function allIngenieros($data)
    {
        try {

            if ($data['opcion'] == 1) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT p.idDNI, p.CIP, p.Apellidos, p.Nombres, p.Condicion AS idCondicion,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE' 
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO' 
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                c.FechaColegiado,
                ca.Capitulo,
                e.Especialidad  
                from Persona AS p
                INNER JOIN Colegiatura AS c ON c.Principal = 1 AND P.idDNI = C.idDNI
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                -- ORDER BY p.idDNI DESC
                -- offset 10 ROWS FETCH NEXT 10 ROWS only
                ");
                $cmdSelect->execute();
            } else if ($data['opcion'] == 2) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT p.idDNI, p.CIP, p.Apellidos, p.Nombres, p.Condicion AS idCondicion,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE'  
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO'  
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                c.FechaColegiado,
                ca.Capitulo,
                e.Especialidad  
                FROM Persona AS p
                inner join Colegiatura as c on c.Principal = 1 AND P.idDNI = C.idDNI
                inner join Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                inner join Capitulo as ca on ca.idCapitulo = e.idCapitulo
                WHERE p.Condicion = UPPER(?)");
                $cmdSelect->bindParam(1, $data['condicion'], PDO::PARAM_STR);
                $cmdSelect->execute();
            } else if ($data['opcion'] == 3) {
                $cmdSelect = Database::getInstance()->getDb()->prepare("SELECT p.idDNI, p.CIP, p.Apellidos, p.Nombres, p.Condicion AS idCondicion,
                CASE 
                WHEN p.Condicion = 'T' THEN 'TRANSEUNTE'  
                WHEN p.Condicion = 'O' THEN 'ORDINARIO'  
                WHEN p.Condicion = 'V' THEN 'VITALICIO'  
                WHEN p.Condicion = 'R' THEN 'RETIRADO'  
                WHEN p.Condicion = 'F' THEN 'FALLECIDO'
                ELSE 'ORDINARIO' END AS Condicion,
                c.FechaColegiado,
                ca.Capitulo,
                e.Especialidad  
                FROM Persona AS p
                inner join Colegiatura as c on c.Principal = 1 AND P.idDNI = C.idDNI
                inner join Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                inner join Capitulo as ca on ca.idCapitulo = e.idCapitulo
                WHERE p.Condicion = UPPER(?) AND (c.FechaColegiado BETWEEN ? AND ?)");
                $cmdSelect->bindParam(1,  $data['condicion'], PDO::PARAM_STR);
                $cmdSelect->bindParam(2,  $data['fiColegiado'], PDO::PARAM_STR);
                $cmdSelect->bindParam(3,  $data['ffColegiado'], PDO::PARAM_STR);
                $cmdSelect->execute();
            }

            $arrayIngenieros = array();
            $count = 0;
            while ($row = $cmdSelect->fetch()) {
                $count++;
                array_push($arrayIngenieros, array(
                    'Id' => $count,
                    'idDNI' => $row['idDNI'],
                    'CIP' => $row['CIP'],
                    'Apellidos' => $row['Apellidos'],
                    'Nombres' => $row['Nombres'],
                    'Condicion' => $row['Condicion'],
                    'FechaColegiado' => $row['FechaColegiado'],
                    'Capitulo' => $row['Capitulo'],
                    'Especialidad' => $row['Especialidad']
                ));
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
