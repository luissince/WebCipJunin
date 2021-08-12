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

            return array(
                "state" => 1,
                "persona" => $resultPerfil,
                "image" => $image,
                "colegiatura" => $resultColegiatura,
                "domicilio" => $resultDomicilio
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
