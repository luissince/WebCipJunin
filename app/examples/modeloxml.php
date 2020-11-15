<?php

set_time_limit(300); //evita el error 20 segundos de peticion
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require './../vendor/autoload.php';
include_once '../model/IngresosAdo.php';

$util = Util::getInstance();

$detalleventa = IngresosAdo::ObtenerIngresoXML($idIngreso);
if (!is_array($detalleventa)) {
        echo json_encode(array(
                "state" => false,
                "code" => -1,
                "description" => $detalleventa
        ));
} else {
        $ingreso = $detalleventa[0];
        $detalleIngreso = $detalleventa[1];
        $cuotas = $detalleventa[2];
        $empresa = $detalleventa[3];
        $totales = $detalleventa[4];


        $client = new Client();
        $client->setTipoDoc('1')
                ->setNumDoc($ingreso->idDNI)
                ->setRznSocial($ingreso->Apellidos . ' ' . $ingreso->Nombres);


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

        // Venta
        $invoice = new Invoice();
        $invoice
                ->setUblVersion('2.1')
                ->setTipoOperacion('0101')
                ->setTipoDoc($ingreso->TipoComprobante)
                ->setSerie($ingreso->Serie)
                ->setCorrelativo($ingreso->Numeracion)
                ->setFechaEmision(new DateTime($ingreso->FechaPago))
                ->setTipoMoneda("PEN")
                ->setCompany($company)
                ->setClient($client)
                //->setMtoOperGravadas(round($totales['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP)) //5.10
                ->setMtoOperExoneradas(round($totales['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP)) //5.10
                ->setMtoIGV(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
                ->setTotalImpuestos(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //0.92
                ->setValorVenta(round($totales['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP)) //5.10
                ->setSubTotal(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //6
                ->setMtoImpVenta(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //6
        ;

        $detail = [];

        foreach ($detalleIngreso as $value) {
                $cantidad = $value['Cantidad'];
                $impuesto = 0;
                $precioBruto = $value['Precio'];

                $impuestoGenerado = $precioBruto * ($impuesto / 100.00);
                $impuestoTotal = $impuestoGenerado * $cantidad;
                $importeBrutoTotal = $precioBruto * $cantidad;
                $importeNeto = $precioBruto + $impuestoGenerado;
                $importeNetoTotal = $importeBrutoTotal + $impuestoTotal;

                $item1 = new SaleDetail();
                $item1->setCodProducto('')
                        ->setUnidad('ZZ')
                        ->setCantidad(round($cantidad, 2, PHP_ROUND_HALF_UP)) //2
                        ->setDescripcion($value['Concepto'])
                        ->setMtoBaseIgv($importeBrutoTotal) //18 50*2
                        ->setPorcentajeIgv(round($impuesto, 0, PHP_ROUND_HALF_UP)) //18
                        ->setIgv($impuestoTotal) //18 9*2
                        ->setTipAfeIgv('20') //10-igv - 20-exogenerada
                        ->setTotalImpuestos($impuestoTotal) //18 9*2
                        ->setMtoValorVenta($importeBrutoTotal) //100 = 50*2
                        ->setMtoValorUnitario(round($precioBruto, 2, PHP_ROUND_HALF_UP)) //50
                        ->setMtoPrecioUnitario($importeNeto); //59
                array_push($detail, $item1);
        }


        $legend = new Legend();
        $legend->setCode('1000')
                ->setValue($util->ConvertirNumerosLetras(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), "SOL"));

        $invoice->setDetails($detail)
                ->setLegends([$legend]);

        // Envio a SUNAT.
        //FE_BETA
        //FE_PRODUCCION
        $point = SunatEndpoints::FE_BETA;
        $see = $util->getSee($point, $empresa->NumeroDocumento, $empresa->UsuarioSol, $empresa->ClaveSol);
        $res = $see->send($invoice);
        $util->writeXml($invoice, $see->getFactory()->getLastXml());
        $hash = $util->getHashCode($invoice);

        if ($res->isSuccess()) {
                $cdr = $res->getCdrResponse();
                $util->writeCdr($invoice, $res->getCdrZip());
                if ($cdr->isAccepted()) {
                        IngresosAdo::CambiarEstadoSunatVenta($idIngreso, $cdr->getCode(), $cdr->getDescription(), $hash);
                        echo json_encode(array(
                                "state" => $res->isSuccess(),
                                "accept" => $cdr->isAccepted(),
                                "id" => $cdr->getId(),
                                "code" => $cdr->getCode(),
                                "description" => $cdr->getDescription()
                        ));
                } else {
                        IngresosAdo::CambiarEstadoSunatVenta($idIngreso, $cdr->getCode(), $cdr->getDescription(), $hash);
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
                        IngresosAdo::CambiarEstadoSunatVenta($idIngreso, "0", $res->getError()->getMessage(), $hash);
                        echo json_encode(array(
                                "state" => false,
                                "code" => $res->getError()->getCode(),
                                "description" => $res->getError()->getMessage()
                        ));
                } else {
                        IngresosAdo::CambiarEstadoSunatVenta($idIngreso, $res->getError()->getCode(), $res->getError()->getMessage(), $hash);
                        echo json_encode(array(
                                "state" => false,
                                "code" => $res->getError()->getCode(),
                                "description" => $res->getError()->getMessage()
                        ));
                }
                exit();
        }
}
