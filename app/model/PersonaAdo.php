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

    public static function getAllModal($search, $posicionPagina, $filasPorPagina)
    {
        try {
            $array = array();
            $arrayPersonas = array();
            $comandoPersona = Database::getInstance()->getDb()->prepare("SELECT  
            dbo.Especialidad.Capitulo,
            dbo.Especialidad.Especialidad,
            CASE CIP
            WHEN 'T' THEN 'Tramite'
            ELSE CIP END
            AS Cip,
            dbo.Persona.idDNI as Dni,
            dbo.Persona.Apellidos + ', ' + dbo.Persona.Nombres AS Ingeniero,
            convert(varchar,cast(dbo.Colegiatura.FechaColegiado as date), 103) as FechaColegiado,
            case dbo.Persona.Condicion
            when 'T' then 'Transeunte'
            when 'F' then 'Fallecido'
            when 'R' then 'Retirado'
            when 'V' then 'Vitalicio'
            else 'Ordinario' 
            end as Condicion,
            convert(varchar,cast(ISNULL(dbo.ULTIMACuota.FechaUltimaCuota,dbo.Colegiatura.FechaColegiado) as date), 103) AS FechaUltimaCuota,
            CASE dbo.Persona.Condicion
            WHEN 'T' THEN 0
            ELSE DATEDIFF(M, ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado), GETDATE())
            END
            AS Deuda,
            case
            when CAST (DATEDIFF(M,ISNULL(dbo.ULTIMACuota.FechaUltimaCuota, dbo.Colegiatura.FechaColegiado) , GETDATE()) as int) <=0 then 'Habilitado'
            else 'No Habilitado'
            end as Habilidad
            FROM dbo.Persona
            LEFT OUTER JOIN
                 dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI
                 AND dbo.Colegiatura.Principal = 1
                 INNER JOIN
                 dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
                 LEFT OUTER JOIN
                 dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
            where 
            dbo.Persona.idDNI = ? 
            or dbo.Persona.CIP = ? 
            or dbo.Persona.Apellidos like concat(?,'%')
            or dbo.Persona.Nombres like concat(?,'%')
            order by dbo.Persona.Apellidos asc
            offset ? rows fetch next ? rows only");
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
                    "Id" => $count + $posicionPagina,
                    "Capitulo" => $row["Capitulo"],
                    "Especialidad" => $row["Especialidad"],
                    "Cip" => $row["Cip"],
                    "Dni" => $row["Dni"],
                    "Ingeniero" => $row["Ingeniero"],
                    "FechaColegiado" => $row["FechaColegiado"],
                    "Condicion" => $row["Condicion"],
                    "FechaUltimaCuota" => $row["FechaUltimaCuota"],
                    "Deuda" => $row["Deuda"],
                    "Habilidad" => $row["Habilidad"]
                ));
            }

            $comandoTotal = Database::getInstance()->getDb()->prepare("SELECT COUNT(*) FROM dbo.Persona
             LEFT OUTER JOIN
                  dbo.Colegiatura ON dbo.Colegiatura.idDNI = dbo.Persona.idDNI
                  AND dbo.Colegiatura.Principal = 1
                  INNER JOIN
                  dbo.Especialidad ON dbo.Especialidad.idEspecialidad = dbo.Colegiatura.idEspecialidad
                  LEFT OUTER JOIN
                  dbo.ULTIMACuota ON dbo.ULTIMACuota.idDNI = dbo.Persona.idDNI
                  WHERE dbo.Persona.idDNI = ? 
                  or dbo.Persona.CIP = ? 
                  or dbo.Persona.Apellidos like concat(?,'%')
                  or dbo.Persona.Nombres like concat(?,'%')");
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
            } else {
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

    public static function getColegiatura($idDni){
        try {
            $cmdColegiatura = Database::getInstance()->getDb()->prepare("SELECT s.Consejo,ISNULL(e.Capitulo,'CAPITULO NO REGISTRAD0') AS Capitulo,UPPER(ISNULL(e.Especialidad,'ESPECIALIDAD NO REGISTRADA')) AS Especialidad, 
			convert(VARCHAR,cast(c.FechaColegiado AS DATE),103) AS FechaColegiado, ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS UnivesidadEgreso, convert(VARCHAR,cast(c.FechaEgreso AS DATE),103) AS FechaEgreso, 
			ISNULL(u.Universidad,'UNIVERSIDAD NO REGISTRADA') AS Universidad, convert(VARCHAR,cast(c.FechaTitulacion AS DATE),103) AS FechaTitulacion, 
            c.Resolucion, c.Principal FROM Colegiatura  AS c
			LEFT JOIN Sede AS s ON c.idSede = s.idConsejo
			LEFT JOIN Especialidad AS e ON e.idEspecialidad = c.idEspecialidad
			LEFT JOIN Universidad AS u ON u.idUniversidad = c.idUniversidad
			where idDNI = ? ");
            $cmdColegiatura->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdColegiatura->execute();

            $arrayColegiaturas = array();

            $count = 0;
            while ($row = $cmdColegiatura->fetch()) {
                $count++;
                array_push($arrayColegiaturas, array(
                    'Id' => $count,
                    'sede' => $row['Consejo'],
                    'capitulo' => 'Capitulo',
                    'especialidad' => $row['Especialidad'],
                    'fechaColegiado' => $row['FechaColegiado'],
                    'universidadEgreso' => $row['UnivesidadEgreso'],
                    'fechaEgreso' => $row['FechaEgreso'],
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

    public static function getDomicilio($idDni){
        try{
            $cmdDomicilio = Database::getInstance()->getDb()->prepare("SELECT ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, UPPER(d.Direccion) AS Direccion, 
            ISNULL (u.Departamento,'DEPARTAMENTO NO REGISTRADA') AS Ubigeo FROM Direccion AS d 
            LEFT JOIN Tipos AS t ON t.idTipo = d.Tipo 
            LEFT JOIN Ubigeo AS u ON u.idUbigeo = d.Ubigeo
            WHERE d.idDNI = ?");
            $cmdDomicilio->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdDomicilio->execute();

            $arrayDomicilios = array();

            $count = 0;
            while($row = $cmdDomicilio->fetch()){
                $count ++;
                array_push($arrayDomicilios, array(
                    'Id' => $count,
                    'tipo' => $row['Tipo'],
                    'direccion' => $row['Direccion'],
                    'ubigeo' => $row['Ubigeo'],
                ));
            }
            return $arrayDomicilios;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getTelefono($idDni){
        try{
            $cmdTelefono = Database::getInstance()->getDb()->prepare("SELECT ISNULL (t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo , a.Telefono FROM Telefono AS a 
            LEFT JOIN Tipos AS t ON t.idTipo = a.Tipo WHERE a.idDNI = ?");
            $cmdTelefono ->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdTelefono->execute();

            $arrayTelefonos = array();

            $count=0;
            while($row = $cmdTelefono->fetch()){
                $count++;
                array_push($arrayTelefonos, array(
                    'Id' => $count,
                    'tipo' => $row['Tipo'],
                    'numero' => $row['Telefono'],
                ));
            }
            return$arrayTelefonos;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getConyuge($idDni){
        try{
            $cmdConyuge = Database::getInstance()->getDb()->prepare("SELECT UPPER(FullName) AS NombreCompleto, NumHijos FROM Conyuge WHERE idDNI = ?");
            $cmdConyuge ->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdConyuge->execute();

            $arrayConyuge = array();

            $count=0;
            while($row = $cmdConyuge->fetch()){
                $count++;
                array_push($arrayConyuge, array(
                    'Id' => $count,
                    'NombreCompleto' => $row['NombreCompleto'],
                    'Hijos' => $row['NumHijos'],
                ));
            }
            return $arrayConyuge;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getExperiencia($idDni){
        try{
            $cmdExperiencia = Database::getInstance()->getDb()->prepare("SELECT UPPER(Entidad) AS Entidad, UPPER(ExpericienciaEn) AS  Experiencia,  
            CONVERT(VARCHAR,cast(FechaInicio AS DATE),103) AS FechaInicio, CONVERT(VARCHAR,cast(FechaFin AS DATE),103) AS FechaFin
             FROM Experiencia WHERE idPersona = ?");
            $cmdExperiencia ->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdExperiencia->execute();

            $arrayExperiencia = array();

            $count=0;
            while($row = $cmdExperiencia->fetch()){
                $count++;
                array_push($arrayExperiencia, array(
                    'Id' => $count,
                    'Entidad' => $row['Entidad'],
                    'Experiencia' => $row['Experiencia'],
                    'FechaInicio' => $row['FechaInicio'],
                    'FechaFin' => $row['FechaFin'],
                ));
            }
            return $arrayExperiencia;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getGradosyEstudios($idDni){
        try{
            $cmdgradosyestudios = Database::getInstance()->getDb()->prepare("SELECT UPPER(t.Descripcion) AS Grado, UPPER(Materia) AS Materia, ISNULL(u.Universidad, 'UNIVERSIDAD NO REGISTRADA') AS Universidad, 
            CONVERT(VARCHAR, cast(g.FechaGrado AS DATE), 103) AS Fecha FROM Grados AS g LEFT JOIN Universidad AS u ON u.idUniversidad = g.idUniversidad
            LEFT JOIN Tipos AS t ON t.idTipo = g.Grado AND t.Categoria = 'D'
            WHERE g.idDNI = ?");
            $cmdgradosyestudios ->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdgradosyestudios->execute();

            $arraygradosyestudios = array();

            $count=0;
            while($row = $cmdgradosyestudios->fetch()){
                $count++;
                array_push($arraygradosyestudios, array(
                    'Id' => $count,
                    'Grado' => $row['Grado'],
                    'Materia' => $row['Materia'],
                    'Universidad' => $row['Universidad'],
                    'Fecha' => $row['Fecha'],
                ));
            }
            return $arraygradosyestudios;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getCorreoyWeb($idDni){
        try{
            $cmdcorreoyweb = Database::getInstance()->getDb()->prepare("SELECT ISNULL(t.Descripcion, 'TIPO NO REGISTRADO') AS Tipo, UPPER(w.Direccion) AS Direccion from Web AS w 
            INNER JOIN Tipos AS t ON t.idTipo = w.Tipo WHERE idDNI = ?");
            $cmdcorreoyweb ->bindParam(1, $idDni, PDO::PARAM_STR);
            $cmdcorreoyweb->execute();

            $arraycorreoyweb = array();

            $count=0;
            while($row = $cmdcorreoyweb->fetch()){
                $count++;
                array_push($arraycorreoyweb, array(
                    'Id' => $count,
                    'Tipo' => $row['Tipo'],
                    'Direccion' => $row['Direccion'],
                ));
            }
            
            return $arraycorreoyweb;
        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getaddcolegiatura(){
        try{
            $arrayAddColegiatura = array();

            $cmdsede = Database::getInstance()->getDb()->prepare("SELECT idConsejo ,UPPER(Consejo) AS Consejo from Sede");
            $cmdsede->execute();
            $arraySede = array();
            while($row = $cmdsede->fetch()){
                array_push($arraySede, array(
                    'IdConsejo' => $row['idConsejo'],
                    'Sede' => $row['Consejo'],
                ));
            }

            $cmdEspecialidad = Database::getInstance()->getDb()->prepare("SELECT idEspecialidad, UPPER (Especialidad) AS Especialidad from Especialidad");
            $cmdEspecialidad->execute();
            $arrayEspecialidad = array();
            while($row = $cmdEspecialidad->fetch()){
                array_push($arrayEspecialidad, array(
                    'IdEspecialidad' => $row['idEspecialidad'],
                    'Especialidad' => $row['Especialidad'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while($row = $cmdUniversidad->fetch()){
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }
            
            array_push($arrayAddColegiatura,$arraySede, $arrayEspecialidad, $arrayUniversidad);
            return $arrayAddColegiatura;

        } catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getAddDomicilio(){
        try{
            $arrayAddDomicilio = array();

            $cmdTipo = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'A'");
            $cmdTipo->execute();
            $arrayTipoDomicilio = array();
            while($row = $cmdTipo->fetch()){
                array_push($arrayTipoDomicilio, array(
                    'IdTipo' => $row['idTipo'],
                    'Descripcion' => $row['Descripcion']
                ));
            }

            $cmdUbicacion = Database::getInstance()->getDb()->prepare(" SELECT idUbigeo, CONCAT(Departamento, ' - ', Provincia, ' - ', 
            Distrito) AS Ubicacion FROM Ubigeo ");
            $cmdUbicacion->execute();
            $arrayUbicación = array();
            while($row = $cmdUbicacion->fetch()){
                array_push($arrayUbicación, array(
                    'IdUbicación' => $row['idUbigeo'],
                    'Ubicacion' => $row['Ubicacion'],
                ));
            }
            
            array_push($arrayAddDomicilio,$arrayTipoDomicilio, $arrayUbicación);
            return $arrayAddDomicilio;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getAddCelular(){
        try{
            $cmdCelular = Database::getInstance()->getDb()->prepare("SELECT idTipo, Descripcion FROM tipos WHERE Categoria = 'B'");
            $cmdCelular->execute();
            $arrayCelular = array();
            while($row = $cmdCelular->fetch()){
                array_push($arrayCelular, array(
                    'IdTipo' => $row['idTipo'],
                    'Tipo' => $row['Descripcion'],
                ));
            }
            return $arrayCelular;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }

    public static function getAddEstudios(){
        try{
            $arrayEstudios = array();

            $cmdgrado = Database::getInstance()->getDb()->prepare("SELECT idTipo, UPPER(Descripcion) AS Descripcion FROM tipos WHERE Categoria = 'D'");
            $cmdgrado->execute();
            $arrayGrado = array();
            while($row = $cmdgrado->fetch()){
                array_push($arrayGrado, array(
                    'IdGrado' => $row['idTipo'],
                    'Grado' => $row['Descripcion'],
                ));
            }

            $cmdUniversidad = Database::getInstance()->getDb()->prepare("SELECT idUniversidad, CONCAT(UPPER (Universidad),'  (',UPPER (siglas),')') AS Universidad from Universidad");
            $cmdUniversidad->execute();
            $arrayUniversidad = array();
            while($row = $cmdUniversidad->fetch()){
                array_push($arrayUniversidad, array(
                    'IdUniversidad' => $row['idUniversidad'],
                    'Universidad' => $row['Universidad'],
                ));
            }
            array_push($arrayEstudios,$arrayGrado,$arrayUniversidad);

            return $arrayEstudios;
        }catch(Exception $ex){
            return $ex->getMessage();
        }
    }
}
