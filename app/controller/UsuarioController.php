<?php

namespace SysSoftIntegra\Controller;

use SysSoftIntegra\Model\UsuarioAdo;


class UsuarioController
{
    /**
     * GET
     */
    public static function alldata($body)
    {
        $nombres = $body['nombres'];
        $posicionPagina = $body['posicionPagina'];
        $filasPorPagina = $body['filasPorPagina'];

        UsuarioAdo::getAllUsuarios($nombres, intval($posicionPagina), intval($filasPorPagina));
    }

    /**
     * GET
     */
    public static function login($body)
    {

        UsuarioAdo::login($body["usuario"], $body["clave"]);
    }

    /**
     * GET
     */
    public static function usuario($body)
    {
        UsuarioAdo::getUsuarioById($body["idUsuario"]);
    }

    /**
     * GET
     */
    public static function listUsuario($body)
    {
        UsuarioAdo::listUsuarios($body["fInicio"], $body["fFinal"]);
    }

    /**
     * POST
     */
    public static function insertUsuario($body)
    {
        UsuarioAdo::insertUsuario($body);
    }

    /**
     * POST
     */
    public static function deleteUsuario($body)
    {
        UsuarioAdo::deleteUsuario($body);
    }

    /**
     * POST
     */
    public static function updatePerfil($body)
    {
        UsuarioAdo::updatePerfil($body["idUsuario"], $body["usuario"], $body["clave"]);
    }
}

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
// header('Content-Type: application/json; charset=UTF-8');

// use SysSoftIntegra\Model\UsuarioAdo;

// require __DIR__ . './../src/autoload.php';

// if ($_SERVER['REQUEST_METHOD'] == 'GET') {
//     if ($_GET["type"] === "alldata") {
//         $nombres = $_GET['nombres'];
//         $posicionPagina = $_GET['posicionPagina'];
//         $filasPorPagina = $_GET['filasPorPagina'];

//         $usuario = UsuarioAdo::getAllUsuarios($nombres, intval($posicionPagina), intval($filasPorPagina));
//         if (is_array($usuario)) {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "usuarios" => $usuario[0],
//                 "total" => $usuario[1],
//             ));
//         } else {
//             echo json_encode(array(
//                 "estado" => 2,
//                 "message" => $usuario,
//             ));
//         }
//     } else if ($_GET["type"] === "usuario") {
//         $result = UsuarioAdo::getUsuarioById($_GET['idUsuario']);
//         if (is_object($result)) {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "object" => $result,
//             ));
//         } else {
//             echo json_encode(array(
//                 "estado" => 2,
//                 "message" => $result,
//             ));
//         }
//     } else if ($_GET["type"] == "listUsuario") {
//         echo json_encode(UsuarioAdo::listUsuarios($_GET["fInicio"], $_GET["fFinal"]));
//     }
// } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     if ($_POST["type"] === "insertUsuario") {
//         $usuario["idusuario"] = trim($_POST['idusuario']);
//         $usuario["nombres"] = trim($_POST['nombres']);
//         $usuario["apellidos"] = trim($_POST['apellidos']);
//         $usuario["usuarios"] = trim($_POST['usuarios']);
//         $usuario["contrasena"] = $_POST['contrasena'];
//         $usuario["rol"] = $_POST['rol'];
//         $usuario["estado"] = $_POST['estado'];

//         $result = UsuarioAdo::insertUsuario($usuario);
//         if ($result == "insertado") {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "message" => "Se registraron correctamente los datos",
//             ));
//         } else if ($result == "actualizado") {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "message" => "Se actualizaron correctamente los datos",
//             ));
//         } else if ($result == "duplicado") {
//             echo json_encode(array(
//                 "estado" => 3,
//                 "message" => "El usuario " . $usuario["nombres"] . " " . $usuario["apellidos"] . " ya se encuentra registrado.",
//             ));
//         } else {
//             echo json_encode(array(
//                 "estado" => 2,
//                 "message" => "Error al tratar de actualizar los datos " . $result,
//             ));
//         }
//     } else if ($_POST["type"] === 'deleteUsuario') {
//         $usuario["idusuario"] = $_POST['idUsuario'];
//         $result = UsuarioAdo::deleteUsuario($usuario);
//         if ($result == "eliminado") {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "message" => "Se eliminaron correctamente el usuario.",
//             ));
//         } else if ($result == "sistema") {
//             echo json_encode(array(
//                 "estado" => 2,
//                 "message" => "El usuario es propio del sistema; no se puede eliminar.",
//             ));
//         } else if ($result == "activo") {
//             echo json_encode(array(
//                 "estado" => 3,
//                 "message" => "No se puede eliminar porque se encuentra activo.",
//             ));
//         } else if ($result == "ingreso") {
//             echo json_encode(array(
//                 "estado" => 4,
//                 "message" => "No se puede eliminar el usuario porque ligado ingresos.",
//             ));
//         } else {
//             echo json_encode(array(
//                 "estado" => 0,
//                 "message" =>  $result,
//             ));
//         }
//     } else if ($_POST["type"] == "updatePerfil") {
//         $result = UsuarioAdo::updatePerfil($_POST["idUsuario"], $_POST["usuario"], $_POST["clave"]);
//         if ($result == "update") {
//             echo json_encode(array(
//                 "estado" => 1,
//                 "message" =>  "Se actualizó correctamente los cambios.",
//             ));
//         } else {
//             echo json_encode(array(
//                 "estado" => 0,
//                 "message" =>  $result,
//             ));
//         }
//     }
// }
