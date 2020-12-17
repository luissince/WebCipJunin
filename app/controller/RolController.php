<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/RolAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombre = $_GET['nombre'];

        $rol = RolAdo::getAllRoles($nombre);
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
    }else if($_GET["type"] === "modulos"){
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
    }

} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "insertRol") {
        $rol["Nombre"] = trim($_POST['Nombre']);
        $rol["Descripcion"] = trim($_POST['Descripcion']);
        $rol["Estado"] = $_POST['Estado'];

        $result = RolAdo::insertRol($rol);
        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se registraron correctamente los datos",
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
    } else if ($_POST["type"] === 'updateRol') {
        $rol["idRol"] = $_POST['idRol'];
        $rol["Nombre"] = trim($_POST['Nombre']);
        $rol["Descripcion"] = trim($_POST['Descripcion']);
        $rol["Estado"] = $_POST['Estado'];

        $result = RolAdo::updateRol($rol);
        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos",
            ));
        } else if ($result == "sistema") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "Ya existe un rol preterminado del sistema",
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result,
            ));
        }
    } 

    /*
    else if ($_POST["type"] === 'deleteUsuario') {
        $usuario["idusuario"] = $_POST['idUsuario'];

        $result = UsuarioAdo::deleteUsuario($usuario);

        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos",
            ));
        } else if ($result == "sistema") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "El usuario es propio del sistema; no se puede eliminar",
            ));
        } else if ($result == "activo") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "No se puede eliminar; el usuario esta activo",
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => "Error al tratar de eliminar los datos " . $result,
            ));
        }
    }
    */

}
