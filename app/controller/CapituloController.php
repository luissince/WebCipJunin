<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\CapituloAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $especialidades = CapituloAdo::getAllEspecialidades($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($especialidades)) {
            echo json_encode(array(
                "estado" => 1,
                "especialidades" => $especialidades[0],
                "total" => $especialidades[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $especialidades
            ));
        }
    } else if ($_GET["type"] === "allCapitulos") {
        $capitulos = CapituloAdo::getAllDistinctCapitulos();
        if (is_array($capitulos)) {
            echo json_encode(array(
                "estado" => 1,
                "capitulos" => $capitulos,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $capitulos
            ));
        }
    } else if ($_GET["type"] === "allEspecialidades"){
        $especialidades = CapituloAdo::getAllEspecialidadesByCapitulo($_GET["idCapitulo"] );
        if (is_array($especialidades)) {
            echo json_encode(array(
                "estado" => 1,
                "especialidades" => $especialidades,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $especialidades
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insertCapitulo") {
        $capitulos["capitulo"] = strtoupper($_POST["capitulo"]);

        $result = CapituloAdo::insertCapitulo($capitulos);

        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registró correctamente el capítulo."
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El capítulo ".$capitulos["capitulo"]." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" =>$result
            ));
        }
    } else if ($_POST["type"] === "insertEspecialidad") {
        $especialidad["capitulo"] = $_POST["capitulo"];
        $especialidad["especialidad"] = $_POST["especialidad"];

        $result = CapituloAdo::insertEspecialidad($especialidad);

        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registró correctamente la especialidad."
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "La especialidad ".$especialidad["especialidad"]." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] === "updateCapitulo"){
        $capitulo["idCapitulo"] = $_POST["idcapitulo"];
        $capitulo["Capitulo"] = $_POST["capitulo"];

        $result = CapituloAdo::updateCapitulo($capitulo);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente el capítulo."
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El capitulo ".$capitulo["Capitulo"]." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    } else if ($_POST["type"] === "updateEspecialidad"){
        $especialidad["idCapitulo"] = $_POST["idCapitulo"];
        $especialidad["idEspecialidad"] = $_POST["idEspecialidad"];
        $especialidad["Especialidad"] = $_POST["especialidad"];

        $result = CapituloAdo::updateEspecialidad($especialidad);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente la especialidad."
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "La especialidad ".$especialidad["Especialidad"]." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result
            ));
        }
    }else if($_POST["type"] === "deleteCapitulo"){

        $result = CapituloAdo::deleteCapitulo($_POST["idCapitulo"]);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminó correctamente el capítulo."
            ));
        } else if ($result == "especialidad") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se puede elimar el capítulo porque tiene ligado especialidades."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }

    }else if($_POST["type"] === "deleteEspecialidad"){

        $result = CapituloAdo::deleteEspecialidad($_POST["idEspecialidad"]);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminó correctamente la especialidad."
            ));
        } else if ($result == "colegiatura") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se puede elimar la especialidad porque esta ligada a una colegiatura."
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
