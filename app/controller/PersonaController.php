<?php
//error_reporting(0);

use function PHPSTORM_META\type;

date_default_timezone_set('America/Lima');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
require '../model/PersonaAdo.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAll($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($personas)) {
            echo json_encode(array(
                "estado" => 1,
                "personas" => $personas[0],
                "total" => $personas[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $personas
            ));
        }
    } else if ($_GET["type"] === "data") {
        $persona = PersonaAdo::getId($_GET["dni"]);
        if (is_object($persona)) {
            echo json_encode(array(
                "estado" => 1,
                "object" => $persona
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $persona
            ));
        }
    } else if ($_GET["type"] === "listdata") {
        $search = $_GET["search"];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $personas = PersonaAdo::getAllModal($search, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($personas)) {
            echo json_encode(array(
                "estado" => 1,
                "personas" => $personas[0],
                "total" => $personas[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $personas
            ));
        }
    } else if ($_GET["type"] === "getcolegiatura") {
        $arrayColegiaturas =  PersonaAdo::getColegiatura($_GET['idDni']);

        if (is_array($arrayColegiaturas)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getColegiatura($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayColegiaturas
            ));
        }
    } else if ($_GET["type"] === "getdomicilio") {
        $arrayDomicilio = PersonaAdo::getDomicilio($_GET['idDni']);

        if (is_array($arrayDomicilio)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getDomicilio($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayDomicilio
            ));
        }
    } else if ($_GET["type"] === 'gettelefono') {
        $arrayTelefono = PersonaAdo::getTelefono($_GET['idDni']);

        if (is_array($arrayTelefono)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getTelefono($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayTelefono
            ));
        }
    } else if ($_GET["type"] === 'getconyuge') {
        $arrayConyuge = PersonaAdo::getConyuge($_GET['idDni']);

        if (is_array($arrayConyuge)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getConyuge($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayConyuge
            ));
        }
    } else if ($_GET["type"] === 'getexperiencia') {
        $arrayExperiencia = PersonaAdo::getExperiencia($_GET['idDni']);

        if (is_array($arrayExperiencia)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => $arrayExperiencia,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayExperiencia
            ));
        }
    } else if ($_GET["type"] === 'getgradosyestudios') {
        $arraygradosyestudios = PersonaAdo::getGradosyEstudios($_GET['idDni']);

        if (is_array($arraygradosyestudios)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getGradosyEstudios($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arraygradosyestudios
            ));
        }
    } else if ($_GET["type"] === 'getcorreoyweb') {
        $arrayCorreoyWeb = PersonaAdo::getCorreoyWeb($_GET['idDni']);

        if (is_array($arrayCorreoyWeb)) {
            echo json_encode(array(
                "estado" => 1,
                "data" => PersonaAdo::getCorreoyWeb($_GET['idDni']),
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayCorreoyWeb
            ));
        }
    } else if ($_GET["type"] === 'getaddcolegiatura') {
        $arrayAddColegiatura = PersonaAdo::getaddcolegiatura();

        if (is_array($arrayAddColegiatura)) {
            echo json_encode(array(
                "estado" => 1,
                "sedes" => $arrayAddColegiatura[0],
                "espacialidades" => $arrayAddColegiatura[1],
                "universidades" => $arrayAddColegiatura[2],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayAddColegiatura
            ));
        }
    } else if ($_GET["type"] === 'getadddomicilio') {
        $arrayAddDomicilio = PersonaAdo::getAddDomicilio();

        if (is_array($arrayAddDomicilio)) {
            echo json_encode(array(
                "estado" => 1,
                "tipodomicilio" => $arrayAddDomicilio[0],
                "ubicacion" => $arrayAddDomicilio[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayAddDomicilio
            ));
        }
    } else if ($_GET["type"] === 'getaddcelular') {
        $arrayaddcelular = PersonaAdo::getAddCelular();

        if (is_array($arrayaddcelular)) {
            echo json_encode(array(
                "estado" => 1,
                "tipo" => $arrayaddcelular,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayaddcelular
            ));
        }
    } else if ($_GET["type"] === 'getaddestudios') {
        $arrayEstudios = PersonaAdo::getAddEstudios();

        if (is_array($arrayEstudiosqw       wwwwwq  1)) {
            echo json_encode(array(
                "estado" => 1,
                "tipodomicilio" => $arrayAddDomicilio[0],
                "ubicacion" => $arrayAddDomicilio[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $arrayAddDomicilio
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] == "update") {
        $persona["dni"] = $_POST["dni"];
        $persona["nombres"] = $_POST["nombres"];
        $persona["apellidos"] = $_POST["apellidos"];
        $persona["sexo"] = $_POST["sexo"];
        $persona["nacimiento"] = $_POST["nacimiento"];
        $persona["estado_civil"] = $_POST["estado_civil"];
        $persona["ruc"] = $_POST["ruc"];
        $persona["rason_social"] = $_POST["rason_social"];
        $persona["cip"] = $_POST["cip"];
        $persona["condicion"] = $_POST["condicion"];

        $result = PersonaAdo::update($persona);
        if ($result == "updated") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizo correctamente los datos."
            ));
        } else if ($result == "noexists") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "El dni no existe o fue modificado para poder actualizar los datos."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result,
                "value" => $persona["nacimiento"]
            ));
        }
    } else if ($_POST["type"] == "create") {
        $persona["dni"] = $_POST["dni"];
        $persona["nombres"] = $_POST["nombres"];
        $persona["apellidos"] = $_POST["apellidos"];
        $persona["sexo"] = $_POST["sexo"];
        $persona["nacimiento"] = $_POST["nacimiento"];
        $persona["estado_civil"] = $_POST["estado_civil"];
        $persona["ruc"] = $_POST["ruc"];
        $persona["rason_social"] = $_POST["rason_social"];
        $persona["cip"] = $_POST["cip"];
        $persona["condicion"] = $_POST["condicion"];

        $result = PersonaAdo::insert($persona);
        if ($result == "create") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertarron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    }
}
