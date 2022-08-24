<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\CursoAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $text = $_GET['text'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $curso = CursoAdo::getAll($text, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($curso)) {
            echo json_encode(array(
                "estado" => 1,
                "cursos" => $curso[0],
                "total" => $curso[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $curso
            ));
        }
    } else if($_GET["type"] === "id"){
        $result = CursoAdo::id($_GET['idCurso']);
        if(is_object($result)){
            echo json_encode(array(
                "estado" => 1,
                "object" => $result,
            ));
        }else{
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insert") {
        
        $curso["Nombre"] = $_POST["Nombre"];
        $curso["Instructor"] = $_POST["Instructor"];
        $curso["Organizador"] = $_POST["Organizador"];
        $curso["idCapitulo"] = $_POST["idCapitulo"];
        $curso["Modalidad"] = $_POST["Modalidad"];
        $curso["Direccion"] = $_POST["Direccion"];

        $curso["FechaInicio"] = $_POST["FechaInicio"];
        $curso["HoraInicio"] = $_POST["HoraInicio"];
        $curso["PrecioCurso"] = $_POST["PrecioCurso"];
        $curso["PrecioCertificado"] = $_POST["PrecioCertificado"];
        $curso["Celular"] = $_POST["Celular"];
        $curso["Correo"] = $_POST["Correo"];
        $curso["Descripcion"] = $_POST["Descripcion"];
        $curso["Estado"] = $_POST["Estado"];
        $curso["idUsuario"] = $_POST["idUsuario"];

        $result = CursoAdo::insert($curso);

        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se insertaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de registrar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "update") {

        $curso["Nombre"] = $_POST["Nombre"];
        $curso["Instructor"] = $_POST["Instructor"];
        $curso["Organizador"] = $_POST["Organizador"];
        $curso["idCapitulo"] = $_POST["idCapitulo"];
        $curso["Modalidad"] = $_POST["Modalidad"];
        $curso["Direccion"] = $_POST["Direccion"];

        $curso["FechaInicio"] = $_POST["FechaInicio"];
        $curso["HoraInicio"] = $_POST["HoraInicio"];
        $curso["PrecioCurso"] = $_POST["PrecioCurso"];
        $curso["PrecioCertificado"] = $_POST["PrecioCertificado"];
        $curso["Celular"] = $_POST["Celular"];
        $curso["Correo"] = $_POST["Correo"];
        $curso["Descripcion"] = $_POST["Descripcion"];
        $curso["Estado"] = $_POST["Estado"];
        $curso["idUsuario"] = $_POST["idUsuario"];
        $curso["idCurso"] = $_POST["idCurso"];

        $result = CursoAdo::update($curso);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === "delete") {

        $curso["idCurso"] = $_POST["idCurso"];

        $result = CursoAdo::delete($curso);

        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminó correctamente el curso."
            ));
        } else if ($result == "activo") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se pudo eliminar el curso por que tiene estado activo"
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => $result
            ));
        }
    }
}
