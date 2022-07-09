<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\UniversidadAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $universidad = UniversidadAdo::getAllUniversidades($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($universidad)) {
            echo json_encode(array(
                "estado" => 1,
                "universidades" => $universidad[0],
                "total" => $universidad[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $universidad
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insertUniversidad") {
        $universidad["universidad"] = strtoupper($_POST["universidad"]);
        $universidad["siglas"] = strtoupper($_POST["siglas"]);

        $result = UniversidadAdo::insertUniversidad($universidad);

        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "La universidad " . $universidad["universidad"] . " ya se encuentra registrada."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de registrar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "updateUniversidad") {
        $universidad["idUniversidad"] = $_POST["iduniversidad"];
        $universidad["universidad"] = strtoupper($_POST["universidad"]);
        $universidad["siglas"] = strtoupper($_POST["siglas"]);

        $result = UniversidadAdo::updateUniversidad($universidad);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "La universidad " . $universidad["universidad"] . " ya se encuentra registrada."
            ));
            // } else if ($result == "duplicadosiglas") {
            //     echo json_encode(array(
            //         "estado" => 4,
            //         "message" => "Las siglas ".$universidad["siglas"]." ya se encuentra registrada."
            //     ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "deleteUniversidad") {
        $universidad["idUniversidad"] = $_POST["iduniversidad"];

        $result = UniversidadAdo::deleteUniversidad($universidad);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminó correctamente la universidad."
            ));
        } else if ($result == "colegiatura") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se puede eliminar la universidad porque está ligada a una colegiatura."
            ));
        } else if ($result == "grado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "No se puede eliminar la universidad porque está ligada a un grado y estudios."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
