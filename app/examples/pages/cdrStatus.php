<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use Greenter\Model\Response\StatusCdrResult;
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../../vendor/autoload.php';

$errorMsg = null;
$filename = null;

/**
 * @param array<string, string> $items
 * @return bool
 */
function validateFields(array $items): bool
{
    global $errorMsg;
    $validateFiels = ['rucSol', 'userSol', 'passSol', 'ruc', 'tipo', 'serie', 'numero'];
    foreach ($items as $key => $value) {
        if (in_array($key, $validateFiels) && empty($value)) {
            $errorMsg = 'El campo ' . $key . ', es requerido';
            return false;
        }
    }

    return true;
}

/**
 * @param string $user
 * @param string $password
 * @return ConsultCdrService
 */
function getCdrStatusService(?string $user, ?string $password): ConsultCdrService
{
    $ws = new SoapClient(SunatEndpoints::FE_CONSULTA_CDR . '?wsdl');
    $ws->setCredentials($user, $password);

    $service = new ConsultCdrService();
    $service->setClient($ws);

    return $service;
}

/**
 * @param string $filename
 * @param string $content
 */
function savedFile(?string $filename, ?string $content): void
{
    $fileDir = __DIR__ . '/../../files';

    if (!file_exists($fileDir)) {
        mkdir($fileDir, 0777, true);
    }
    $pathZip = $fileDir . DIRECTORY_SEPARATOR . $filename;
    file_put_contents($pathZip, $content);
}

/**
 * @param array<string, string> $fields
 * @return StatusCdrResult|null
 */
function process(array $fields): ?StatusCdrResult
{
    global $filename;

    if (!isset($fields['rucSol'])) {
        return null;
    }

    if (!validateFields($fields)) {
        return null;
    }

    $service = getCdrStatusService($fields['rucSol'] . $fields['userSol'], $fields['passSol']);

    $arguments = [
        $fields['ruc'],
        $fields['tipo'],
        $fields['serie'],
        intval($fields['numero'])
    ];
    if ($fields['cdr'] == "cdr") {
        $result = $service->getStatusCdr(...$arguments);
        if ($result->getCdrZip()) {
            $filename = 'R-' . implode('-', $arguments) . '.zip';
            savedFile($filename, $result->getCdrZip());
        }

        return $result;
    }

    return $service->getStatus(...$arguments);
}

$get['rucSol'] = $_GET["rucSol"];
$get['userSol'] = $_GET["userSol"];
$get['passSol'] = $_GET["passSol"];
$get['ruc'] = $_GET["ruc"];
$get['tipo'] = $_GET["tipo"];
$get['serie'] = $_GET["serie"];
$get['numero'] = $_GET["numero"];
$get['cdr'] = $_GET["cdr"];
$result = process($get);

if (isset($result)) {
    if ($result->isSuccess()) {
        if (!is_null($result->getCdrResponse())) {
            if (!is_null($filename)) {
                $file = '/files/' . $filename;
            } else {
                $file = "";
            }
            echo json_encode(array(
                "state" => true,
                "code" => 1,
                "typecode" => $result->getCode(),
                "message" => $result->getMessage(),
                "comprobante" => $result->getCdrResponse()->getDescription(),
                "descripcon" => $result->getCdrResponse()->getNotes(),
                "file" => $file
            ));
        } else {
            echo json_encode(array(
                "state" => true,
                "code" => 2,
                "typecode" => $result->getCode(),
                "message" => $result->getMessage(),
            ));
        }
    } else {
        echo json_encode(array(
            "state" => true,
            "code" => 3,
            "typecode" => $result->getCode(),
            "message" => $result->getMessage(),
            "descripcon" => $result->getError()->getMessage()
        ));
    }
} else {
    echo json_encode(array(
        "state" => false,
        "code" => 0,
        "description" => "Error en la respuesta"
    ));
}
