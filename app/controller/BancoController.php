<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\BancoAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_GET["type"] === "bancos") {
        $result = BancoAdo::getNombreBancos();
        if (is_array($result)) {
            print json_encode(array(
                "estado" => 1,
                "data" => $result
            ));
        } else {
            print json_encode(array(
                "estado" => 2,
                "mensaje" => $result
            ));
        }
    } else if ($_GET["type"] === "allBancos") {
        $nombres = $_GET['nombres'];
        $posicionPagina = $_GET['posicionPagina'];
        $filasPorPagina = $_GET['filasPorPagina'];
        $result = BancoAdo::getAllBancos($nombres, intval($posicionPagina), intval($filasPorPagina));
        if (is_array($result)) {
            echo json_encode(array(
                "estado" => 1,
                "bancos" => $result[0],
                "total" => $result[1],
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    } else if ($_GET["type"] === "updatebanco") {
        $idbanco = $_GET['idBanco'];

        $result = BancoAdo::getDataByIdbanco($idbanco);
        if (is_object($result)) {
            echo json_encode(array(
                "estado" => 1,
                "banco" => $result,
            ));
        } else {
            echo json_encode(array(
                "estado" => 2,
                "message" => $result,
            ));
        }
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["type"] === "addBanco") {
        $data["Idbanco"] = $_POST["idbanco"];
        $data["Nombre"] = $_POST["nombre"];
        $data["NumeroCuenta"] = $_POST["numeroCuenta"];
        $data["NumeroCuentainterbancaria"] = $_POST["numeroCuentaInterbancaria"];
        $data["Estado"] = $_POST["estado"];

        $result = BancoAdo::RegistrarBanco($data);
        if ($result == "Insertado") {
            echo json_encode(array(
                "estado" => 1,
                "mensaje" => "Se registró correctamente.",
            ));
        } else if ($result == "Actualizado") {
            echo json_encode(array(
                "estado" => 1,
                "mensaje" => "Se actualizó correctamente.",
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "mensaje" => $result
            ));
        }
        // exit();
    } else if ($_POST["type"] === 'deleteBanco') {
        $banco["idBanco"] = $_POST['idBanco'];
        $result = BancoAdo::deleteBanco($banco);
        if ($result == "eliminado") {
            echo json_encode(array(
                "estado" => 1,
                "message" => "Se eliminaron correctamente los datos",
            ));
        } else if ($result == "ingreso") {
            echo json_encode(array(
                "estado" => 2,
                "message" => "No se pudo eliminar el banco, ya que esta ligado a un ingreso.",
            ));
        } else {
            echo json_encode(array(
                "estado" => 0,
                "message" => "Error al tratar de eliminar los datos " . $result,
            ));
        }
    }
}
