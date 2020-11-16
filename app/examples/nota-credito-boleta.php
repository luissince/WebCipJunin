<?php
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

require __DIR__ . '/../vendor/autoload.php';
require_once '../sunat/database/DataBaseConexion.php';
require("../sunat/ventas/VentasADO.php");

$util = Util::getInstance();
$idventa = $_GET['idventa'];

$detalleventa = VentasADO::NotaCreditoXml($idventa);
if (is_array($detalleventa)) {
    $cliente = $detalleventa[1];
    $empresa = $detalleventa[2];
    $totales = $detalleventa[3];
    $correlativo = explode("-", $detalleventa[4]);

    if ($cliente->Letra === "B") {
        $client = new Client();
        // $client->setTipoDoc($cliente->TipoDocumento)
        // ->setNumDoc($cliente->idDNI)
        // ->setRznSocial($cliente->Apellidos . ' ' . $cliente->Nombres);
        $client->setTipoDoc(0)
            ->setNumDoc(0)
            ->setRznSocial('PÚBLICO GENERAL');
    } else {
        $client = new Client();
        $client->setTipoDoc($cliente->TipoDocumento)
            ->setNumDoc($cliente->RUC)
            ->setRznSocial($cliente->RAZONSOCIAL)
            ->setAddress((new Address())
                ->setDireccion($cliente->DIRECCION));
    }

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
        ->setTipoDoc('07') // Tipo Doc: Nota de Credito
        ->setSerie($correlativo[0]) // Serie NCR
        ->setCorrelativo($correlativo[1]) // Correlativo NCR
        //->setFechaEmision(new DateTime())
        ->setFechaEmision(new DateTime())
        ->setTipDocAfectado($cliente->Letra === "B" ? "03" : "01") // Tipo Doc: Boleta
        ->setNumDocfectado($cliente->Serie . "-" . $cliente->Numeracion) // Boleta: Serie-Correlativo
        ->setCodMotivo('09') // Catalogo. 09
        ->setDesMotivo('DISMINUCIÓN EN EL VALOR')
        ->setTipoMoneda('PEN')
        ->setCompany($company)
        ->setClient($client)
        //->setMtoOperGravadas(5.10)//200 sin igv
        ->setMtoOperExoneradas(round($totales['totalsinimpuesto'], 2, PHP_ROUND_HALF_UP))
        ->setMtoIGV(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //36 igv generado
        ->setTotalImpuestos(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP)) //36 suma total
        ->setMtoImpVenta(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP)) //236 con igv
    ;

    $detail = [];

    foreach ($detalleventa[0] as $value) {
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

    $note->setDetails($detail)
        ->setLegends([$legend]);

    // Envio a SUNAT.
    //FE_BETA
    //FE_PRODUCCION
    $point = SunatEndpoints::FE_BETA;
    $see = $util->getSee($point, $empresa->NumeroDocumento, $empresa->UsuarioSol, $empresa->ClaveSol);

    $res = $see->send($note);
    $util->writeXml($note, $see->getFactory()->getLastXml());
    $hash = $util->getHashCode($note);

    if ($res->isSuccess()) {
        $cdr = $res->getCdrResponse();
        $util->writeCdr($note, $res->getCdrZip());
        if ($cdr->isAccepted()) {
            $ingreso = [];
            array_push($ingreso, array(
                "idIngreso" => $idventa,
                "codigo" => $cdr->getCode(),
                "descripcion" => $cdr->getDescription()
            ));

            $notacredito = [];
            array_push($notacredito, array(
                "idDNI" => $cliente->idDNI,
                "Serie" => $correlativo[0],
                "NumRecibo" => $correlativo[1],
                "CodigoHash" => $hash
            ));

            //VentasADO::CambiarEstadoSunatVentaNotaCredito($ingreso, $notacredito);
            echo json_encode(array(
                "state" => $res->isSuccess(),
                "accept" => $cdr->isAccepted(),
                "id" => $cdr->getId(),
                "code" => $cdr->getCode(),
                "description" => $cdr->getDescription()
            ));
        } else {
            $ingreso = [];
            array_push($ingreso, array(
                "idIngreso" => $idventa,
                "codigo" => $cdr->getCode(),
                "descripcion" => $cdr->getDescription()
            ));

            $notacredito = [];
            array_push($notacredito, array(
                "idDNI" => $cliente->idDNI,
                "Serie" => $correlativo[0],
                "NumRecibo" => $correlativo[1],
                "CodigoHash" => $hash
            ));

           // VentasADO::CambiarEstadoSunatVentaNotaCredito($ingreso, $notacredito);
            echo json_encode(array(
                "state" => $res->isSuccess(),
                "accept" => $cdr->isAccepted(),
                "id" => $cdr->getId(),
                "code" => $cdr->getCode(),
                "description" => $cdr->getDescription()
            ));
        }
    } else {
        if ($res->getError()->getCode() === "1033") {
            $ingreso = array();
            array_push($ingreso, array(
                "idIngreso" => $idventa,
                "codigo" => $res->getError()->getCode(),
                "descripcion" => $res->getError()->getMessage()
            ));

            $notacredito = array();
            array_push($notacredito, array(
                "idDNI" => $cliente->idDNI,
                "Serie" => $correlativo[0],
                "NumRecibo" => $correlativo[1],
                "CodigoHash" => $hash
            ));

            //VentasADO::CambiarEstadoSunatVentaNotaCredito($ingreso, $notacredito);
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
    }
} else {
    echo json_encode(array(
        "state" => false,
        "code" => -1,
        "description" => "Error en realizar una consulta a la base de datos: " . $detalleventa
    ));
}
