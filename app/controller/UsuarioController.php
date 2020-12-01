<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
include_once '../model/UsuarioAdo.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "alldata") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];

        $usuario = UsuarioAdo::getAllUsuarios($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($usuario)) {
            echo json_encode(array(
                "estado" => 1,
                "usuarios" => $usuario[0],
                "total" => $usuario[1]
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $usuario
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if($_POST["type"] === "insertUsuario"){
        $usuario["nombres"] = trim($_POST['nombres']);
        $usuario["apellidos"] = trim($_POST['apellidos']);
        $usuario["usuarios"] = trim($_POST['usuarios']);
        $usuario["contrasena"] = $_POST['contrasena'];

        $result = UsuarioAdo::insertUsuario($usuario);
        
        if ($result == "insertado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El usuario ". $usuario["nombres"] ." ". $usuario["apellidos"] ." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === 'updateUsuario') {
        $usuario["idusuario"] = $_POST['idusuario'];
        $usuario["nombres"] = trim($_POST['nombres']);
        $usuario["apellidos"] = trim($_POST['apellidos']);
        $usuario["usuarios"] = trim($_POST['usuario']);
        $usuario["contrasena"] = $_POST['contrasena'];

        $result = UsuarioAdo::updateUsuario($usuario);
        
        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se actualizaron correctamente los datos"
            ));
        } else if ($result == "duplicado") {
            echo json_encode(array(
                "estado" => 3,
                "message" => "El usuario ". $usuario["nombres"] ." ". $usuario["apellidos"] ." ya se encuentra registrado."
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => "Error al tratar de actualizar los datos " . $result
            ));
        }
    } else if ($_POST["type"] === 'deleteUsuario') {
        $usuario["idusuario"] = $_POST['idUsuario'];

        $result = UsuarioAdo::deleteUsuario($usuario);
        
        if ($result == "actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos"
            ));
        } else if ($result == "sistema") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "El usuario es propio del sistema; no se puede eliminar"
            ));
        } else if($result == "activo"){
            echo json_encode(array(
                "estado" => 3,
                "message" => "No se puede eliminar; el usuario esta activo"
            ));
        }else{
            echo json_encode(array(
                "estado" => 0,
                "message" => "Error al tratar de eliminar los datos " . $result
            ));
        }
    }
}