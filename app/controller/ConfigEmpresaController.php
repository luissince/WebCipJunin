<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use SysSoftIntegra\Model\ConfigEmpresaAdo;

require __DIR__ . './../src/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $data = ConfigEmpresaAdo::ObtenerEmpresa();

    if (is_object($data)) {
        print json_encode(array(
            "estado" => 1,
            "result" => $data,
        ));
    } else {
        print json_encode(array(
            "estado" => 2,
            "message" => $data
        ));
    }
    exit();
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $body["idEmpresa"] = $_POST["idEmpresa"];
    $body["txtNumDocumento"] = $_POST["txtNumDocumento"];
    $body["txtRazonSocial"] = $_POST["txtRazonSocial"];
    $body["txtNomComercial"] = $_POST["txtNomComercial"];
    $body["txtDireccion"] = $_POST["txtDireccion"];
    $body["txtHorario"] = $_POST["txtHorario"];
    $body["txtTelefono"] = $_POST["txtTelefono"];
    $body["txtCelular"] = $_POST["txtCelular"];
    $body["txtPaginWeb"] = $_POST["txtPaginWeb"];
    $body["txtEmail"] = $_POST["txtEmail"];

    $body["imageType"] = $_POST["imageType"];
    $body["image"] = $_POST["imageType"] != 0 ? fopen($_FILES['image']['tmp_name'], 'rb') : null;

    $body["txtUsuarioSol"] = $_POST["txtUsuarioSol"];
    $body["txtClaveSol"] = $_POST["txtClaveSol"];
    //    
    $body["certificadoUrl"] = $_POST["certificadoUrl"];
    $body["certificadoType"] = $_POST["certificadoType"];
    $body["certificadoName"] = $_POST["certificadoType"] == 1 ? $_FILES['certificado']['name'] : '';
    $body["certificadoNameTmp"] = $_POST["certificadoType"] == 1 ? $_FILES['certificado']['tmp_name'] : '';

    $body["txtClaveCertificado"] = $_POST["txtClaveCertificado"];

    $result = configEmpresaADO::CrudEmpresa($body);
    if ($result == "updated") {
        echo json_encode(array(
            "state" => 1,
            "message" => "Se modificó correctamente los datos."
        ));
    } else {
        echo json_encode(array(
            "state" => 2,
            "message" => $result
        ));
    }
    exit();
}
