<?php

set_time_limit(300);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');


use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . './../vendor/autoload.php';
include_once __DIR__ . './../model/NotaCreditoAdo.php';

$util = Util::getInstance();
$idNotaCredito = $_GET['idNotaCredito'];

$detalleventa = NotaCreditoAdo::ObtenerNotaCreditoXML($idNotaCredito);
if (!is_array($detalleventa)) {
    echo json_encode(array(
        "state" => false,
        "code" => "-1",
        "description" => $detalleventa
    ));
} else {

    $notacredito = $detalleventa[0];
    $detalle = $detalleventa[1];
    $empresa = $detalleventa[2];
    $totales = $detalleventa[3];


    $client = new Client();
    $client->setTipoDoc($notacredito->TipoDocumento)
        ->setNumDoc($notacredito->NumeroDocumento)
        ->setRznSocial($notacredito->DatosPersona)
        ->setAddress((new Address())
            ->setDireccion($notacredito->Direccion));

    $company = new Company();
    $company->setRuc($empresa->NumeroDocumento)
        ->setNombreComercial($empresa->NombreComercial)
        ->setRazonSocial($empresa->RazonSocial)
        ->setAddress((new Address())
            ->setUbigueo('120101')
            ->setDistrito('HUANCAYO')
            ->setProvincia('HUANCAYO')
            ->setDepartamento('JUNIN')
            ->setUrbanizacion('')
            ->setCodLocal('0000')
            ->setDireccion($empresa->Domicilio))
        ->setEmail($empresa->Telefono)
        ->setTelephone($empresa->Email);

    $note = new Note();
    $note
        ->setUblVersion('2.1')
        ->setTipoDoc($notacredito->TipoDocumentoNotaCredito) // Tipo Doc: Nota de Credito
        ->setSerie($notacredito->SerieNotaCredito) // Serie NCR
        ->setCorrelativo($notacredito->NumeracionNotaCredito) // Correlativo NCR
        ->setFechaEmision(new DateTime($notacredito->FechaNotaCredito . "T" . $notacredito->HoraNotaCredito))
        ->setTipDocAfectado($notacredito->CodigoAlterno) // Tipo Doc: Boleta
        ->setNumDocfectado($notacredito->Serie . '-' . $notacredito->NumRecibo) // Boleta: Serie-Correlativo
        ->setCodMotivo($notacredito->CodigoAnulacion) // Catalogo. 09
        ->setDesMotivo($notacredito->MotivoAnulacion)
        ->setTipoMoneda("PEN")
        ->setCompany($company)
        ->setClient($client)
        ->setMtoOperGravadas(round($totales['opgravada'], 2, PHP_ROUND_HALF_UP)) //5.10
        ->setMtoOperExoneradas(round($totales['opexonerada'], 2, PHP_ROUND_HALF_UP)) //5.10
        ->setMtoIGV(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
        ->setTotalImpuestos(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
        ->setMtoImpVenta(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //6
    ;

    $detail = [];

    foreach ($detalle as $value) {
        $cantidad = $value['Cantidad'];
        $impuesto = $value['Valor'];
        $precioVenta = $value['Precio'];

        $precioBruto = $precioVenta / (($impuesto / 100.00) + 1);
        $impuestoGenerado = $precioBruto * ($impuesto / 100.00);
        $impuestoTotal = $impuestoGenerado * $cantidad;
        $importeBrutoTotal = $precioBruto * $cantidad;
        $importeNeto = $precioBruto + $impuestoGenerado;
        $importeNetoTotal = $importeBrutoTotal + $impuestoTotal;

        $item = new SaleDetail();
        $item
            ->setCodProducto('')
            ->setUnidad('ZZ')
            ->setCantidad(round($cantidad, 2, PHP_ROUND_HALF_UP))
            ->setDescripcion($value["Concepto"])
            ->setMtoBaseIgv($importeBrutoTotal)
            ->setPorcentajeIgv(round($impuesto, 0, PHP_ROUND_HALF_UP))
            ->setIgv($impuestoTotal)
            ->setTipAfeIgv($value["Codigo"])
            ->setTotalImpuestos($impuestoTotal)
            ->setMtoValorVenta($importeBrutoTotal)
            ->setMtoValorUnitario(round($precioBruto, 2, PHP_ROUND_HALF_UP))
            ->setMtoPrecioUnitario($importeNeto);
        array_push($detail, $item);
    }

    $legend = new Legend();
    $legend->setCode('1000')
        ->setValue($util->ConvertirNumerosLetras(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), "SOLES"));

    $note->setDetails($detail)
        ->setLegends([$legend]);


    //Envio a SUNAT.
    //FE_BETA
    //FE_PRODUCCION
    $point = SunatEndpoints::FE_PRODUCCION;
    $see = $util->getSee($point, $empresa->NumeroDocumento, $empresa->UsuarioSol, $empresa->ClaveSol);
    $res = $see->send($note);
    $util->writeXml($note, $see->getFactory()->getLastXml());
    $hash = $util->getHashCode($note);

    if ($res->isSuccess()) {
        $cdr = $res->getCdrResponse();
        $util->writeCdr($note, $res->getCdrZip());
        if ($cdr->isAccepted()) {
            NotaCreditoAdo::CambiarEstadoSunatNotaCredito($idNotaCredito, $cdr->getCode(), $cdr->getDescription(), $hash, $see->getFactory()->getLastXml());
            echo json_encode(array(
                "state" => $res->isSuccess(),
                "accept" => $cdr->isAccepted(),
                "id" => $cdr->getId(),
                "code" => $cdr->getCode(),
                "description" => $cdr->getDescription()
            ));
        } else {
            NotaCreditoAdo::CambiarEstadoSunatNotaCredito($idNotaCredito, $cdr->getCode(), $cdr->getDescription(), $hash, $see->getFactory()->getLastXml());
            echo json_encode(array(
                "state" => $res->isSuccess(),
                "accept" => $cdr->isAccepted(),
                "id" => $cdr->getId(),
                "code" => $cdr->getCode(),
                "description" => $cdr->getDescription(),
                "hashcode" => $pdf
            ));
        }
    } else {
        if ($res->getError()->getCode() === "1033") {
            NotaCreditoAdo::CambiarEstadoSunatNotaCredito($idNotaCredito, "0", $res->getError()->getMessage(), $hash);
            echo json_encode(array(
                "state" => false,
                "code" => $res->getError()->getCode(),
                "description" => $res->getError()->getMessage()
            ));
        } else {
            NotaCreditoAdo::CambiarEstadoSunatNotaCredito($idNotaCredito, $res->getError()->getCode(), $res->getError()->getMessage(), $hash, $see->getFactory()->getLastXml());
            echo json_encode(array(
                "state" => false,
                "code" => $res->getError()->getCode(),
                "description" => $res->getError()->getMessage()
            ));
        }
    }
}
