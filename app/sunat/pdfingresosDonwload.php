<?php

use SysSoftIntegra\Pdf\PdfIngreso;
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

if (!isset($_GET["idIngreso"])) {
    echo '<script>location.href = "404.php";</script>';
} else {

    $detalleventa = IngresosAdo::ObtenerIngresoXML($_GET["idIngreso"]);
    if (!is_array($detalleventa)) {
        echo $detalleventa;
    } else {
        if (!isset($detalleventa[3])) {
            echo 'Hay con valores nulos en el registro de empresa, por favor corregir.';
        } else {
            $ingreso = $detalleventa[0];
            $detalleIngreso = $detalleventa[1];
            $cuotas = $detalleventa[2];
            $empresa = $detalleventa[3];
            $totales = $detalleventa[4];

            $rutaImage = "../../view/images/logologin.png";
            $nombre = $empresa->RazonSocial;
            $direccion = $empresa->Domicilio;
            $web = $empresa->PaginaWeb;
            $email = $empresa->Email;
            $telefono = "Tesorería " . $empresa->Telefono . " Anexo 202";
            $ruc = $empresa->NumeroDocumento;

            $textoCodBar =
                '|' . $ruc
                . '|' . $ingreso->TipoComprobante
                . '|' . $ingreso->Serie
                . '|' . $ingreso->Numeracion
                . '|' . number_format(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
                . '|' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
                . '|' . $ingreso->FechaEmision
                . '|' . $ingreso->TipoDocumento
                . '|' . $ingreso->NumeroDocumento
                . '|';

            $mpdf = PdfIngreso::createPdf($rutaImage, $nombre, $direccion, $telefono, $email, $web, $ruc, $ingreso, $detalleIngreso, $cuotas, $totales, $textoCodBar);
            // Output a PDF file directly to the browser
            $mpdf->Output($ingreso->Comprobante . " " . $ingreso->Serie . '-' . $ingreso->Numeracion . " CIP-JUNIN.pdf", 'I');
        }
    }
}