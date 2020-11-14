<?php

declare(strict_types=1);

use Greenter\Model\Response\BillResult;
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__ . '/../vendor/autoload.php';

$util = Util::getInstance();

$company = new Company();
$company->setRuc("20191899963")
    ->setNombreComercial("")
    ->setRazonSocial("COLEGIO DE INGENIEROS DEL PERU - CONSEJO DEPARTAMENTAL DE JUNIN")
    ->setAddress((new Address())
        ->setUbigueo('120101')
        ->setDistrito('HUANCAYO')
        ->setProvincia('HUANCAYO')
        ->setDepartamento('JUNIN')
        ->setUrbanizacion('')
        ->setCodLocal('0000')
        ->setDireccion("AV. CENTENARIO NRO. 604 (COSTADO DE LA IGLESIA PICHICUS) JUNIN - HUANCAYO - HUANCAYO"))
    ->setEmail("(064) - 203033")
    ->setTelephone("secretaria@cip-junin.org.pe");

$client = new Client();
$client->setTipoDoc('6')
    ->setNumDoc('20600260198')
    ->setRznSocial('STN PROJECT MANAGER SAC')
    ->setAddress((new Address())
        ->setDireccion('JR. OSWALDO BARRETO 582 - EL TAMBO HUANCAYO'))
    ->setEmail('')
    ->setTelephone('');

$invoice = new Invoice();
$invoice
    ->setUblVersion('2.1')
    ->setFecVencimiento(new DateTime())
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('00000082')
    ->setFechaEmision(new DateTime("02-10-2020 12:07:11.000"))
    ->setTipoMoneda('PEN')
    ->setCompany($company)
    ->setClient($client)
    //->setMtoOperGravadas(5.10)//200
    ->setMtoOperExoneradas(257) //100
    ->setMtoIGV(0.0) //36
    ->setTotalImpuestos(0.0) //36
    ->setValorVenta(257.00) //300
    ->setSubTotal(257.0) //336
    ->setMtoImpVenta(257.00) //336
;

// Detalle gravado
// $item1 = new SaleDetail();
// $item1->setCodProducto('C023')
//     ->setUnidad('NIU')
//     ->setDescripcion('MANIJA PLASTICO VOLVO NEGRO')
//     ->setCantidad(3)//2
//     ->setMtoValorUnitario(1.70)//100
//     ->setMtoValorVenta(5.10)//200 100*2
//     ->setMtoBaseIgv(5.10)//200 100*2
//     ->setPorcentajeIgv(18)//18
//     ->setIgv(0.92)//36 18*2
//     ->setTipAfeIgv('10') // Catalog: 07
//     ->setTotalImpuestos(0.92)//36 
//     ->setMtoPrecioUnitario(2.00)//118 100+18
// ;

// Detalle Exonerado
$item1 = new SaleDetail();
$item1->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Certificado de Habilidad')
    ->setCantidad(1) //2
    ->setMtoValorUnitario(17) //50
    ->setMtoValorVenta(17) //50*2
    ->setMtoBaseIgv(17) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(17) //0
;

$item2 = new SaleDetail();
$item2->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Cuotas al ISS CIP')
    ->setCantidad(12) //2
    ->setMtoValorUnitario(2.50) //50
    ->setMtoValorVenta(30.00) //50*2
    ->setMtoBaseIgv(30.00) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(2.50) //0
;

$item3 = new SaleDetail();
$item3->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Cuotas al ISS Junin')
    ->setCantidad(12) //2
    ->setMtoValorUnitario(1.50) //50
    ->setMtoValorVenta(18.00) //50*2
    ->setMtoBaseIgv(18.00) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(1.50) //0
;

$item4 = new SaleDetail();
$item4->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Cuotas Ordinarias')
    ->setCantidad(12) //2
    ->setMtoValorUnitario(13.30) //50
    ->setMtoValorVenta(159.60) //50*2
    ->setMtoBaseIgv(159.60) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(13.30) //0
;

$item5 = new SaleDetail();
$item5->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Cuotas Sociales CIP')
    ->setCantidad(12) //2
    ->setMtoValorUnitario(1.20) //50
    ->setMtoValorVenta(14.40) //50*2
    ->setMtoBaseIgv(14.40) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(1.20) //0
;

$item6 = new SaleDetail();
$item6->setCodProducto('')
    ->setUnidad('NIU')
    ->setDescripcion('Servicios Varios')
    ->setCantidad(12) //2
    ->setMtoValorUnitario(1.50) //50
    ->setMtoValorVenta(18.00) //50*2
    ->setMtoBaseIgv(18.00) //100
    ->setPorcentajeIgv(0) //0
    ->setIgv(0) //00
    ->setTipAfeIgv('20') // Catalog: 07
    ->setTotalImpuestos(0) //0
    ->setMtoPrecioUnitario(1.50) //0
;

$invoice->setDetails([$item1, $item2, $item3, $item4, $item5, $item6])
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue($util->ConvertirNumerosLetras(round(257.00, 2, PHP_ROUND_HALF_UP), "SOL"))
        //   ->setValue('SON TRESCIENTOS TREINTA Y SEIS CON OO/100 SOLES')
    ]);

// Envio a SUNAT.
$see = $util->getSee(SunatEndpoints::FE_PRODUCCION,"20191899963","FACTURA1","Sunat1234");
$res = $see->send($invoice);
$util->writeXml($invoice, $see->getFactory()->getLastXml());

if ($res->isSuccess()) {
    $cdr = $res->getCdrResponse();
    $util->writeCdr($invoice, $res->getCdrZip());
    if ($cdr->isAccepted()) {
        echo json_encode(array(
            "state" => $res->isSuccess(),
            "accept" => $cdr->isAccepted(),
            "id" => $cdr->getId(),
            "code" => $cdr->getCode(),
            "description" => $cdr->getDescription()
        ));
    } else {
        echo json_encode(array(
            "state" => $res->isSuccess(),
            "accept" => $cdr->isAccepted(),
            "id" => $cdr->getId(),
            "code" => $cdr->getCode(),
            "description" => $cdr->getDescription()
        ));
    }
    exit();
} else {
    if ($res->getError()->getCode() === "1033") {
        echo json_encode(array(
            "state" => false,
            "code" => $res->getError()->getCode(),
            "description" => $res->getError()->getMessage()
        ));
    } else {
        echo json_encode(array(
            "state" => false,
            "code" => $res->getError()->getCode(),
            "description" => $res->getError()->getMessage()
        ));
    }
    exit();
}
