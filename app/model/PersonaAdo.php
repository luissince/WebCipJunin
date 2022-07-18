<?php

namespace SysSoftIntegra\Model;

use PDO;
use PDOException;
use Exception;
use DateTime;
use PHPMailer\PHPMailer\PHPMailer;
use SysSoftIntegra\DataBase\Database;
use SysSoftIntegra\Src\Response;

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
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.Sexo,
            p.EstadoCivil,
            p.RUC,
            p.CIP,
            p.Condicion,
            CONVERT(VARCHAR,CAST(p.FechaReg AS DATE),103) AS FechaReg,
            ISNULL(ca.Capitulo,'SIN CAPITULO') AS Capitulo,
            ISNULL(e.Especialidad,'SIN ESPECIALIDAD') AS Especialidad
            FROM Persona AS p 
            LEFT JOIN Colegiatura as c on c.idDNI = p.idDNI and c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            WHERE
            p.NumDoc = ?
            OR
            p.CIP = ?
            OR
            p.Nombres LIKE concat(?,'%') 
            OR 
            p.Apellidos LIKE concat(?,'%')
            ORDER BY CAST(p.FechaReg AS DATE) DESC
            offset ? rows fetch next ? rows only");
            $comandoPersona->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(3, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(4, $nombres, PDO::PARAM_STR);
            $comandoPersona->bindParam(5, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(6, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    'Id' => $count + $posicionPagina,
                    'idDNI' => $row['idDNI'],
                    'NumDoc' => $row['NumDoc'],
                    'Nombres' => $row['Nombres'],
                    'Apellidos' => $row['Apellidos'],
                    'Sexo' => $row["Sexo"] == 'M' ? "MASCULINO" : "FEMENINO",
                    'EstadoCivil' => $row['EstadoCivil'],
                    'Ruc' => $row['RUC'],
                    'Cip' => $row['CIP'],
                    'Condicion' => $row['Condicion'],
                    'FechaReg' => $row['FechaReg'],
                    "Capitulo" => $row["Capitulo"],
                    "Especialidad" => $row["Especialidad"],
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(p.idDNI)
            FROM Persona AS p 
            LEFT JOIN Colegiatura as c on c.idDNI = p.idDNI and c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            WHERE 
            p.NumDoc = ?
            OR
            p.CIP = ?
            OR
            p.Nombres LIKE concat(?,'%') 
            OR
            p.Apellidos LIKE concat(?,'%')");
            $comandoTotal->bindParam(1, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(2, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $nombres, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $nombres, PDO::PARAM_STR);
            $comandoTotal->execute();
            $resultTotal =  $comandoTotal->fetchColumn();

            array_push($array, $arrayPersonas, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAllModal($search, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.CIP AS Cip, 
            p.idDNI as Dni, 
            p.NumDoc, 
            p.Apellidos + ', ' + p.Nombres AS Ingeniero, 
            CASE p.Condicion
            WHEN 'T' THEN 'Transeunte'
            WHEN 'F' THEN 'Fallecido'
            WHEN 'R' THEN 'Retirado'
            WHEN 'V' THEN 'Vitalicio'
            ELSE 'Ordinario' END AS Condicion,
			ISNULL(e.Especialidad,'SIN ESPECIALIDAD') AS Especialidad,
			ISNULL(ca.Capitulo,'SIN CAPITULO') AS Capitulo,
            CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
            CONVERT(VARCHAR,CAST(ISNULL(ul.FechaUltimaCuota,c.FechaColegiado) AS DATE), 103) AS FechaUltimaCuota, 
            DATEDIFF(M, ISNULL(ul.FechaUltimaCuota, c.FechaColegiado), GETDATE()) AS Deuda,
			CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
            ELSE 'No Habilitado' END AS Habilidad
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo 
			LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE  
            p.NumDoc = ?
            OR 
            p.CIP = ? 
            OR 
            p.Apellidos LIKE CONCAT(?,'%')
            OR 
            p.Nombres LIKE CONCAT(?,'%')
            ORDER BY p.FechaReg ASC
            OFFSET ? ROWS FETCH NEXT ? ROWS only");
            $comandoPersona->bindParam(1, $search, PDO::PARAM_INT);
            $comandoPersona->bindParam(2, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(3, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(4, $search, PDO::PARAM_STR);
            $comandoPersona->bindParam(5, $posicionPagina, PDO::PARAM_INT);
            $comandoPersona->bindParam(6, $filasPorPagina, PDO::PARAM_INT);
            $comandoPersona->execute();
            $count = 0;
            while ($row = $comandoPersona->fetch()) {
                $count++;
                array_push($arrayPersonas, array(
                    'Id' => $count + $posicionPagina,
                    'Cip' => $row['Cip'],
                    'Dni' => $row['Dni'],
                    'NumDoc' => $row['NumDoc'],
                    'Ingeniero' => $row['Ingeniero'],
                    'FechaColegiado' => $row['FechaColegiado'],
                    'Condicion' => $row['Condicion'],
                    'FechaUltimaCuota' => $row['FechaUltimaCuota'],
                    'Deuda' => $row['Deuda'],
                    'Habilidad' => $row['Habilidad']
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(p.idDNI)
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo 
			LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE 
            p.idDNI = ? 
            OR
            p.CIP = ? 
            OR 
            p.Apellidos like concat(?,'%')
            OR 
            p.Nombres like concat(?,'%')");
            $comandoTotal->bindParam(1, $search, PDO::PARAM_INT);
            $comandoTotal->bindParam(2, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(3, $search, PDO::PARAM_STR);
            $comandoTotal->bindParam(4, $search, PDO::PARAM_STR);
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
            $array = array();
            //trae informacion del usuario (por su dni)
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.NumDoc,
            p.idUsuario,
            p.Nombres, 
            p.Apellidos, 
            p.Sexo, 
            cast(p.FechaNac as date) as FechaNacimiento, 
            p.EstadoCivil, 
            p.FechaReg, 
            p.RUC, 
            p.CIP, 
            p.Condicion, 
            p.TEMP, 
            p.RAZONSOCIAL
            FROM Persona AS p  WHERE p.idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();
            //trae la imagen del usuario
            $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
            idDNI,Foto
            FROM PersonaImagen WHERE idDNI = ?");
            $cmdImage->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdImage->execute();
            $image = null;

            if ($row = $cmdImage->fetch()) {
                $image = (object)array($row['idDNI'], base64_encode($row['Foto']));
            }

            array_push($array, $object, $image);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIdCip($cip)
    {
        try {
            $array = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.NumDoc,
            p.Nombres, 
            p.Apellidos, 
            p.CIP, 
            CASE p.Condicion
            WHEN 'T' THEN 'Transeunte'
            WHEN 'F' THEN 'Fallecido'
            WHEN 'R' THEN 'Retirado'
            WHEN 'V' THEN 'Vitalicio'
            ELSE 'Ordinario' END AS Condicion, 
            CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
            ELSE 'No Habilitado' END AS Habilidad
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE p.CIP = ?");
            $comandoPersona->bindParam(1, $cip, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();
            if ($object) {
                $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
                idDNI,Foto
                FROM PersonaImagen WHERE idDNI = ?");
                $cmdImage->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdImage->execute();
                $image = null;

                if ($row = $cmdImage->fetch()) {
                    $image = (object)array($row['idDNI'], base64_encode($row['Foto']));
                }

                $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT 
                ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo, 
                UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
                convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
                c.Principal 
                FROM Colegiatura  AS c
                LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                WHERE idDNI = ?
                ORDER BY c.FechaColegiado ASC");
                $cmdColegiatura->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdColegiatura->execute();

                $arrayColegiaturas = $cmdColegiatura->fetchAll(PDO::FETCH_OBJ);

                array_push($array, $object, $image, $arrayColegiaturas);
                return $array;
            } else {
                return "NO EXISTE un colegiado con los datos ingresados";
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getIdEstado($cip)
    {
        try {
            //trae informacion del usuario (por su dni)
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 1
            ELSE 2 END AS Habilidad
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE p.CIP = ?");
            $comandoPersona->bindParam(1, $cip, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchColumn();
            if ($object) {
                return $object;
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return 0;
        }
    }

    public static function getIdCobros($idPersona)
    {
        try {
            $array = array();
            //trae informacion del usuario (por su dni)
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.NumDoc,
            p.idUsuario,
            p.Nombres, 
            p.Apellidos, 
            p.Sexo, 
            cast(p.FechaNac as date) as FechaNacimiento, 
            p.EstadoCivil, 
            p.FechaReg, 
            p.RUC, 
            p.CIP, 
            p.Condicion, 
            p.TEMP, 
            p.RAZONSOCIAL
            FROM Persona AS p  WHERE p.idDNI = ?");
            $comandoPersona->bindParam(1, $idPersona, PDO::PARAM_STR);
            $comandoPersona->execute();
            $object = $comandoPersona->fetchObject();

            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT        
            CAST(c.FechaColegiado AS DATE) as FechaColegiado,
            CAST(ISNULL(uc.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS UltimaCuota, 
            CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta,
			ISNULL(e.Especialidad,'SIN ESPECIALIDAD') as Especialidad, ISNULL(cp.Capitulo, 'SIN CAPITULO') as Capitulo
            FROM Persona AS p
            LEFT OUTER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS uc ON uc.idDNI = p.idDNI
			LEFT OUTER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
			LEFT OUTER JOIN Capitulo AS cp ON cp.idCapitulo = e.idCapitulo
			WHERE p.idDNI = ? ");
            $cmdColegiatura->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdColegiatura->execute();
            $resultColegiatura = null;
            if ($row = $cmdColegiatura->fetch()) {
                $dateUltimaCuota = new DateTime($row['UltimaCuota']);
                $dateHabilHasta = new DateTime($row['HabilitadoHasta']);
                $resultColegiatura = (object)array(
                    "FechaColegiado" => $row['FechaColegiado'],
                    "UltimaCuota" => $dateUltimaCuota->format("m/Y"),
                    "HabilitadoHasta" => $dateHabilHasta->format("m/Y"),
                    "Capitulo" => $row['Capitulo'],
                    "Especialidad" => $row['Especialidad']
                );
            }

            $cmdYears = Database::getInstance()->getDb()->prepare("SELECT 
            datediff(year,getdate(),dateadd(month,c.MesAumento,dateadd(year,30,c.FechaColegiado)))
			from Persona as p inner join Colegiatura as c
			on p.idDNI = c.idDNI and c.Principal = 1
            where p.idDNI = ?");
            $cmdYears->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdYears->execute();
            $resultYears =  $cmdYears->fetchColumn();

            $cmdDate = Database::getInstance()->getDb()->prepare("SELECT 
            dateadd(month,c.MesAumento,dateadd(year,30,c.FechaColegiado))
			from Persona as p inner join Colegiatura as c
			on p.idDNI = c.idDNI and c.Principal = 1
            where p.idDNI = ?");
            $cmdDate->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdDate->execute();
            $resultDate =  $cmdDate->fetchColumn();

            $cmdAfiliaciones = Database::getInstance()->getDb()->prepare("SELECT a.idAfiliacion, a.Descripcion, a.Monto, a.Fecha, a.Hora, CONCAT(u.Nombres,', ', u.Apellidos) AS Usuario, r.Nombre, a.Estado FROM Afiliacion AS a
            INNER JOIN Usuario AS u ON u.idUsuario = a.idUsuario
            INNER JOIN Rol AS r ON r.idRol = u.Rol
            WHERE idDNI = ?");
            $cmdAfiliaciones->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdAfiliaciones->execute();

            $count = 0;
            $arrayAfiliaciones = array();
            while ($row = $cmdAfiliaciones->fetch()) {
                $count++;
                array_push($arrayAfiliaciones, array(
                    "Id" => $count,
                    "idAfiliacion" => $row["idAfiliacion"],
                    "Descripcion" => $row["Descripcion"],
                    "Monto" => $row["Monto"],
                    "Fecha" => $row["Fecha"],
                    "Usuario" => $row["Usuario"],
                    "Nombre" => $row["Nombre"],
                    "Estado" => $row["Estado"],
                ));
            }

            array_push($array, $object, $resultColegiatura, $resultYears, $resultDate, $arrayAfiliaciones);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getDataAfiliacion($idPersona)
    {
        try {
            //trae informacion del usuario (por su dni)            
            $cmdAfiliaciones = Database::getInstance()->getDb()->prepare("SELECT a.idAfiliacion, a.Descripcion, a.Monto, a.Fecha, a.Hora, CONCAT(u.Nombres,', ', u.Apellidos) AS Usuario, r.Nombre, a.Estado FROM Afiliacion AS a
            INNER JOIN Usuario AS u ON u.idUsuario = a.idUsuario
            INNER JOIN Rol AS r ON r.idRol = u.Rol
            WHERE idDNI = ?");
            $cmdAfiliaciones->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdAfiliaciones->execute();

            $count = 0;
            $arrayAfiliaciones = array();
            while ($row = $cmdAfiliaciones->fetch()) {
                $count++;
                array_push($arrayAfiliaciones, array(
                    "Id" => $count,
                    "idAfiliacion" => $row["idAfiliacion"],
                    "Descripcion" => $row["Descripcion"],
                    "Monto" => $row["Monto"],
                    "Fecha" => $row["Fecha"],
                    "Usuario" => $row["Usuario"],
                    "Nombre" => $row["Nombre"],
                    "Estado" => $row["Estado"],
                ));
            }
            return $arrayAfiliaciones;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function reporteColegiado($idDni)
    {
        try {
            $cmdPersona = Database::getInstance()->getDb()->prepare("SELECT 
            NumDoc,
            Nombres,
            Apellidos,
            CIP,
            FechaNac,
            CASE Sexo
            WHEN 'M' THEN 'MASCULINO'
            ELSE 'FEMENINO' END AS Sexo,
            CASE condicion
            WHEN 'V' THEN 'VITALICIO'
            WHEN 'F' THEN 'FALLECIDO'
            WHEN 'R' THEN 'RETIRADO'
            WHEN 'T' THEN 'TRANSEUNTE'
            ELSE 'ORDINARIO' END AS condicion
            FROM Persona WHERE idDNI = ?");
            $cmdPersona->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdPersona->execute();

            $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
            idDNI,Foto
            FROM PersonaImagen WHERE idDNI = ?");
            $cmdImage->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdImage->execute();
            $image = null;

            if ($row = $cmdImage->fetch()) {
                $image = base64_encode($row['Foto']);
            }

            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado, 
            s.idConsejo, 
            s.Consejo, 
            ca.idCapitulo ,
            ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo, 
            e.idEspecialidad ,
            UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
            convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
            c.idUnivesidadEgreso AS idUnivEgreso,
            ISNULL(ue.Universidad,'UNIVERSIDAD NO REGISTRADA') AS UnivesidadEgreso, 
            convert(VARCHAR,cast(c.FechaEgreso AS DATE),103) AS FechaEgreso, 
            u.idUniversidad, 
            ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            Convert(VARCHAR,cast(c.FechaTitulacion AS DATE),103) AS FechaTitulacion, 
            c.Resolucion, 
            c.Principal 
            FROM Colegiatura  AS c
            LEFT JOIN Sede AS s ON s.idConsejo = c.idSede
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
			LEFT JOIN Universidad as ue ON ue.idUniversidad = c.idUnivesidadEgreso 
            LEFT JOIN Universidad AS u ON u.idUniversidad = c.idUniversidad where idDNI = ?");
            $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdColegiatura->execute();

            $cmdHistorial = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso, 
            i.idDNI, 
            CONCAT(i.Serie,' - ', i.NumRecibo) AS Recibo, 
            i.Fecha, 
            i.Hora,
            CASE 
            WHEN NOT idCuota IS NULL THEN RIGHT(CONVERT(VARCHAR(10), cu.FechaIni, 103), 7) + ' a ' + RIGHT(CONVERT(VARCHAR(10), cu.FechaFin, 103), 7) 
            ELSE i.Observacion END AS Observacion, vit.Total,
            CASE 
            WHEN NOT idCuota IS NULL THEN 'Cuota Ordinaria'
            WHEN NOT idAltaColegio IS NULL THEN 'Colegiatura'
            WHEN NOT idHabilidad IS NULL THEN  'Certificado de habilidad'
            WHEN NOT idResidencia IS NULL THEN 'Cuota de residencia de obra' 
            WHEN NOT idProyecto IS NULL THEN 'Certificado de proyecto' 
            WHEN NOT idPeritaje IS NULL THEN 'Peritaje' 
            ELSE 'Ingresos Diversos' END AS TipoIngreso,
            ISNULL(ch.Numero, '-') AS NmroCertHabilidad
            FROM Ingreso AS i             
            INNER JOIN vINGRESOTotal AS vit ON vit.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Cuota AS cu ON cu.idIngreso = i.idIngreso 
            LEFT OUTER JOIN AltaColegio AS ac ON ac.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTHabilidad AS ch ON ch.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTResidencia AS cr ON cr.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTProyecto AS cp ON cp.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Peritaje AS pe ON pe.idIngreso = i.idIngreso
            LEFT OUTER JOIN NotaCredito AS nc ON nc.idIngreso = i.idIngreso AND nc.Estado = 'C'
            WHERE i.Estado = 'C' AND nc.idNotaCredito IS NULL AND idDNI = ?
            ORDER BY i.Fecha DESC,i.Hora DESC");
            $cmdHistorial->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdHistorial->execute();

            return array($cmdPersona->fetchObject(), $image, $cmdColegiatura->fetchAll(PDO::FETCH_OBJ), $cmdHistorial->fetchAll(PDO::FETCH_OBJ));
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getHistorialPagos($idPersona, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();

            $cmdHistorial = Database::getInstance()->getDb()->prepare("SELECT 
            i.idIngreso, 
            i.idDNI, 
            CONCAT(i.Serie,' - ', i.NumRecibo) AS Recibo, 
            i.Fecha, 
            i.Hora,
            CASE 
            WHEN NOT idCuota IS NULL THEN RIGHT(CONVERT(VARCHAR(10), cu.FechaIni, 103), 7) + ' a ' + RIGHT(CONVERT(VARCHAR(10), cu.FechaFin, 103), 7) 
            ELSE i.Observacion END AS Observacion, vit.Total,
            CASE 
            WHEN NOT idCuota IS NULL THEN 1
            WHEN NOT idAltaColegio IS NULL THEN 4 
            WHEN NOT idHabilidad IS NULL THEN  5
            WHEN NOT idResidencia IS NULL THEN 6 
            WHEN NOT idProyecto IS NULL THEN 7 
            WHEN NOT idPeritaje IS NULL THEN 8 
            ELSE 100 END AS TipoIngreso, ISNULL(ch.Numero, '-') AS NmroCertHabilidad
            FROM Ingreso AS i 
            INNER JOIN vINGRESOTotal AS vit ON vit.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Cuota AS cu ON cu.idIngreso = i.idIngreso 
            LEFT OUTER JOIN AltaColegio AS ac ON ac.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTHabilidad AS ch ON ch.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTResidencia AS cr ON cr.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTProyecto AS cp ON cp.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Peritaje AS pe ON pe.idIngreso = i.idIngreso
            LEFT OUTER JOIN NotaCredito AS nc ON nc.idIngreso = i.idIngreso AND nc.Estado = 'C'
            WHERE i.Estado = 'C' AND nc.idNotaCredito IS NULL AND idDNI = ?
            ORDER BY i.Fecha DESC,i.Hora DESC
            offset ? ROWS FETCH NEXT ? ROWS only");
            $cmdHistorial->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdHistorial->bindParam(2, $posicionPagina, PDO::PARAM_INT);
            $cmdHistorial->bindParam(3, $filasPorPagina, PDO::PARAM_INT);
            $cmdHistorial->execute();
            $count = 0;
            $arrayHistorial = array();
            while ($row = $cmdHistorial->fetch()) {
                $count++;
                array_push($arrayHistorial, array(
                    "Id" => $count + $posicionPagina,
                    "IdIngreso" => $row["idIngreso"],
                    "Recibo" => $row["Recibo"],
                    "Fecha" => $row["Fecha"],
                    "Hora" => $row["Hora"],
                    "nroCertHabilidad" => $row["NmroCertHabilidad"],
                    "Concepto" => $row["TipoIngreso"],
                    "Monto" => number_format($row["Total"], 2, ".", ""),
                    "Observacion" => $row["Observacion"],
                ));
            }

            $cmdTotales = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(i.idIngreso)
            FROM Ingreso AS i 
            INNER JOIN vINGRESOTotal AS vit ON vit.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Cuota AS cu ON cu.idIngreso = i.idIngreso 
            LEFT OUTER JOIN AltaColegio AS ac ON ac.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTHabilidad AS ch ON ch.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTResidencia AS cr ON cr.idIngreso = i.idIngreso 
            LEFT OUTER JOIN CERTProyecto AS cp ON cp.idIngreso = i.idIngreso 
            LEFT OUTER JOIN Peritaje AS pe ON pe.idIngreso = i.idIngreso
            LEFT OUTER JOIN NotaCredito AS nc ON nc.idIngreso = i.idIngreso AND nc.Estado = 'C'
            WHERE i.Estado = 'C' AND nc.idNotaCredito IS NULL AND idDNI = ?");
            $cmdTotales->bindParam(1, $idPersona, PDO::PARAM_STR);
            $cmdTotales->execute();
            $resultTotal = $cmdTotales->fetchColumn();

            array_push($array,  $arrayHistorial, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function update($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE idDNI = ?");
            $comandoValidate->bindParam(1, $persona['dni'], PDO::PARAM_STR);
            $comandoValidate->execute();
            if ($comandoValidate->fetch()) {
                $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE idDNI <> ? AND NumDoc = ?  ");
                $comandoValidate->bindParam(1, $persona['dni'], PDO::PARAM_STR);
                $comandoValidate->bindParam(2, $persona['num_duc'], PDO::PARAM_STR);
                $comandoValidate->execute();
                if ($comandoValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return 'num_duc';
                } else {
                    $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE idDNI <> ? AND CIP = ? AND CIP <> '' ");
                    $comandoValidate->bindParam(1, $persona['dni'], PDO::PARAM_STR);
                    $comandoValidate->bindParam(2, $persona['cip'], PDO::PARAM_STR);
                    $comandoValidate->execute();
                    if ($comandoValidate->fetch()) {
                        Database::getInstance()->getDb()->rollback();
                        return 'cip';
                    } else {
                        $comandoPersona = Database::getInstance()->getDb()->prepare("UPDATE Persona SET 
                        NumDoc = ?,
                        Nombres = UPPER(?),
                        Apellidos = UPPER(?),
                        Sexo = ?,
                        FechaNac = ?,
                        EstadoCivil = ?,
                        RUC = ?,
                        RAZONSOCIAL = ?,
                        CIP = ?,
                        Condicion = ?,
                        idUsuario = ?,
                        FechaMo = GETDATE(),
                        HoraMo = GETDATE()
                        WHERE idDNI = ?");

                        $comandoPersona->bindParam(1, $persona['num_duc'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(2, $persona['nombres'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(3, $persona['apellidos'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(4, $persona['sexo'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(5, $persona['nacimiento'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(6, $persona['estado_civil'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(7, $persona['ruc'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(8, $persona['rason_social'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(9, $persona['cip'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(10, $persona['condicion'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(11, $persona['idUsuario'], PDO::PARAM_STR);
                        $comandoPersona->bindParam(12, $persona['dni'], PDO::PARAM_STR);
                        $comandoPersona->execute();

                        Database::getInstance()->getDb()->commit();
                        return 'updated';
                    }
                }
            } else {
                Database::getInstance()->getDb()->rollback();
                return 'noexists';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateImage($body)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $image = $body['image'] == null ? null : base64_decode($body['image']);

            $cmdDelete = Database::getInstance()->getDb()->prepare('DELETE FROM PersonaImagen WHERE idDNI = ?');
            $cmdDelete->bindParam(1, $body['dni'], PDO::PARAM_STR);
            $cmdDelete->execute();

            $cmdImage = Database::getInstance()->getDb()->prepare('INSERT INTO PersonaImagen(idDNI,Foto)VALUES(?,?)');
            $cmdImage->bindParam(1, $body['dni'], PDO::PARAM_STR);
            $cmdImage->bindParam(2, $image,  PDO::PARAM_LOB, 0, PDO::SQLSRV_ENCODING_BINARY);
            $cmdImage->execute();

            Database::getInstance()->getDb()->commit();
            return 'updated';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insert($persona)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE NumDoc = ?");
            $comandoValidate->bindParam(1, $persona['num_duc'], PDO::PARAM_STR);
            $comandoValidate->execute();
            if ($comandoValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "num_duc";
            } else {
                $comandoValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE CIP = ? AND CIP <> ''");
                $comandoValidate->bindParam(1, $persona['cip'], PDO::PARAM_STR);
                $comandoValidate->execute();
                if ($comandoValidate->fetch()) {
                    Database::getInstance()->getDb()->rollback();
                    return "cip";
                } else {

                    $codigoPersona = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Persona_Codigo_Alfanumerico();");
                    $codigoPersona->execute();
                    $idGeneradoCli = $codigoPersona->fetchColumn();

                    $comandoPersona = Database::getInstance()->getDb()->prepare("INSERT INTO Persona (
                        idDNI,
                        NumDoc,
                        idUsuario,
                        Nombres,
                        Apellidos,
                        Sexo,
                        FechaNac,
                        EstadoCivil,
                        RUC,
                        RAZONSOCIAL,
                        CIP,
                        Condicion,
                        FechaMo,
                        HoraMo)
                        VALUES (?,?,?,UPPER(?),UPPER(?),?,?,?,?,?,?,?,GETDATE(),GETDATE())");

                    $comandoPersona->bindParam(1, $idGeneradoCli, PDO::PARAM_STR);
                    $comandoPersona->bindParam(2, $persona['num_duc'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(3, $persona['idUsuario'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(4, $persona['nombres'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(5, $persona['apellidos'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(6, $persona['sexo'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(7, $persona['nacimiento'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(8, $persona['estado_civil'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(9, $persona['ruc'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(10, $persona['rason_social'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(11, $persona['cip'], PDO::PARAM_STR);
                    $comandoPersona->bindParam(12, $persona['condicion'], PDO::PARAM_STR);

                    $comandoPersona->execute();
                    Database::getInstance()->getDb()->commit();
                    return 'create';
                }
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }


    public static function getColegiatura($idDni)
    {
        try {
            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado, 
            s.idConsejo, 
            s.Consejo, 
            ca.idCapitulo ,
            ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo, 
            e.idEspecialidad ,
            UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
            convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
            c.idUnivesidadEgreso AS idUnivEgreso,
            ISNULL(ue.Universidad,'UNIVERSIDAD NO REGISTRADA') AS UnivesidadEgreso, 
            convert(VARCHAR,cast(c.FechaEgreso AS DATE),103) AS FechaEgreso, 
            u.idUniversidad, 
            ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            Convert(VARCHAR,cast(c.FechaTitulacion AS DATE),103) AS FechaTitulacion, 
            c.Resolucion, 
            c.Principal 
            FROM Colegiatura  AS c
            LEFT JOIN Sede AS s ON s.idConsejo = c.idSede
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
			LEFT JOIN Universidad as ue ON ue.idUniversidad = c.idUnivesidadEgreso 
            LEFT JOIN Universidad AS u ON u.idUniversidad = c.idUniversidad where idDNI = ?");
            $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdColegiatura->execute();

            $arrayColegiaturas = array();

            $count = 0;
            while ($row = $cmdColegiatura->fetch()) {
                $count++;
                array_push($arrayColegiaturas, array(
                    'Id' => $count,
                    'IdColegiatura' => $row['idColegiado'],
                    'IdSede' => $row['idConsejo'],
                    'sede' => $row['Consejo'],
                    'IdCapitulo' => $row['idCapitulo'],
                    'capitulo' => $row['Capitulo'],
                    'IdEspecialidad' => $row['idEspecialidad'],
                    'especialidad' => $row['Especialidad'],
                    'fechaColegiado' => $row['FechaColegiado'],
                    'IdUnivEgreso' => $row['idUnivEgreso'],
                    'universidadEgreso' => $row['UnivesidadEgreso'],
                    'fechaEgreso' => $row['FechaEgreso'],
                    'IdUnivTitulacion' => $row['idUniversidad'],
                    'universidadTitulacion' => $row['Universidad'],
                    'fechaTitulacion' => $row['FechaTitulacion'],
                    'resolucion' => $row['Resolucion'],
                    'principal' => $row['Principal']
                ));
            }

            return $arrayColegiaturas;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getDomicilio($idDni)
    {
        try {
            $cmdDomicilio = Database::getInstance()->getDb()->prepare("SELECT d.idDireccion,t.idTipo, ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo,
            UPPER(d.Direccion) AS Direccion, u.IdUbigeo, CONCAT((ISNULL (u.Departamento,'DEPARTAMENTO NO REGISTRADA')),' - ',
			(ISNULL (u.Provincia,'DEPARTAMENTO NO REGISTRADA')),' - ',(ISNULL (u.Distrito,'DEPARTAMENTO NO REGISTRADA')  )) AS Ubigeo FROM Direccion AS d
            LEFT JOIN Tipos AS t ON t.idTipo = d.Tipo 
            LEFT JOIN Ubigeo AS u ON u.idUbigeo = d.Ubigeo
            WHERE d.idDNI = ?");
            $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdDomicilio->execute();

            $arrayDomicilios = array();
            $count = 0;
            while ($row = $cmdDomicilio->fetch()) {
                $count++;
                array_push($arrayDomicilios, array(
                    'Id' => $count,
                    'IdDireccion' => $row['idDireccion'],
                    'IdTipo' => $row['idTipo'],
                    'tipo' => $row['Tipo'],
                    'direccion' => $row['Direccion'],
                    'IdUbigeo' => $row['IdUbigeo'],
                    'ubigeo' => $row['Ubigeo']
                ));
            }
            return $arrayDomicilios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getTelefono($idDni)
    {
        try {
            $cmdTelefono = Database::getInstance()->getDb()->prepare("SELECT 
            a.idTelefono, 
            t.idTipo, 
            ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
            a.Telefono 
            FROM Telefono AS a 
            LEFT JOIN Tipos AS t ON t.idTipo = a.Tipo WHERE a.idDNI = ?");
            $cmdTelefono->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdTelefono->execute();

            $arrayTelefonos = array();

            $count = 0;
            while ($row = $cmdTelefono->fetch()) {
                $count++;
                array_push($arrayTelefonos, array(
                    'Id' => $count,
                    'IdTelefono' => $row['idTelefono'],
                    'IdTipo' => $row['idTipo'],
                    'tipo' => $row['Tipo'],
                    'numero' => $row['Telefono'],
                ));
            }
            return $arrayTelefonos;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getConyuge($idDni)
    {
        try {
            $cmdConyuge = Database::getInstance()->getDb()->prepare('SELECT 
            IdConyugue, 
            UPPER(FullName) AS NombreCompleto, 
            NumHijos 
            FROM Conyuge WHERE idDNI = ?');
            $cmdConyuge->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdConyuge->execute();

            $arrayConyuge = array();

            $count = 0;
            while ($row = $cmdConyuge->fetch()) {
                $count++;
                array_push($arrayConyuge, array(
                    'Id' => $count,
                    'IdConyuge' => $row['IdConyugue'],
                    'NombreCompleto' => $row['NombreCompleto'],
                    'Hijos' => $row['NumHijos'],
                ));
            }
            return $arrayConyuge;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getExperiencia($idDni)
    {
        try {
            $cmdExperiencia = Database::getInstance()->getDb()->prepare("SELECT 
            idExperiencia, 
            UPPER(Entidad) AS Entidad, 
            UPPER(ExpericienciaEn) AS  Experiencia,  
            CONVERT(VARCHAR,cast(FechaInicio AS DATE),103) AS FechaInicio, 
            CONVERT(VARCHAR,cast(FechaFin AS DATE),103) AS FechaFin
             FROM Experiencia WHERE idPersona = ?");
            $cmdExperiencia->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdExperiencia->execute();

            $arrayExperiencia = array();

            $count = 0;
            while ($row = $cmdExperiencia->fetch()) {
                $count++;
                array_push($arrayExperiencia, array(
                    'Id' => $count,
                    'IdExperiencia' => $row['idExperiencia'],
                    'Entidad' => $row['Entidad'],
                    'Experiencia' => $row['Experiencia'],
                    'FechaInicio' => $row['FechaInicio'],
                    'FechaFin' => $row['FechaFin'],
                ));
            }
            return $arrayExperiencia;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getGradosyEstudios($idDni)
    {
        try {
            $cmdgradosyestudios = Database::getInstance()->getDb()->prepare("SELECT 
            g.idEstudio, 
            t.idTipo, 
            UPPER(t.Descripcion) AS Grado, 
            UPPER(Materia) AS Materia, 
            u.idUniversidad, 
            ISNULL(u.Universidad, 'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            CONVERT(VARCHAR, cast(g.FechaGrado AS DATE), 103) AS Fecha 
            FROM Grados AS g 
            LEFT JOIN Universidad AS u ON u.idUniversidad = g.idUniversidad
            LEFT JOIN Tipos AS t ON t.idTipo = g.Grado AND t.Categoria = 'D'
            WHERE g.idDNI = ?");
            $cmdgradosyestudios->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdgradosyestudios->execute();

            $arraygradosyestudios = array();

            $count = 0;
            while ($row = $cmdgradosyestudios->fetch()) {
                $count++;
                array_push($arraygradosyestudios, array(
                    'Id' => $count,
                    'IdEstudio' => $row['idEstudio'],
                    'IdTipo' => $row['idTipo'],
                    'Grado' => $row['Grado'],
                    'Materia' => $row['Materia'],
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                    'Fecha' => $row['Fecha'],
                ));
            }
            return $arraygradosyestudios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCorreoyWeb($idDni)
    {
        try {
            $cmdcorreoyweb = Database::getInstance()->getDb()->prepare("SELECT 
            w.idWeb, 
            t.idTipo, 
            ISNULL(t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
            UPPER(w.Direccion) AS Direccion 
            FROM Web AS w 
            INNER JOIN Tipos AS t ON t.idTipo = w.Tipo WHERE idDNI = ?");
            $cmdcorreoyweb->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdcorreoyweb->execute();

            $arraycorreoyweb = array();

            $count = 0;
            while ($row = $cmdcorreoyweb->fetch()) {
                $count++;
                array_push($arraycorreoyweb, array(
                    'Id' => $count,
                    'IdWeb' => $row['idWeb'],
                    'IdTipo' => $row['idTipo'],
                    'Tipo' => $row['Tipo'],
                    'Direccion' => $row['Direccion'],
                ));
            }

            return $arraycorreoyweb;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getaddcolegiatura()
    {
        try {
            $arrayAddColegiatura = array();

            $cmdsede = Database::getInstance()->getDb()->prepare('SELECT idConsejo ,UPPER(Consejo) AS Consejo from Sede');
            $cmdsede->execute();
            $arraySede = array();
            while ($row = $cmdsede->fetch()) {
                array_push($arraySede, array(
                    'IdConsejo' => $row['idConsejo'],
                    'Sede' => $row['Consejo'],
                ));
            }

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare('SELECT idEspecialidad, UPPER (Especialidad) AS Especialidad from Especialidad');
            $cmdEspecialidad->execute();
            $arrayEspecialidad = array();
            while ($row = $cmdEspecialidad->fetch()) {
                array_push($arrayEspecialidad, array(
                    'IdEspecialidad' => $row['idEspecialidad'],
                    'Especialidad' => $row['Especialidad'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while ($row = $cmdUniversidad->fetch()) {
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }

            array_push($arrayAddColegiatura, $arraySede, $arrayEspecialidad, $arrayUniversidad);
            return $arrayAddColegiatura;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddDomicilio()
    {
        try {
            $arrayAddDomicilio = array();

            $cmdTipo = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'A'");
            $cmdTipo->execute();
            $arrayTipoDomicilio = array();
            while ($row = $cmdTipo->fetch()) {
                array_push($arrayTipoDomicilio, array(
                    'IdTipo' => $row['idTipo'],
                    'Descripcion' => $row['Descripcion']
                ));
            }

            $cmdUbicacion = Database::getInstance()->getDb()->prepare(" SELECT idUbigeo, CONCAT(Departamento, ' - ', Provincia, ' - ', 
            Distrito) AS Ubicacion FROM Ubigeo ");
            $cmdUbicacion->execute();
            $arrayUbicación = array();
            while ($row = $cmdUbicacion->fetch()) {
                array_push($arrayUbicación, array(
                    'IdUbicacion' => $row['idUbigeo'],
                    'Ubicacion' => $row['Ubicacion'],
                ));
            }

            array_push($arrayAddDomicilio, $arrayTipoDomicilio, $arrayUbicación);
            return $arrayAddDomicilio;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddCelular()
    {
        try {
            $cmdCelular = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'B'");
            $cmdCelular->execute();
            $arrayCelular = array();
            while ($row = $cmdCelular->fetch()) {
                array_push($arrayCelular, array(
                    'IdTipo' => $row['idTipo'],
                    'Tipo' => $row['Descripcion'],
                ));
            }
            return $arrayCelular;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getAddEstudios()
    {
        try {
            $arrayEstudios = array();

            $cmdgrado = Database::getInstance()->getDb()->prepare("SELECT idTipo, UPPER(Descripcion) AS Descripcion FROM tipos WHERE Categoria = 'D'");
            $cmdgrado->execute();
            $arrayGrado = array();
            while ($row = $cmdgrado->fetch()) {
                array_push($arrayGrado, array(
                    'IdGrado' => $row['idTipo'],
                    'Grado' => $row['Descripcion'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while ($row = $cmdUniversidad->fetch()) {
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }
            array_push($arrayEstudios, $arrayGrado, $arrayUniversidad);

            return $arrayEstudios;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getCorreo()
    {
        try {
            $cmdcorreo = Database::getInstance()->getDb()->prepare("SELECT idTipo, UPPER(Descripcion) AS Descripcion FROM tipos WHERE Categoria = 'C'");
            $cmdcorreo->execute();
            $arraycorreo = array();
            while ($row = $cmdcorreo->fetch()) {
                array_push($arraycorreo, array(
                    'IdCorreo' => $row['idTipo'],
                    'Correoyweb' => $row['Descripcion'],
                ));
            }

            return $arraycorreo;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    public static function getPicture($idDni)
    {
        try {
            $cmdfoto = Database::getInstance()->getDb()->prepare("SELECT UPPER(P.Nombres) AS Nombre, ISNULL(i.Foto, 0) AS Foto FROM PersonaImagen AS i 
            LEFT JOIN Persona AS p ON P.idDNI = i.idDNI WHERE I.idDNI = ?");
            $cmdfoto->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdfoto->execute();

            $arrayFoto = array();

            while ($row = $cmdfoto->fetch()) {
                array_push($arrayFoto, array(
                    'Nombre' => $row['Tipo'],
                    'Foto' => $row['Direccion'],
                ));
            }
            return $arrayFoto;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function insertColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Colegiatura WHERE idDNI = ?');
            $cmdSelect->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
            $cmdSelect->execute();
            if ($cmdSelect->fetch()) {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Colegiatura (
                        idDNI,
                        idSede,
                        idEspecialidad, 
                        FechaColegiado,
                        idUnivesidadEgreso, 
                        FechaEgreso,
                        idUniversidad,
                        FechaTitulacion,
                        Resolucion, 
                        Principal,
                        Resolucion15,
                        MesAumento)
                    VALUES(?,?,?,?,?,?,?,?,?,0,0,0)");

                $comandoInsert->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $colegiatura['sede'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $colegiatura['especialidad'], PDO::PARAM_INT);
                $comandoInsert->bindParam(4, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $colegiatura['universidadegreso'], PDO::PARAM_INT);
                $comandoInsert->bindParam(6, $colegiatura['fechaegreso'], PDO::PARAM_STR);
                $comandoInsert->bindParam(7, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
                $comandoInsert->bindParam(8, $colegiatura['fechatitulo'], PDO::PARAM_STR);
                $comandoInsert->bindParam(9, $colegiatura['resolucion'], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Colegiatura (
                        idDNI,
                        idSede,
                        idEspecialidad, 
                        FechaColegiado,
                        idUnivesidadEgreso, 
                        FechaEgreso,
                        idUniversidad,
                        FechaTitulacion,
                        Resolucion, 
                        Principal,
                        Resolucion15,
                        MesAumento)
                    VALUES(?,?,?,?,?,?,?,?,?,1,0,0)");

                $comandoInsert->bindParam(1, $colegiatura['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $colegiatura['sede'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $colegiatura['especialidad'], PDO::PARAM_INT);
                $comandoInsert->bindParam(4, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $colegiatura['universidadegreso'], PDO::PARAM_INT);
                $comandoInsert->bindParam(6, $colegiatura['fechaegreso'], PDO::PARAM_STR);
                $comandoInsert->bindParam(7, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
                $comandoInsert->bindParam(8, $colegiatura['fechatitulo'], PDO::PARAM_STR);
                $comandoInsert->bindParam(9, $colegiatura['resolucion'], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Direccion (idDNI, Tipo, Ubigeo, Direccion) VALUES (?,?,?,?)');

            $comandoInsert->bindParam(1, $domicilio['dni'], PDO::PARAM_STR);
            $comandoInsert->bindParam(2, $domicilio['tipo'], PDO::PARAM_INT);
            $comandoInsert->bindParam(3, $domicilio['departamento'], PDO::PARAM_INT);
            $comandoInsert->bindParam(4, $domicilio['direccion'], PDO::PARAM_INT);

            $comandoInsert->execute();
            Database::getInstance()->getDb()->commit();
            return 'Insertado';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertCelular($celular)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Telefono WHERE Telefono = ?');
            $cmdSelect->bindParam(1, $celular['numero'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Telefono (idDNI, Tipo, Telefono) VALUES (?,?,?)');

                $comandoInsert->bindParam(1, $celular['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $celular['tipo'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $celular['numero'], PDO::PARAM_INT);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Conyuge WHERE UPPER(FullName) = UPPER(?)');
            $cmdSelect->bindParam(1, $conyuge['conyuge'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Conyuge (idDNI, FullName, NumHijos) VALUES (?,UPPER(?),?)');

                $comandoInsert->bindParam(1, $conyuge['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $conyuge['conyuge'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $conyuge['hijos'], PDO::PARAM_INT);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Experiencia WHERE UPPER(Entidad) = UPPER(?) AND UPPER(ExpericienciaEn) = UPPER(?)');
            $cmdSelect->bindParam(1, $experiencia['entidad'], PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $experiencia['experiencia'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare("INSERT INTO Experiencia (idPersona, Entidad, ExpericienciaEn, FechaInicio, FechaFin) 
            VALUES (?,UPPER(?),UPPER(?),?,?);");

                $comandoInsert->bindParam(1, $experiencia['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $experiencia['entidad'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $experiencia['experiencia'], PDO::PARAM_STR);
                $comandoInsert->bindParam(4, $experiencia["fechaInicio"], PDO::PARAM_STR);
                $comandoInsert->bindParam(5, $experiencia["fechaFin"], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertEstudios($estudios)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Grados WHERE Grado = ? AND UPPER(Materia) = UPPER(?) AND idUniversidad = ?');
            $cmdSelect->bindParam(1, $estudios['grado'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $estudios['materia'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $estudios['universidad'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Grados (idDNI, Materia, Grado, idUniversidad, FechaGrado) VALUES (?,UPPER(?),?,?,?);');

                $comandoInsert->bindParam(1, $estudios['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $estudios['materia'], PDO::PARAM_STR);
                $comandoInsert->bindParam(3, $estudios['grado'], PDO::PARAM_INT);
                $comandoInsert->bindParam(4, $estudios['universidad'], PDO::PARAM_INT);
                $comandoInsert->bindParam(5, $estudios["fechaEstudios"], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function insertCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Web WHERE LOWER(Direccion) = ? AND Tipo = ?');
            $cmdSelect->bindParam(1, $correo['correo'], PDO::PARAM_STR);
            $cmdSelect->bindParam(2, $correo['tipo'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $comandoInsert = Database::getInstance()->getDb()->prepare('INSERT INTO Web (idDNI, Tipo, Direccion) VALUES (?,?,LOWER(?));');

                $comandoInsert->bindParam(1, $correo['dni'], PDO::PARAM_STR);
                $comandoInsert->bindParam(2, $correo['tipo'], PDO::PARAM_INT);
                $comandoInsert->bindParam(3, $correo['correo'], PDO::PARAM_STR);

                $comandoInsert->execute();
                Database::getInstance()->getDb()->commit();
                return 'Insertado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Colegiatura SET
                idSede = ?,
                idEspecialidad = ?, 
                FechaColegiado = ?,
                idUnivesidadEgreso = ?, 
                FechaEgreso = ?,
                idUniversidad = ?,
                FechaTitulacion = ?,
                Resolucion = ?
                WHERE idColegiado = ?");

            $cmdUpdate->bindParam(1, $colegiatura['sede'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(2, $colegiatura['especialidad'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(3, $colegiatura['fechacolegiacion'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(4, $colegiatura['universidadegreso'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(5, $colegiatura['fechaegreso'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(6, $colegiatura['universidadtitulacion'], PDO::PARAM_INT);
            $cmdUpdate->bindParam(7, $colegiatura['fechatitulo'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(8, $colegiatura['resolucion'], PDO::PARAM_STR);
            $cmdUpdate->bindParam(9, $colegiatura['idcolegiatura'], PDO::PARAM_INT);

            $cmdUpdate->execute();
            Database::getInstance()->getDb()->commit();
            return 'Actualizado';
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteColegiatura($colegiatura)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Colegiatura WHERE idColegiado = ?");
            $comandSelect->bindParam(1, $colegiatura["idcolegiatura"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Direccion WHERE idDireccion <> ? AND UPPER(Direccion) = UPPER(?) AND Ubigeo = ?');
            $cmdSelect->bindParam(1, $domicilio['idDireccion'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $domicilio['direccion'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $domicilio['departamento'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Direccion SET
                Tipo = ?,
                Ubigeo = ?, 
                Direccion = ?
                WHERE idDireccion = ?");

                $cmdUpdate->bindParam(1, $domicilio['tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $domicilio['departamento'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(3, $domicilio['direccion'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(4, $domicilio['idDireccion'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteDomicilio($domicilio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Direccion WHERE idDireccion = ?");
            $comandSelect->bindParam(1, $domicilio["iddomicilio"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateTelefono($telefono)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Telefono WHERE idTelefono <> ? AND Telefono = ?');
            $cmdSelect->bindParam(1, $telefono['idTelefono'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $telefono['numero'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Telefono SET
                Tipo = ?,
                Telefono = ?
                WHERE idTelefono = ?");

                $cmdUpdate->bindParam(1, $telefono['tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $telefono['numero'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $telefono['idTelefono'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteTelefono($telefono)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Telefono WHERE idTelefono = ?");
            $comandSelect->bindParam(1, $telefono["idtelefono"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Conyuge WHERE idConyugue <> ? AND FullName = ?');
            $cmdSelect->bindParam(1, $conyuge['idConyuge'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $conyuge['Conyuge'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Conyuge SET
                FullName = ?,
                NumHijos = ?
                WHERE idConyugue = ?");

                $cmdUpdate->bindParam(1, $conyuge['Conyuge'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(2, $conyuge['hijos'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(3, $conyuge['idConyuge'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Experiencia WHERE idExperiencia <> ? AND UPPER(Entidad) = UPPER(?) AND UPPER(ExpericienciaEn) = UPPER(?)');
            $cmdSelect->bindParam(1, $experiencia['idexperiencia'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $experiencia['entidad'], PDO::PARAM_STR);
            $cmdSelect->bindParam(3, $experiencia['experiencia'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Experiencia SET
                Entidad = UPPER(?),
                ExpericienciaEn = UPPER(?),
                FechaInicio = ?,
                FechaFin = ?
                WHERE idExperiencia = ?");

                $cmdUpdate->bindParam(1, $experiencia['entidad'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(2, $experiencia['experiencia'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $experiencia['inicio'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(4, $experiencia['fin'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(5, $experiencia['idexperiencia'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateEstudios($estudios)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Grados WHERE idEstudio <> ? AND Grado = ? AND UPPER(Materia) = UPPER(?) AND idUniversidad = ?');
            $cmdSelect->bindParam(1, $estudios['IdEstudio'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $estudios['Grado'], PDO::PARAM_INT);
            $cmdSelect->bindParam(3, $estudios['Materia'], PDO::PARAM_STR);
            $cmdSelect->bindParam(4, $estudios['Universidad'], PDO::PARAM_INT);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Grados SET
                Grado = ?,
                Materia = UPPER(?),
                idUniversidad = ?,
                FechaGrado = ?
                WHERE idEstudio = ?");

                $cmdUpdate->bindParam(1, $estudios['Grado'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $estudios['Materia'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $estudios['Universidad'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(4, $estudios['Fecha'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(5, $estudios['IdEstudio'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteIngeniero($idDni)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT * FROM Ingreso WHERE idDNI = ?");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            if ($cmdValidate->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "Ingresos";
            } else {

                $cmdColegiatura = Database::getInstance()->getDb()->prepare("DELETE FROM Colegiatura WHERE idDNI = ?");
                $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdColegiatura->execute();

                $cmdDomicilio = Database::getInstance()->getDb()->prepare("DELETE FROM Direccion WHERE idDNI = ?");
                $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdDomicilio->execute();

                $cmdDomicilio = Database::getInstance()->getDb()->prepare("DELETE FROM Telefono WHERE idDNI = ?");
                $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdDomicilio->execute();

                $cmdConyuge = Database::getInstance()->getDb()->prepare("DELETE FROM Conyuge WHERE idDNI = ?");
                $cmdConyuge->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdConyuge->execute();

                $cmdExperiencia = Database::getInstance()->getDb()->prepare("DELETE FROM Experiencia WHERE idPersona = ?");
                $cmdExperiencia->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdExperiencia->execute();

                $cmdGrados = Database::getInstance()->getDb()->prepare("DELETE FROM Grados WHERE idDNI = ?");
                $cmdGrados->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdGrados->execute();

                $cmdWeb = Database::getInstance()->getDb()->prepare("DELETE FROM Web WHERE idDNI = ?");
                $cmdWeb->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdWeb->execute();

                $cmdImagen = Database::getInstance()->getDb()->prepare("DELETE FROM PersonaImagen WHERE idDNI = ?");
                $cmdImagen->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdImagen->execute();

                $cmdIngeniero = Database::getInstance()->getDb()->prepare("DELETE FROM Persona WHERE idDNI = ?");
                $cmdIngeniero->bindParam(1, $idDni, PDO::PARAM_STR);
                $cmdIngeniero->execute();

                Database::getInstance()->getDb()->commit();
                return "eliminado";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteConyuge($conyuge)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Conyuge WHERE IdConyugue = ?");
            $comandSelect->bindParam(1, $conyuge["idconyuge"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteExperiencia($experiencia)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Experiencia WHERE idExperiencia = ?");
            $comandSelect->bindParam(1, $experiencia["idexperiencia"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteEstudio($estudio)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Grados WHERE idEstudio = ?");
            $comandSelect->bindParam(1, $estudio["idestudio"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function updateCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT * FROM Web WHERE idWeb <> ? AND Tipo = ? AND LOWER(Direccion) = LOWER(?)');
            $cmdSelect->bindParam(1, $correo['IdCorreo'], PDO::PARAM_INT);
            $cmdSelect->bindParam(2, $correo['Tipo'], PDO::PARAM_INT);
            $cmdSelect->bindParam(3, $correo['Direccion'], PDO::PARAM_STR);
            $cmdSelect->execute();

            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return 'Duplicado';
            } else {
                $cmdUpdate = Database::getInstance()->getDb()->prepare("UPDATE Web SET
                Tipo = ?,
                Direccion = LOWER(?)
                WHERE idWeb = ?");

                $cmdUpdate->bindParam(1, $correo['Tipo'], PDO::PARAM_INT);
                $cmdUpdate->bindParam(2, $correo['Direccion'], PDO::PARAM_STR);
                $cmdUpdate->bindParam(3, $correo['IdCorreo'], PDO::PARAM_INT);

                $cmdUpdate->execute();
                Database::getInstance()->getDb()->commit();
                return 'Actualizado';
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function deleteCorreo($correo)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $comandSelect = Database::getInstance()->getDb()->prepare("DELETE FROM Web WHERE idWeb = ?");
            $comandSelect->bindParam(1, $correo["IdCorreo"], PDO::PARAM_INT);
            $comandSelect->execute();
            Database::getInstance()->getDb()->commit();
            return "eliminado";
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function anularAfiliaciones($data)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdSelect = Database::getInstance()->getDb()->prepare('SELECT Estado FROM Afiliacion WHERE idAfiliacion = ? and Estado = 0');
            $cmdSelect->bindParam(1, $data["idAfiliacion"], PDO::PARAM_INT);
            $cmdSelect->execute();
            if ($cmdSelect->fetch()) {
                Database::getInstance()->getDb()->rollback();
                return "existed";
            } else {
                $comandSelect = Database::getInstance()->getDb()->prepare("UPDATE Afiliacion SET Motivo = ?, Fecha= ?, hora=?, idUsuario = ?, Estado = 0 WHERE idAfiliacion = ?");
                $comandSelect->bindParam(1, $data["motivo"], PDO::PARAM_STR);
                $comandSelect->bindParam(2, $data["fecha"], PDO::PARAM_STR);
                $comandSelect->bindParam(3, $data["hora"], PDO::PARAM_STR);
                $comandSelect->bindParam(4, $data["idUsuario"], PDO::PARAM_INT);
                $comandSelect->bindParam(5, $data["idAfiliacion"], PDO::PARAM_INT);
                $comandSelect->execute();
                Database::getInstance()->getDb()->commit();
                return "update";
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollback();
            return $ex->getMessage();
        }
    }

    public static function getHabilidadIngeniero($opcion, $search, $tipoHabilidad, $capitulo, $especialidad, $fecha, $fechaFin, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayHabilidad = array();
            if ($opcion == 5) {
                $comandoHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
                p.CIP  AS Cip, 
                p.NumDoc as Dni, 
                p.Apellidos ,
                p.Nombres, 
                p.Condicion as CodigoCondicion,
                CASE p.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido' 
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad AS Especialidad,
                CAST(c.FechaColegiado AS DATE)  AS FechaColegiado,
                CAST(ISNULL(ul.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,             
                CASE
                WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad,
                CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta           
                FROM Ingreso AS i 
                INNER JOIN Persona AS p ON i.idDNI = p.idDNI
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE i.Fecha BETWEEN ? AND ?     
                GROUP BY
                p.CIP, 
                p.NumDoc, 
                p.Apellidos ,
                p.Nombres,    
                p.Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad,
                c.FechaColegiado,
                ul.FechaUltimaCuota    
                ORDER BY p.CIP          
                offset ? ROWS FETCH NEXT ? ROWS only");
                $comandoHabilidad->bindParam(1, $fecha, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(2, $fechaFin, PDO::PARAM_STR);

                $comandoHabilidad->bindParam(3, $posicionPagina, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(4, $filasPorPagina, PDO::PARAM_INT);
                $comandoHabilidad->execute();
            } else {
                $comandoHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
                p.CIP  AS Cip, 
                p.NumDoc as Dni, 
                p.Apellidos ,
                p.Nombres, 
                p.Condicion as CodigoCondicion,
                CASE p.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido' 
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad AS Especialidad,
                CAST(c.FechaColegiado AS DATE)  AS FechaColegiado,
                CAST(ISNULL(ul.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,             
                CASE
                WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad,
                CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta           
                FROM Persona AS p
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE $opcion = 0
                OR $opcion = 1 and p.NumDoc = ? 
                OR $opcion = 1 and p.CIP = ? 
                OR $opcion = 1 and p.Apellidos LIKE CONCAT(?,'%') 
                OR $opcion = 1 and p.Nombres LIKE CONCAT(?,'%') 

                OR $opcion = 2 and $tipoHabilidad = 0 
                OR $opcion = 2 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 
                OR $opcion = 2 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 
            
                OR $opcion = 3 and $tipoHabilidad = 0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ?
                
                OR $opcion = 4 and $tipoHabilidad = 0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ? and e.idEspecialidad =?

                ORDER BY p.FechaReg 
                offset ? ROWS FETCH NEXT ? ROWS only");
                $comandoHabilidad->bindParam(1, $search, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(2, $search, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(3, $search, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(4, $search, PDO::PARAM_STR);

                $comandoHabilidad->bindParam(5, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(6, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(7, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(8, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(9, $especialidad, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(10, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(11, $especialidad, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(12, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(13, $especialidad, PDO::PARAM_INT);

                $comandoHabilidad->bindParam(14, $posicionPagina, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(15, $filasPorPagina, PDO::PARAM_INT);
                $comandoHabilidad->execute();
            }


            $count = 0;
            while ($row = $comandoHabilidad->fetch()) {
                $count++;
                $dateFechaColegiado = new DateTime($row['FechaColegiado']);
                $dateFechaUltimaCuota = new DateTime($row['FechaUltimaCuota']);
                $dateHabilidadHasta = new DateTime($row['HabilitadoHasta']);
                array_push($arrayHabilidad, array(
                    'Id' => $count + $posicionPagina,
                    'Cip' => $row['Cip'],
                    'Dni' => $row['Dni'],
                    'Apellidos' => $row['Apellidos'],
                    'Nombres' => $row['Nombres'],
                    'Condicion' => $row['Condicion'],
                    'CodigoCondicion' => $row['CodigoCondicion'],
                    'Capitulo' => $row["Capitulo"],
                    'Especialidad' => $row['Especialidad'],
                    'Colegiatura' => $row['FechaColegiado'],
                    'FechaColegiado' => $dateFechaColegiado->format("d/m/Y"),
                    'FechaUltimaCuota' => $dateFechaUltimaCuota->format("m/Y"),
                    'UltimaCuota' => $row['FechaUltimaCuota'],
                    'Habilidad' => $row['Habilidad'],
                    'HabilitadoHasta' =>  $dateHabilidadHasta->format("m/Y")
                ));
            }

            if ($opcion == 5) {
                $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT 
                count(1)
                FROM Ingreso AS i 
                INNER JOIN Persona AS p ON i.idDNI = p.idDNI
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE 
                i.Fecha between ? and ?
                GROUP BY
                p.CIP, 
                p.NumDoc, 
                p.Apellidos ,
                p.Nombres,    
                p.Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad,
                c.FechaColegiado,
                ul.FechaUltimaCuota");
                $comandoTotal->bindParam(1, $fecha, PDO::PARAM_STR);
                $comandoTotal->bindParam(2, $fechaFin, PDO::PARAM_STR);
                $comandoTotal->execute();
                $resultTotal = count($comandoTotal->fetchAll(PDO::FETCH_OBJ));
            } else {
                $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(p.idDNI) 
                FROM Persona AS p
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE $opcion = 0 
                OR $opcion = 1 and p.NumDoc = ? 
                OR $opcion = 1 and p.CIP = ? 
                OR $opcion = 1 and p.Apellidos LIKE CONCAT(?,'%') 
                OR $opcion = 1 and p.Nombres LIKE CONCAT(?,'%') 
                
                OR $opcion = 2 and $tipoHabilidad = 0 
                OR $opcion = 2 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 
                OR $opcion = 2 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 
                
                OR $opcion = 3 and $tipoHabilidad = 0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ?
                
                OR $opcion = 4 and $tipoHabilidad = 0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ? and e.idEspecialidad =?
            
                ");
                $comandoTotal->bindParam(1, $search, PDO::PARAM_INT);
                $comandoTotal->bindParam(2, $search, PDO::PARAM_STR);
                $comandoTotal->bindParam(3, $search, PDO::PARAM_STR);
                $comandoTotal->bindParam(4, $search, PDO::PARAM_STR);
                $comandoTotal->bindParam(5, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(6, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(7, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(8, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(9, $especialidad, PDO::PARAM_INT);
                $comandoTotal->bindParam(10, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(11, $especialidad, PDO::PARAM_INT);
                $comandoTotal->bindParam(12, $capitulo, PDO::PARAM_INT);
                $comandoTotal->bindParam(13, $especialidad, PDO::PARAM_INT);
                $comandoTotal->execute();
                $resultTotal =  $comandoTotal->fetchColumn();
            }

            array_push($array, $arrayHabilidad, $resultTotal);
            return $array;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function getHabilidadIngenieroForExcel($opcion, $search, $tipoHabilidad, $capitulo, $especialidad, $fecha, $fechaFin)
    {
        try {

            $arrayHabilidad = array();
            if ($opcion == 5) {
                $comandoHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
                p.CIP  AS Cip, 
                p.NumDoc as Dni, 
                p.Apellidos ,
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,
				ISNULL(t.Telefono,'') AS Celular,
				ISNULL(w.Direccion,'') AS Email,
                p.Condicion as CodigoCondicion,
                CASE p.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido' 
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad AS Especialidad,
                CAST(c.FechaColegiado AS DATE)  AS FechaColegiado,
                CAST(ISNULL(ul.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,             
                CASE
                WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad,
                CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta           
                FROM Ingreso AS i 
                INNER JOIN Persona AS p ON i.idDNI = p.idDNI
                LEFT JOIN Telefono AS t ON t.idDNI = p.idDNI
				LEFT JOIN Web AS w ON w.idDNI = p.idDNI
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE i.Fecha BETWEEN ? AND ?     
                GROUP BY
                p.CIP, 
                p.NumDoc, 
                p.Apellidos ,
                p.Nombres,    
                p.Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad,
                c.FechaColegiado,
                ul.FechaUltimaCuota    
                ORDER BY p.CIP");
                $comandoHabilidad->bindParam(1, $fecha, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(2, $fechaFin, PDO::PARAM_STR);
                $comandoHabilidad->execute();
            } else {
                $comandoHabilidad = Database::getInstance()->getDb()->prepare("SELECT 
                p.CIP  AS Cip, 
                p.NumDoc as Dni, 
                p.Apellidos ,
                p.Nombres, 
                CASE p.Sexo WHEN 'M' THEN 'MASCULINO'
				ELSE 'FEMENINO' END AS Genero,
				ISNULL(t.Telefono,'') AS Celular,
				ISNULL(w.Direccion,'') AS Email,
                p.Condicion as CodigoCondicion,
                CASE p.Condicion
                WHEN 'T' THEN 'Transeunte'
                WHEN 'F' THEN 'Fallecido' 
                WHEN 'R' THEN 'Retirado'
                WHEN 'V' THEN 'Vitalicio'
                ELSE 'Ordinario' END AS Condicion,
                ca.idCapitulo,
                ca.Capitulo,
                e.idEspecialidad,
                e.Especialidad AS Especialidad,
                CAST(c.FechaColegiado AS DATE)  AS FechaColegiado,
                CAST(ISNULL(ul.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,             
                CASE
                WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
                ELSE 'No Habilitado' END AS Habilidad,
                CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta           
                FROM Persona AS p
                LEFT JOIN Telefono AS t ON t.idDNI = p.idDNI
				LEFT JOIN Web AS w ON w.idDNI = p.idDNI
                INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
                INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
                INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
                INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
                WHERE $opcion = 0
                OR $opcion = 1 and p.NumDoc = ? 
                OR $opcion = 1 and p.CIP = ? 
                OR $opcion = 1 and p.Apellidos LIKE CONCAT(?,'%') 
                OR $opcion = 1 and p.Nombres LIKE CONCAT(?,'%') 

                OR $opcion = 2 and $tipoHabilidad = 0 
                OR $opcion = 2 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 
                OR $opcion = 2 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 
            
                OR $opcion = 3 and $tipoHabilidad = 0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ?
                OR $opcion = 3 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ?
                
                OR $opcion = 4 and $tipoHabilidad = 0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 1 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 and ca.idCapitulo = ? and e.idEspecialidad =?
                OR $opcion = 4 and $tipoHabilidad = 2 and CAST(DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) >0 and ca.idCapitulo = ? and e.idEspecialidad =?

                ORDER BY p.FechaReg");
                $comandoHabilidad->bindParam(1, $search, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(2, $search, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(3, $search, PDO::PARAM_STR);
                $comandoHabilidad->bindParam(4, $search, PDO::PARAM_STR);

                $comandoHabilidad->bindParam(5, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(6, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(7, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(8, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(9, $especialidad, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(10, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(11, $especialidad, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(12, $capitulo, PDO::PARAM_INT);
                $comandoHabilidad->bindParam(13, $especialidad, PDO::PARAM_INT);
                $comandoHabilidad->execute();
            }


            $count = 0;
            while ($row = $comandoHabilidad->fetch()) {
                $count++;
                $dateFechaColegiado = new DateTime($row['FechaColegiado']);
                $dateFechaUltimaCuota = new DateTime($row['FechaUltimaCuota']);
                $dateHabilidadHasta = new DateTime($row['HabilitadoHasta']);
                array_push($arrayHabilidad, array(
                    'Id' => $count,
                    'Cip' => $row['Cip'],
                    'Dni' => $row['Dni'],
                    'Apellidos' => $row['Apellidos'],
                    'Nombres' => $row['Nombres'],
                    'Genero' => $row['Genero'],
                    'Celular' => $row['Celular'],
                    'Email' => $row['Email'],
                    'Condicion' => $row['Condicion'],
                    'CodigoCondicion' => $row['CodigoCondicion'],
                    'Capitulo' => $row["Capitulo"],
                    'Especialidad' => $row['Especialidad'],
                    'Colegiatura' => $row['FechaColegiado'],
                    'FechaColegiado' => $dateFechaColegiado->format("d/m/Y"),
                    'FechaUltimaCuota' => $dateFechaUltimaCuota->format("m/Y"),
                    'UltimaCuota' => $row['FechaUltimaCuota'],
                    'Habilidad' => $row['Habilidad'],
                    'HabilitadoHasta' =>  $dateHabilidadHasta->format("m/Y")
                ));
            }

            return $arrayHabilidad;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    //Funciones Ruber

    public static function getCountConditionPerson()
    {

        try {
            $cmdOrdinario = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='O'");

            $cmdTranseunte = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='T'");

            $cmdFallecido = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='F'");

            $cmdRetirado = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='R'");

            $cmdVitalicio = Database::getInstance()->getDb()->prepare("SELECT count(1) FROM Persona WHERE Condicion='V'");

            $cmdTotalPersonas = Database::getInstance()->getDb()->prepare('SELECT count(1) FROM Persona');

            $cmdTotalHabilitados = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(1)
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
            INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
            WHERE
			CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <= 0
            ");

            $cmdTotalInhabilitados = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(1)
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e on e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca on ca.idCapitulo = e.idCapitulo
            INNER JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
            WHERE
			CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) > 0");

            $cmdColegiados = Database::getInstance()->getDb()->prepare("SELECT count(1) 
            FROM Persona AS p
            LEFT JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1 
			WHERE 
			c.idColegiado IS NOT NULL");

            $cmdSinColegiatura = Database::getInstance()->getDb()->prepare("SELECT COUNT(1)  
            FROM Persona AS p
            LEFT JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1 
			WHERE 
			c.idColegiado IS NULL");

            $cmdConCuotas = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(1)
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            LEFT JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
            WHERE
			ul.FechaUltimaCuota IS NOT NULL");

            $cmdSinCuotas = Database::getInstance()->getDb()->prepare("SELECT 
            COUNT(1)
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
            LEFT JOIN ULTIMACuota AS ul ON  ul.idDNI = p.idDNI
            WHERE
            ul.FechaUltimaCuota IS NULL");

            $cmdOrdinario->execute();
            $cmdTranseunte->execute();
            $cmdFallecido->execute();
            $cmdRetirado->execute();
            $cmdVitalicio->execute();
            $cmdTotalPersonas->execute();
            $cmdColegiados->execute();
            $cmdSinColegiatura->execute();
            $cmdConCuotas->execute();
            $cmdSinCuotas->execute();
            $cmdTotalHabilitados->execute();
            $cmdTotalInhabilitados->execute();

            $resultCondicion = [
                'Ordinario' => $cmdOrdinario->fetchColumn(),
                'Transeunte' => $cmdTranseunte->fetchColumn(),
                'Fallecido' => $cmdFallecido->fetchColumn(),
                'Retirado' => $cmdRetirado->fetchColumn(),
                'Vitalicio' => $cmdVitalicio->fetchColumn(),
                'Personas' => $cmdTotalPersonas->fetchColumn(),
                'Colegiados' => $cmdColegiados->fetchColumn(),
                'SinColegiatura' => $cmdSinColegiatura->fetchColumn(),
                'ConCuotas' => $cmdConCuotas->fetchColumn(),
                'SinCuotas' => $cmdSinCuotas->fetchColumn(),
                'Habilitados' => $cmdTotalHabilitados->fetchColumn(),
                'Inbilitados' => $cmdTotalInhabilitados->fetchColumn(),

            ];

            return $resultCondicion;
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    public static function reincorporacion($idDni, $fecha, $idUsuario)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $cmdPago = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)as date) as UltimoPago     
            from Persona as p 
            inner join Colegiatura as c
            on p.idDNI = c.idDNI and c.Principal = 1
            left outer join ULTIMACuota as ul
            on p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdPago->bindParam(1, $idDni, PDO::PARAM_INT);
            $cmdPago->execute();
            if ($row = $cmdPago->fetch()) {
                $ultimoPago = new DateTime($row["UltimoPago"]);
                $ultimoPago->setDate($ultimoPago->format("Y"), $ultimoPago->format("m"), 1);
                $ultimoPago->modify('+1 month');

                $fechaActual = new DateTime($fecha . " 00:00:00");
                $fechaActual->setDate($fechaActual->format("Y"), $fechaActual->format("m"), 1);

                if ($fechaActual <= $ultimoPago) {
                    throw new Exception('La fecha que desea cambiar es menor o igual al ultimo pago.');
                } else {

                    $cmdIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO Ingreso(
                        idDni,
                        idEmpresaPersona,
                        TipoComprobante,
                        Serie,
                        NumRecibo,
                        Fecha,
                        Hora,
                        idUsuario,
                        Estado,
                        Deposito,
                        Observacion,
                        Tipo,
                        idBanco,
                        NumOperacion
                        )VALUES(?,null,0,'','',GETDATE(),GETDATE(),?,'C',0,'',0,0,'')");
                    $cmdIngreso->bindParam(1, $idDni, PDO::PARAM_STR);
                    $cmdIngreso->bindParam(2, $idUsuario, PDO::PARAM_INT);
                    $cmdIngreso->execute();

                    $idIngreso = Database::getInstance()->getDb()->lastInsertId();

                    $fechaIni = $ultimoPago->format('Y') . '-' . $ultimoPago->format('m') . '-' . $ultimoPago->format('d');
                    $fechaFin = $fechaActual->format('Y') . '-' . $fechaActual->format('m') . '-' . $fechaActual->format('d');

                    $cmdCuota = Database::getInstance()->getDb()->prepare("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)");
                    $cmdCuota->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdCuota->bindParam(2, $fechaIni, PDO::PARAM_STR);
                    $cmdCuota->bindParam(3, $fechaFin, PDO::PARAM_STR);
                    $cmdCuota->execute();

                    $idConcepto = 4;
                    $cantidad = 1;
                    $monto = 0;

                    $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
                        idIngreso,
                        idConcepto,
                        Cantidad,
                        Monto
                        )VALUES(?,?,?,?)");
                    $cmdDetalle->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(2, $idConcepto, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(3, $cantidad, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(4, $monto, PDO::PARAM_INT);
                    $cmdDetalle->execute();

                    $idConcepto = 6;
                    $cantidad = 1;
                    $monto = 0;

                    $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
                        idIngreso,
                        idConcepto,
                        Cantidad,
                        Monto
                        )VALUES(?,?,?,?)");
                    $cmdDetalle->bindParam(1, $idIngreso, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(2, $idConcepto, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(3, $cantidad, PDO::PARAM_INT);
                    $cmdDetalle->bindParam(4, $monto, PDO::PARAM_INT);
                    $cmdDetalle->execute();

                    Database::getInstance()->getDb()->commit();
                    return "update";
                }
            } else {
                throw new Exception('El cliente no tiene ultimo pago para poder realizar la reincorporación.');
            }
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return $ex->getMessage();
        }
    }


    /**
     * funcion para iniciar sesión desde la api
     */
    public static function getUsurioLogin($usuario, $clave)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT  
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP,
            p.Clave
            FROM Persona AS p
            WHERE p.CIP = ?");
            $cmdValidate->bindParam(1, $usuario, PDO::PARAM_STR);
            // $cmdValidate->bindParam(2, $clave, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultUsuario = $cmdValidate->fetchObject();
            if ($resultUsuario) {
                // return array("state" => 1, "persona" => $resultUsuario);
                if (password_verify($clave, $resultUsuario->Clave)) {
                    return array("state" => 1, "persona" => $resultUsuario);
                } else {
                    return array(
                        'state' => '0',
                        'message' => 'Usuario o contraseña incorrectas.',
                    );
                }
            } else {
                return array("state" => 2, "message" => "El usuario o contraseña son incorrectas.");
            }
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }

    /**
     * funcion para el inicio desde la api
     */
    public static function getPersonaPerfil($idDni)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI,
            p.NumDoc,
            p.Nombres,
            p.Apellidos,
            p.CIP,
            p.Sexo,
            CONVERT(VARCHAR,CAST(ISNULL(p.FechaNac,GETDATE()) AS DATE),103) AS FechaNac,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion
            FROM Persona AS p
            WHERE p.idDNI = ? ");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultPerfil = $cmdValidate->fetch(PDO::FETCH_ASSOC);

            $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
                Foto
                FROM PersonaImagen WHERE idDNI = ?");
            $cmdImage->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdImage->execute();
            $image = "";
            if ($row = $cmdImage->fetch()) {
                $image = base64_encode($row['Foto']);
            }

            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT 
            c.idColegiado,
            s.idConsejo, 
            s.Consejo, 
            ca.idCapitulo,
            ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo,
            e.idEspecialidad,
            UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
            convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
            c.idUnivesidadEgreso AS idUnivEgreso,
            ISNULL(ue.Universidad,'UNIVERSIDAD NO REGISTRADA') AS UnivesidadEgreso,
            convert(VARCHAR,cast(c.FechaEgreso AS DATE),103) AS FechaEgreso, 
            u.idUniversidad,
            ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            Convert(VARCHAR,cast(c.FechaTitulacion AS DATE),103) AS FechaTitulacion, 
            c.Resolucion,
            c.Principal 
            FROM Colegiatura  AS c
            LEFT JOIN Sede AS s ON s.idConsejo = c.idSede
            LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
			LEFT JOIN Universidad as ue ON ue.idUniversidad = c.idUnivesidadEgreso 
            LEFT JOIN Universidad AS u ON u.idUniversidad = c.idUniversidad where idDNI = ?");
            $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdColegiatura->execute();
            $resultColegiatura = $cmdColegiatura->fetchAll(PDO::FETCH_OBJ);

            $cmdDomicilio = Database::getInstance()->getDb()->prepare("SELECT 
            d.idDireccion,
            t.idTipo, 
            ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo,
            UPPER(d.Direccion) AS Direccion, 
            u.IdUbigeo, 
            CONCAT((ISNULL (u.Departamento,'DEPARTAMENTO NO REGISTRADA')),' - ',(ISNULL (u.Provincia,'DEPARTAMENTO NO REGISTRADA')),' - ',(ISNULL (u.Distrito,'DEPARTAMENTO NO REGISTRADA')  )) AS Ubigeo 
            FROM Direccion AS d
            LEFT JOIN Tipos AS t ON t.idTipo = d.Tipo 
            LEFT JOIN Ubigeo AS u ON u.idUbigeo = d.Ubigeo
            WHERE d.idDNI = ?");
            $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdDomicilio->execute();
            $resultDomicilio = $cmdDomicilio->fetchAll(PDO::FETCH_OBJ);

            $cmdTelefono = Database::getInstance()->getDb()->prepare("SELECT 
            a.idTelefono, 
            t.idTipo, 
            ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
            a.Telefono 
            FROM Telefono AS a 
            LEFT JOIN Tipos AS t ON t.idTipo = a.Tipo WHERE a.idDNI = ?");
            $cmdTelefono->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdTelefono->execute();
            $resultTelefono = $cmdTelefono->fetchAll(PDO::FETCH_OBJ);


            $cmdConyuge = Database::getInstance()->getDb()->prepare('SELECT 
            IdConyugue, 
            UPPER(FullName) AS NombreCompleto, 
            NumHijos 
            FROM Conyuge WHERE idDNI = ?');
            $cmdConyuge->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdConyuge->execute();
            $resultConyuge = $cmdConyuge->fetchAll(PDO::FETCH_OBJ);

            $cmdExperiencia = Database::getInstance()->getDb()->prepare("SELECT 
            idExperiencia, 
            UPPER(Entidad) AS Entidad, 
            UPPER(ExpericienciaEn) AS  Experiencia,  
            CONVERT(VARCHAR,cast(FechaInicio AS DATE),103) AS FechaInicio, 
            CONVERT(VARCHAR,cast(FechaFin AS DATE),103) AS FechaFin
             FROM Experiencia WHERE idPersona = ?");
            $cmdExperiencia->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdExperiencia->execute();
            $resultExperiencia = $cmdExperiencia->fetchAll(PDO::FETCH_OBJ);

            $cmdgradosyestudios = Database::getInstance()->getDb()->prepare("SELECT 
            g.idEstudio, 
            t.idTipo, 
            UPPER(t.Descripcion) AS Grado, 
            UPPER(Materia) AS Materia, 
            u.idUniversidad, 
            ISNULL(u.Universidad, 'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            CONVERT(VARCHAR, cast(g.FechaGrado AS DATE), 103) AS Fecha 
            FROM Grados AS g 
            LEFT JOIN Universidad AS u ON u.idUniversidad = g.idUniversidad
            LEFT JOIN Tipos AS t ON t.idTipo = g.Grado AND t.Categoria = 'D'
            WHERE g.idDNI = ?");
            $cmdgradosyestudios->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdgradosyestudios->execute();
            $resultGradosyEstudios = $cmdgradosyestudios->fetchAll(PDO::FETCH_OBJ);

            $cmdcorreoyweb = Database::getInstance()->getDb()->prepare("SELECT 
            w.idWeb, 
            t.idTipo, 
            ISNULL(t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
            UPPER(w.Direccion) AS Direccion 
            FROM Web AS w 
            INNER JOIN Tipos AS t ON t.idTipo = w.Tipo WHERE idDNI = ?");
            $cmdcorreoyweb->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdcorreoyweb->execute();
            $resultCorreoWeb = $cmdcorreoyweb->fetchAll(PDO::FETCH_OBJ);

            return array(
                "state" => 1,
                "persona" => $resultPerfil,
                "image" => $image,
                "colegiatura" => $resultColegiatura,
                "domicilio" => $resultDomicilio,
                "telefono" => $resultTelefono,
                "conyuge" => $resultConyuge,
                "experiencia" => $resultExperiencia,
                "gradosestudios" => $resultGradosyEstudios,
                "correoweb" => $resultCorreoWeb,
            );
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }

    /**
     * 
     */

    public static function getByIdPersonaToUpdate($idDni)
    {
        try {

            $user = Database::getInstance()->getDb()->prepare('SELECT 
            idDNI, 
            NumDoc, 
            Nombres, 
            Apellidos, 
            Sexo, 
            cast(FechaNac as date) as FechaNacimiento 
            FROM Persona 
            WHERE idDNI = ?');
            $user->execute(array(
                $idDni
            ));
            $resultUser = $user->fetchObject();

            if ($resultUser) {
                $web = Database::getInstance()->getDb()->prepare("SELECT TOP 1 w.Direccion 
                FROM Persona AS p
                INNER JOIN Web AS w
                ON p.idDNI = w.idDNI
                WHERE p.idDNI = ?");
                $web->execute(array(
                    $idDni
                ));
                $objectWeb = $web->fetchObject();
                $email = $objectWeb == null ? "" : $objectWeb->Direccion;

                $direccion = Database::getInstance()->getDb()->prepare("SELECT TOP 1 d.Direccion FROM Persona AS p
                INNER JOIN Direccion AS d
                ON p.idDNI = d.idDNI
                WHERE p.idDNI = ?");
                $direccion->execute(array(
                    $idDni
                ));
                $objectDireccion = $direccion->fetchObject();
                $ubicacion = $objectDireccion == null ? "" : $objectDireccion->Direccion;

                $telefono = Database::getInstance()->getDb()->prepare("SELECT TOP 1 t.Telefono FROM Persona AS p
                INNER JOIN Telefono AS t
                ON p.idDNI = t.idDNI
                WHERE p.idDNI = ?");
                $telefono->execute(array(
                    $idDni
                ));
                $objectTelefono = $telefono->fetchObject();
                $phone = $objectTelefono == null ? "" : $objectTelefono->Telefono;

                return Response::sendSuccess([
                    'user' => $resultUser,
                    'email' => $email,
                    'ubicacion' => $ubicacion,
                    'phone' => $phone
                ]);
            } else {
                return Response::sendClient("Datos no encontrados.");
            }
        } catch (PDOException $ex) {
            return Response::sendError("Error de conexión del servidor, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            return Response::sendError("Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }

    public static function actPersonaById($request)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $deleteTelefono = Database::getInstance()->getDb()->prepare("DELETE FROM Telefono WHERE idDNI = ?");
            $deleteTelefono->execute(array($request->idDni));

            $insTelefono = Database::getInstance()->getDb()->prepare("INSERT INTO Telefono(idDNI,Tipo,Telefono) VALUES(?,7,?)");
            $insTelefono->execute(array(
                $request->idDni,
                $request->phone
            ));

            $deleteDireccion = Database::getInstance()->getDb()->prepare("DELETE FROM Direccion WHERE idDNI = ?");
            $deleteDireccion->execute(array($request->idDni));

            $insDireccion = Database::getInstance()->getDb()->prepare("INSERT INTO Direccion(idDNI,Tipo,Ubigeo,Direccion)VALUES(?,1,1224,?)");
            $insDireccion->execute(array(
                $request->idDni,
                $request->address
            ));

            $deleteWeb = Database::getInstance()->getDb()->prepare("DELETE FROM Web WHERE idDNI = ?");
            $deleteWeb->execute(array($request->idDni));

            $insWeb = Database::getInstance()->getDb()->prepare("INSERT INTO Web(idDNI,Tipo,Direccion)values(?,16,?)");
            $insWeb->execute(array(
                $request->idDni,
                $request->email
            ));

            $update = Database::getInstance()->getDb()->prepare("UPDATE Persona SET Nombres=?, Apellidos=?, NumDoc=?, Sexo=?, FechaNac=? WHERE idDNI=?");
            $update->execute(array(
                $request->Nombres,
                $request->Apellidos,
                $request->NumDoc,
                $request->Sexo,
                $request->FechaNacimiento,
                $request->idDni
            ));

            Database::getInstance()->getDb()->commit();

            return Response::sendSave('Datos actualizados correctamente.');
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Error de conexión del servidor, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }


    /**
     * funcion para el registrar su cuenta
     */
    public static function valid($request)
    {
        $user = Database::getInstance()->getDb()->prepare('SELECT * FROM Persona WHERE NumDoc = ? AND CIP = ?');
        $user->execute(array(
            $request->dni,
            $request->cip,
        ));
        $resultUser = $user->fetchObject();

        if ($resultUser) {
            if ($resultUser->Clave !== null) {
                return array(
                    'state' => 2,
                    'message' => "Usted ya tiene una cuenta registrar, restablezca su cuenta para obtener una nueva."
                );
            } else {
                return array(
                    'state' => 1,
                    'user' => $resultUser,
                );
            }
        } else {
            return array(
                'state' => 0,
                'message' => "Datos no encontrados.",
            );
        }
    }

    /**
     * funcion para el registrar su cuenta
     */
    public static function save($request)
    {
        try {
            $user = Database::getInstance()->getDb()->prepare('SELECT * FROM Persona WHERE idDNI = ?');
            $user->execute(array(
                $request->idDNI
            ));

            if ($user->fetchObject()) {
                Database::getInstance()->getDb()->beginTransaction();

                $persona = Database::getInstance()->getDb()->prepare('UPDATE Persona SET Clave = ? WHERE idDNI = ?');
                $persona->execute(array(
                    password_hash($request->password, PASSWORD_DEFAULT),
                    $request->idDNI
                ));

                $web = Database::getInstance()->getDb()->prepare('DELETE FROM Web where idDNI = ?');
                $web->execute(array($request->idDNI));

                $insert = Database::getInstance()->getDb()->prepare('INSERT INTO Web(idDNI,Tipo,Direccion) VALUES(?,16,?)');
                $insert->execute(array(
                    $request->idDNI,
                    $request->email
                ));

                Database::getInstance()->getDb()->commit();
                return array(
                    'state' => 1,
                    'message' => "Se guardo correctamente su contraseña, ahora puede ingresar al sistema usando su n° cip y su clave.",
                );
            } else {
                return array(
                    'state' => 2,
                    'message' => "Se pudo validar los datos, intente nuevamente en un parte de minutos.",
                );
            }
        } catch (PDOException $e) {
            Database::getInstance()->getDb()->rollBack();
            return array(
                'state' => 0,
                'message' => "Error de conexión, intente nuevamente en un parte de minutos.",
            );
        }
    }

    /**
     * funcion para el obtener información de la persona
     */
    public static function getPersonaInformacion($idDni, $mes, $yearCurrentView, $monthCurrentView)
    {
        try {
            $cmdValidate = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI,
            p.Nombres,
            p.Apellidos,
            p.CIP ,
            e.Especialidad,
            ca.Capitulo,
            CASE p.Condicion WHEN 'V' THEN 'VITALICIO' WHEN 'R' THEN 'RETIRADO' WHEN 'F' THEN 'FALLECIDO' WHEN 'T' THEN 'TRANSEUNTE' ELSE 'ORDINARIO' END AS Condicion,
            CAST(ISNULL(uc.FechaUltimaCuota,c.FechaColegiado) AS DATE) AS FechaUltimaCuota,
            CAST(DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota,c.FechaColegiado)) AS DATE) AS HabilitadoHasta,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(uc.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 1
            ELSE 0 END AS Habilidad,
            DATEDIFF(YEAR,GETDATE(),DATEADD(MONTH,c.MesAumento,DATEADD(YEAR,30,c.FechaColegiado))) CumplirTreinta
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            INNER JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
            INNER JOIN Capitulo as ca ON ca.idCapitulo = e.idCapitulo
            LEFT OUTER JOIN ULTIMACuota AS uc ON uc.idDNI = p.idDNI
            WHERE p.idDNI = ?");
            $cmdValidate->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdValidate->execute();
            $resultInformacion = $cmdValidate->fetch(PDO::FETCH_ASSOC);

            $web = Database::getInstance()->getDb()->prepare("SELECT TOP 1 w.Direccion 
            FROM Persona AS p
            INNER JOIN Web AS w
            ON p.idDNI = w.idDNI
            WHERE p.idDNI = ?");
            $web->bindParam(1, $idDni, PDO::PARAM_STR);
            $web->execute();

            $email = "";
            if ($row = $web->fetchObject()) {
                $email = $row->Direccion;
            }

            $cmdCuota = Database::getInstance()->getDb()->prepare("SELECT 
            cast(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado) AS DATE) AS UltimoPago     
            FROM Persona AS p 
            INNER JOIN Colegiatura AS c ON p.idDNI = c.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON p.idDNI = ul.idDNI
            WHERE p.idDNI = ?");
            $cmdCuota->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdCuota->execute();

            if ($resultInformacion["Condicion"] == "ORDINARIO") {
                $condicion =  1;
            } else if ($resultInformacion["Condicion"] == "VITALICIO") {
                $condicion =  3;
            } else {
                $condicion =  0;
            }

            $montodeuda = 0;

            if ($row = $cmdCuota->fetch()) {

                $date = new DateTime($row["UltimoPago"]);
                $date->setDate($date->format("Y"), $date->format("m"), 1);

                $fechaactual = new DateTime('now');
                if ($fechaactual < $date) {
                    $fechaactual = new DateTime($row["UltimoPago"]);
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
                    $fechaactual->modify('+ ' . $mes  . ' month');
                } else {
                    if ($yearCurrentView == "" && $monthCurrentView == "") {
                        $fechaactual->setDate($fechaactual->format("Y"), $fechaactual->format("m"), 1);
                    } else {
                        $fechaactual->setDate($yearCurrentView, $monthCurrentView, 1);
                    }
                    $fechaactual->modify('+ ' . $mes  . ' month');
                }


                $cmdAltaColegiado = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona AS  p
                INNER JOIN Ingreso AS i ON i.idDNI = p.idDNI
                INNER JOIN Cuota as c on c.idIngreso = i.idIngreso
                WHERE i.idDNI = ? ");
                $cmdAltaColegiado->bindParam(1, $idDni, PDO::PARAM_INT);
                $cmdAltaColegiado->execute();
                if ($cmdAltaColegiado->fetch()) {
                    if ($fechaactual >= $date) {
                        $inicio = $date->modify('+ 1 month');
                        if ($inicio <= $fechaactual) {
                            while ($inicio <= $fechaactual) {
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT 
                                co.idConcepto,
                                co.Concepto,
                                co.Categoria,
                                co.Precio       
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();

                                while ($rowc = $cmdConceptos->fetch()) {
                                    $montodeuda += floatval($rowc["Precio"]);
                                }
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                } else {
                    if ($fechaactual >= $date) {
                        $inicio = $date;
                        if ($inicio <= $fechaactual) {

                            while ($inicio <= $fechaactual) {
                                $inicioFormat = $inicio->format('Y') . '-' . $inicio->format('m') . '-' . $inicio->format('d');

                                $cmdConceptos = Database::getInstance()->getDb()->prepare("SELECT 
                                co.idConcepto,
                                co.Concepto,
                                co.Categoria,
                                co.Precio       
                                FROM Concepto as co
                                WHERE Categoria = ? and ? between Inicio and Fin");
                                $cmdConceptos->bindParam(1, $condicion, PDO::PARAM_INT);
                                $cmdConceptos->bindParam(2, $inicioFormat, PDO::PARAM_STR);
                                $cmdConceptos->execute();

                                while ($rowc = $cmdConceptos->fetch()) {
                                    $montodeuda += floatval($rowc["Precio"]);
                                }
                                $inicio->modify('+ 1 month');
                            }
                        }
                    }
                }
            }

            return array("state" => 1, "persona" => $resultInformacion, "email" => $email, "deuda" => $montodeuda);
        } catch (Exception $ex) {
            return array("state" => 0, "message" => "Error de conexión del servidor, intente nuevamente en un par de minutos.");
        }
    }

    /**
     * 
     */
    public static function valCipPerfil($request)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();
            $user = Database::getInstance()->getDb()->prepare("SELECT * FROM Persona WHERE CIP = ?");
            $user->bindParam(1, $request->cip, PDO::PARAM_STR);
            $user->execute();

            $object = $user->fetchObject();
            if ($object) {
                if ($object->Clave == null || $object->Clave === "") {
                    Database::getInstance()->getDb()->rollBack();
                    return Response::sendClient("Usted tiene que crear una cuenta para continuar por favor.");
                } else {
                    $random = rand(1000, 9999);
                    $time = 10;

                    $token = Database::getInstance()->getDb()->prepare("INSERT INTO Token(Codigo,Fecha,Hora,Tiempo)VALUES(?,CAST(GETDATE() AS DATE),CAST(GETDATE() AS TIME),?)");
                    $token->bindParam(1, $random, PDO::PARAM_STR);
                    $token->bindParam(2, $time, PDO::PARAM_INT);
                    $token->execute();

                    $email = Database::getInstance()->getDb()->prepare("SELECT TOP 1 Direccion FROM Web WHERE idDNI = ?");
                    $email->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                    $email->execute();
                    $resultEmail = $email->fetchObject();

                    if ($resultEmail) {
                        $mail = new PHPMailer(true);
                        $fromname = "Informática Colegio de Ingenieros del Perú - CD Junín";
                        $fromEmail = "cipjunin@cip-junin.org.pe";

                        $mail->isSMTP();
                        $mail->CharSet = 'UTF-8';
                        $mail->SMTPDebug = 0;
                        $mail->Host       = 'smtp-mail.outlook.com.';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = $fromEmail;
                        $mail->Password   = 'Soporte2022';
                        $mail->SMTPSecure = "TLS";
                        $mail->Port       = 587;
                        $mail->setFrom($fromEmail, $fromname);
                        $mail->addAddress($resultEmail->Direccion);
                        $mail->AddEmbeddedImage("../../view/images/logologin.png", 'logoCip');

                        $mail->isHTML(true);
                        $mail->Subject = 'Código de Verificación Colegio de Ingenieros del Perú - CD Junín';
                        $mail->Body = '<html>
                                            <head>
                                                <meta charset="utf-8">
                                            </head>
                                            <body>
                                                <table style="background:#ECECEC; padding-top:25px;padding-bottom:25px;border-radius:20px;">
                                                    <tr style="width:100%;">
                                                        <td style="width:20%;"></td>
                                                        <td style="width:60%; font-size:18px; font-weight:bold;text-align: center;">
                                                            <img src="cid:logoCip" style="width:80px;" />
                                                            <h2> COLEGIO DE INGENIEROS DEL PERÚ - CD Junín</h2>
                                                        </td>
                                                        <td style="width:20%;"></td>
                                                    </tr>
                                                    <tr style="width:100%;">
                                                        <td style="width:20%;"></td>
                                                        <td style="width:60%; font-size:18px; ">Código de verificación</td>
                                                        <td style="width:20%;"></td>
                                                    </tr>
                                                    <tr style="width:100%; padding-top: 20px;">
                                                        <td style="width:20%;"></td>
                                                        <td style="width:60%; font-size:22px;text-align: center; font-weight: bold;">' . $random . '</td>
                                                        <td style="width:20%;"></td>
                                                    </tr>
                                                </table>
                                            </body>
                                        </html>';
                        $mail->send();
                    } else {
                        Database::getInstance()->getDb()->rollBack();
                        return Response::sendClient("No tiene registrado un correo electrónico, comuníquese con el área de sistema del CIP-JUNIN.");
                    }

                    Database::getInstance()->getDb()->commit();
                    $idToken = Database::getInstance()->getDb()->lastInsertId();

                    return Response::sendSave([
                        'message' => "Se generó el código de verificación.",
                        'user' => $object,
                        'token' => $idToken
                    ]);
                }
            } else {
                Database::getInstance()->getDb()->rollBack();
                return Response::sendClient("Detectamos que usted no se encuentra registrado.");
            }
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        }
    }
    /**
     * 
     */
    public static function valCodPerfil($request)
    {
        try {
            $user = Database::getInstance()->getDb()->prepare("SELECT * FROM 
            Token 
            WHERE 
            Codigo = ? 
            AND Fecha = CAST(GETDATE() AS DATE) 
            AND DATEADD(MINUTE, 10, Hora) >= CAST(GETDATE() AS TIME) 
            AND IdToken = ?");
            $user->bindParam(1, $request->code, PDO::PARAM_STR);
            $user->bindParam(2, $request->idToken, PDO::PARAM_STR);
            $user->execute();

            $objectUser = $user->fetchObject();
            if ($objectUser) {
                return Response::sendSuccess("El código se valido correctamente.");
            } else {
                return Response::sendClient("El código no existe o ha expirado.");
            }
        } catch (PDOException $ex) {
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        }
    }
    /**
     * 
     */
    public static function valSavePerfil($request)
    {
        try {
            Database::getInstance()->getDb()->beginTransaction();

            $update = Database::getInstance()->getDb()->prepare("UPDATE Persona SET Clave = ? WHERE idDNI = ?");
            $update->execute(array(
                password_hash($request->password, PASSWORD_DEFAULT),
                $request->idDNI
            ));

            Database::getInstance()->getDb()->commit();
            return Response::sendSave("Se guardo correctamente su contraseña, ahora puede ingresar al sistema usando su n° cip y su clave.");
        } catch (PDOException $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            Database::getInstance()->getDb()->rollBack();
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        }
    }

    /**
     * 
     */
    public static function valHabPerfil($request)
    {
        try {

            $cmdPersona = Database::getInstance()->getDb()->prepare("SELECT 
            p.idDNI, 
            p.NumDoc,
            p.Nombres, 
            p.Apellidos, 
            p.CIP, 
            CASE p.Condicion
            WHEN 'T' THEN 'Transeunte'
            WHEN 'F' THEN 'Fallecido'
            WHEN 'R' THEN 'Retirado'
            WHEN 'V' THEN 'Vitalicio'
            ELSE 'Ordinario' END AS Condicion, 
            CONVERT(VARCHAR,CAST(c.FechaColegiado AS DATE), 103) AS FechaColegiado,
            CASE
            WHEN CAST (DATEDIFF(M,DATEADD(MONTH,CASE p.Condicion WHEN 'O' THEN 3 WHEN 'V' THEN 9 ELSE 0 END,ISNULL(ul.FechaUltimaCuota, c.FechaColegiado)) , GETDATE()) AS INT) <=0 THEN 'Habilitado'
            ELSE 'No Habilitado' END AS Habilidad
            FROM Persona AS p
            INNER JOIN Colegiatura AS c ON c.idDNI = p.idDNI AND c.Principal = 1
            LEFT OUTER JOIN ULTIMACuota AS ul ON ul.idDNI = p.idDNI
            WHERE 
            p.CIP = ?
            OR
            p.NumDoc = ?
            OR
            CONCAT(p.Apellidos,' ',p.Nombres) = ?");
            $cmdPersona->bindParam(1, $request->search, PDO::PARAM_STR);
            $cmdPersona->bindParam(2, $request->search, PDO::PARAM_STR);
            $cmdPersona->bindParam(3, $request->search, PDO::PARAM_STR);
            $cmdPersona->execute();
            $object = $cmdPersona->fetchObject();
            if ($object) {
                $cmdImage = Database::getInstance()->getDb()->prepare("SELECT TOP 1 
                idDNI,Foto
                FROM PersonaImagen WHERE idDNI = ?");
                $cmdImage->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdImage->execute();
                $image = null;

                if ($row = $cmdImage->fetch()) {
                    $image = (object)array($row['idDNI'], base64_encode($row['Foto']));
                }

                $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT 
                ISNULL(ca.Capitulo,'CAPITULO NO REGISTRADO') AS Capitulo, 
                UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad,
                convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, 
                c.Principal 
                FROM Colegiatura  AS c
                LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
                LEFT JOIN Capitulo AS ca ON ca.idCapitulo = e.idCapitulo
                WHERE idDNI = ?
                ORDER BY c.FechaColegiado ASC");
                $cmdColegiatura->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdColegiatura->execute();

                $colegiaturas = $cmdColegiatura->fetchAll(PDO::FETCH_OBJ);

                $cmdCorreo = Database::getInstance()->getDb()->prepare("SELECT
                ISNULL(t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
                UPPER(w.Direccion) AS Direccion 
                FROM Web AS w 
                INNER JOIN Tipos AS t ON t.idTipo = w.Tipo 
                WHERE idDNI = ?");
                $cmdCorreo->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdCorreo->execute();
                $correos =  $cmdCorreo ->fetchAll(PDO::FETCH_OBJ);

                $cmdTelefono = Database::getInstance()->getDb()->prepare("SELECT
                ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, 
                a.Telefono 
                FROM Telefono AS a 
                LEFT JOIN Tipos AS t ON t.idTipo = a.Tipo 
                WHERE a.idDNI = ?");
                $cmdTelefono->bindParam(1, $object->idDNI, PDO::PARAM_STR);
                $cmdTelefono->execute();
                $telefonos = $cmdTelefono->fetchAll(PDO::FETCH_OBJ);

                return Response::sendSuccess(array(
                    "persona" => $object,
                    "image" => $image,
                    "colegiaturas" => $colegiaturas,
                    "correos" => $correos,
                    "telefonos" => $telefonos
                ));
            } else {
                return Response::sendClient("Datos no encontrados.");
            }
        } catch (PDOException $ex) {
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        } catch (Exception $ex) {
            return Response::sendError("Se produjo un error interterno, intente nuevamente en un par de minutos.");
        }
    }
}
