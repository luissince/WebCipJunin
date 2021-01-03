<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/RolAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombre = $_GET['nombre'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $rol = RolAdo::getAllRoles($nombre, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($rol)) {
            echo json_encode(array(
                "estado" => 1,
                "roles" => $rol[0],
                "total" =>$rol[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $rol,
            ));
        }
    } else if ($_GET["type"] === "data") {
        $rol = RolAdo::getRolById($_GET["idRol"]);
        if (is_object($rol)) {
            echo json_encode(array(
                "estado" => 1,
                "object" => $rol
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $rol
            ));
        }
    } else if ($_GET["type"] === "modulos") {
        $modulos = RolAdo::getModulosByIdRol($_GET["idRol"]);
        if (is_array($modulos)) {
            echo json_encode(array(
                "estado" => 1,
                "modulos" => $modulos
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $modulos
            ));
        }
    } else  if ($_GET["type"] === "roles") {
        $rol = RolAdo::getRoles();
        if (is_array($rol)) {
            echo json_encode(array(
                "estado" => 1,
                "roles" => $rol
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $rol,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "crudRol") {
        $rol["IdRol"] = $_POST['IdRol'];
        $rol["Nombre"] = trim($_POST['Nombre']);
        $rol["Descripcion"] = trim($_POST['Descripcion']);
        $rol["Estado"] = $_POST['Estado'];

        $result = RolAdo::crudRol($rol);
        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registraron correctamente los datos",
            ));
        } else if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos",
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El rol " . $rol["Nombre"] . " ya se encuentra registrado.",
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de registrar los datos " . $result,
            ));
        }
    }else if($_POST["type"] === "deletedRol"){
        $result = RolAdo::deleteRol($_POST["idRol"]);
        if($result == "deleted"){
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eleminó correctamente el rol.",
            ));
        }else if($result == "usuario"){
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se pudo eliminar el rol, porque está asociado a un usuario.",
            ));
        }else{
            echo json_encode(array(
                "estado" => 0,
                "message" => $result,
            ));
        }
    }
}
