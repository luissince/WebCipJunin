<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

require '../database/DataBaseConexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);
    $idDni = $body["idDni"];
    echo json_encode(Perfil::getPersonaPerfil($idDni));
    exit;
}

class Perfil
{

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
}



// $body = json_decode(file_get_contents("php://input"), true);
// $postdata = http_build_query(
//     array(
//         'idDni' => $body["idDni"],
//     )
// );
// $opts = array(
//     'http' =>
//     array(
//         'method'  => 'POST',
//         'header'  => 'Content-Type: application/x-www-form-urlencoded',
//         'content' => $postdata
//     )
// );

// $context  = stream_context_create($opts);
// $data = file_get_contents('http://localhost:5000/api/perfil', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);
