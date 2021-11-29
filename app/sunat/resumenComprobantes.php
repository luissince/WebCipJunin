<?php
ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE COMPROBANTES";
$fechaInicial = $_GET["txtFechaInicial"];
$fechaFinal = $_GET["txtFechaFinal"];
$tipoDocumento = $_GET["cbTipoDocumento"];
$monto = 0;

$recibos = "Detalle del resumen";

if ($_GET["cbTipoDocumento"] == 'null') {
    $ventas = IngresosAdo::ReporteGeneralIngresosPorFechas($_GET["txtFechaInicial"], $_GET["txtFechaFinal"], $_GET["cbTipoPago"], $_GET["usuario"]);
} else {
    $ventas = IngresosAdo::ReporteGeneralIngresosPorFechasyTipoDocumento($_GET["txtFechaInicial"], $_GET["txtFechaFinal"], $_GET["cbTipoDocumento"], $_GET["cbTipoPago"], $_GET["usuario"]);
}

if (!is_array($ventas)) {
    echo $ventas;
} else {
    $resumen = $ventas[0];
    $html = '
<html>
<head>
<style>
    body {
        font-family: Arial;
        font-size: 10pt;
    }
    p {	
        font-family: Arial;
    }
    table.items {
        border: 0.1mm solid #000000;
    }
    td { 
        vertical-align: middle; 
    }
    table thead th {
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }
    table tbody td {
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }
    table tfoot td {
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }
    table thead td { 
        background-color: #EEEEEE;
        text-align: center;
        border: 0.1mm solid #000000;
        font-variant: small-caps;
    }
</style>
</head>
<body>

<!--mpdf
<htmlpageheader name="myheader">
    <table width="100%">
        <tr>
            <td width="50%" style="color:#969696; ">
                <span style="font-weight: bold; font-size: 9pt;">
                    Colegio de Ingenieros del Perú
                </span>
            </td>
            <td width="50%" style="color:#969696;text-align: right;">
                <span style="font-weight: bold; font-size: 9pt;">
                    Consejo Departamental de Junín
                </span>
            </td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
        Pagin {PAGENO} de {nb}
    </div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-family: serif;" cellpadding="10">
    <tr>
        <td width="15%" style="border: 0mm solid #888888;text-align: center;">
            <img src="' . $rutaImage . '" style="width:80px;">
            <div>
                <p>CIP-JUNÍN</p>
            </div>
        </td>
        <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
            <span style="font-size: 13pt; color: black; font-family: sans;">
                <b>' . $title . ' </b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
            FECHA: ' . date("d/m/Y", strtotime($fechaInicial)) . ' al ' . date("d/m/Y", strtotime($fechaFinal)) . '
        </span>
        </td>
    </tr>
</table>

<br />';
?>
<?php
    if ($_GET["cbTipoPago"] == 1) {
        $html .= '<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8">
        <thead>
            <tr style="background: #BFBFBF;">
                <th rowspan="1">ID</th>
                <th rowspan="1">SERIE</th>
                <th rowspan="1">CORRELATIVO</th>
                <th rowspan="1">FECHA REG.</th>
                <th rowspan="1">CONCEPTO</th>
                <th rowspan="1">ESTADO</th>
                <th rowspan="1">TIPO PAGO</th>
                <th rowspan="1">NUM. CIP</th>        
                <th rowspan="1">PERSONA</th>
                <th rowspan="1">MONTO</th>
                <th rowspan="1">MONTO ANULADO</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($ventas as $value) {

            if ($value["Concepto"] == 1) {
                $Concepto = "Cuota Ordinaria";
            } else if ($value["Concepto"] == 2) {
                $Concepto = "Cuota Ordinaria (Amnistia)";
            } else if ($value["Concepto"] == 3) {
                $Concepto = "Cuota Ordinaria (Vitalicio)";
            } else if ($value["Concepto"] == 4) {
                $Concepto = "Colegiatura";
            } else if ($value["Concepto"] == 5) {
                $Concepto = "Certificado de habilidad";
            } else if ($value["Concepto"] == 6) {
                $Concepto = "Cuota de residencia de obra";
            } else if ($value["Concepto"] == 7) {
                $Concepto = "Certificado de proyecto";
            } else if ($value["Concepto"] == 8) {
                $Concepto = "Peritaje";
            } else if ($value["Concepto"] == 100) {
                $Concepto = "Ingresos Diversos";
            }

            // $totalCipJunin += $value["CIPJunin"];
            // $totalCipNacional += $value["CIPNacional"];

            if ($value["TipoPago"] == 1) {
                $tipoPago = 'EFECTIVO';
            } else if ($value["TipoPago"] == 2) {
                $tipoPago = 'DEPOSITO';
            } else {
                $tipoPago = 'TARJETA';
            }

            if ($value["Estado"] === "C") {
                $html .= ' <tr>
                    <td align="center" rowspan="1">
                        ' . $value["Id"] . '     
                    </td>                   
                    <td align="center" rowspan="1">
                        ' . $value["Serie"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NumRecibo"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["FechaPago"] . '      
                    </td>
                    <td align="left" rowspan="1">
                        ' . $Concepto . '     
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["Estado"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $tipoPago . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["CIP"] . '      
                    </td>            
                    <td align="left" rowspan="1">
                        ' . $value["NumeroDocumento"] . '<br>' . $value["Persona"] . '      
                    </td>
                    <td align="right" rowspan="1">
                        ' . number_format(round($value["Total"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '      
                    </td>
                    <td align="right" rowspan="1">
                        0.00      
                    </td>
                </tr>';
                $monto += $value["Total"];
            } else {
                $html .= ' <tr style="background: #D9D8D8;">
                    <td align="center" rowspan="1">
                        ' . $value["Id"] . '     
                    </td>                    
                    <td align="center" rowspan="1">
                        ' . $value["Serie"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NumRecibo"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["FechaPago"] . '      
                    </td>
                    <td align="left" rowspan="1">
                        ' . $Concepto . '     
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["Estado"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $tipoPago . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["CIP"] . '      
                    </td> 
                    <td align="left" rowspan="1">
                        ' . $value["NumeroDocumento"] . '<br>' . $value["Persona"] . '    
                    </td>
                    <td align="right" rowspan="1">
                        0.00      
                    </td>
                    <td align="right" rowspan="1">
                        ' . number_format(round($value["Total"], 2, PHP_ROUND_HALF_UP), 2, '.', '')  . '    
                    </td>
                </tr>';
            }
        }

        $html .= '</tbody>
                    </table>
                <br>               
                <h3>
                    ' . $recibos . '
                </h3>
                <table  border="0" cellspacing="0">
                    <tr>
                        <td align="left" style="border: 1px solid black;padding:8px;">MONTO TOTAL:</td>
                        <td align="left" style="border: 1px solid black;padding:8px;">' . number_format(round($monto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    </tr>                    
                </table>

            </body>
        </html>';
    } else {
        $html .= '
    <table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8">
        <thead>
            <tr style="background: #BFBFBF;">
                <th rowspan="1">ID</th>
                <th rowspan="1">SERIE</th>
                <th rowspan="1">CORRELATIVO</th>
                <th rowspan="1">FECHA REG.</th>
                <th rowspan="1">CONCEPTO</th>
                <th rowspan="1">ESTADO</th>
                <th rowspan="1">TIPO PAGO</th>
                <th rowspan="1">NOMBRE BANCO</th>
                <th rowspan="1">NUM. CIP</th>          
                <th rowspan="1">PERSONA</th>
                <th rowspan="1">MONTO</th>
                <th rowspan="1">MONTO ANULADO</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($ventas as $value) {

            if ($value["Concepto"] == 1) {
                $Concepto = "Cuota Ordinaria";
            } else if ($value["Concepto"] == 2) {
                $Concepto = "Cuota Ordinaria (Amnistia)";
            } else if ($value["Concepto"] == 3) {
                $Concepto = "Cuota Ordinaria (Vitalicio)";
            } else if ($value["Concepto"] == 4) {
                $Concepto = "Colegiatura";
            } else if ($value["Concepto"] == 5) {
                $Concepto = "Certificado de habilidad";
            } else if ($value["Concepto"] == 6) {
                $Concepto = "Cuota de residencia de obra";
            } else if ($value["Concepto"] == 7) {
                $Concepto = "Certificado de proyecto";
            } else if ($value["Concepto"] == 8) {
                $Concepto = "Peritaje";
            } else if ($value["Concepto"] == 100) {
                $Concepto = "Ingresos Diversos";
            }

            // $totalCipJunin += $value["CIPJunin"];
            // $totalCipNacional += $value["CIPNacional"];

            if ($value["TipoPago"] == 1) {
                $tipoPago = 'EFECTIVO';
            } else if ($value["TipoPago"] == 2) {
                $tipoPago = 'DEPOSITO';
            } else {
                $tipoPago = 'TARJETA';
            }

            if ($value["Estado"] === "C") {
                $html .= ' <tr>
                    <td align="center" rowspan="1">
                        ' . $value["Id"] . '     
                    </td>                    
                    <td align="center" rowspan="1">
                        ' . $value["Serie"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NumRecibo"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["FechaPago"] . '      
                    </td>
                    <td align="left" rowspan="1">
                        ' . $Concepto . '     
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["Estado"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $tipoPago  . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NombreBanco"] . '<br>' . $value["NumeroOperacion"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["CIP"] . '      
                    </td>             
                    <td align="left" rowspan="1">
                        ' . $value["NumeroDocumento"] . '<br>' . $value["Persona"] . '     
                    </td>
                    <td align="right" rowspan="1">
                        ' . number_format(round($value["Total"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '      
                    </td>
                    <td align="right" rowspan="1">
                        0.00      
                    </td>
                </tr>';
                $monto += $value["Total"];
            } else {
                $html .= ' <tr style="background: #D9D8D8;">
                    <td align="center" rowspan="1">
                        ' . $value["Id"] . '     
                    </td>                    
                    <td align="center" rowspan="1">
                        ' . $value["Serie"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NumRecibo"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["FechaPago"] . '      
                    </td>
                    <td align="left" rowspan="1">
                        ' . $Concepto . '     
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["Estado"] . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' .  $tipoPago . '      
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["NombreBanco"] . '<br>' . $value["NumeroOperacion"] . '      
                    </td>                
                    <td align="center" rowspan="1">
                        ' . $value["CIP"] . '      
                    </td>                     
                    <td align="left" rowspan="1">
                        ' . $value["NumeroDocumento"] . '<br>' . $value["Persona"] . '      
                    </td>
                    <td align="right" rowspan="1">
                        0.00      
                    </td>
                    <td align="right" rowspan="1">
                        ' . number_format(round($value["Total"], 2, PHP_ROUND_HALF_UP), 2, '.', '')  . '    
                    </td>
                </tr>';
            }
        }

        $html .= '</tbody>
                    </table>
                <br>
                <h3>
                    ' . $recibos . '
                </h3>
                <table  border="0" cellspacing="0">
                    <tr>
                        <td align="left" style="border: 1px solid black;padding:8px;">FACTURAS TOTAL:</td>
                        <td align="left" style="border: 1px solid black;padding:8px;">' . number_format(round($monto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    </tr>                             
                </table>
            </body>
        </html>';
    }

    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10,
        'orientation' => 'L',
    ]);

    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("INTRANET CIP-JUNIN");
    $mpdf->SetAuthor("SysSoftIntegra");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);
    if ($tipoDocumento == "null") {
        $mpdf->Output("Reporte de Comprobantes del " . $fechaInicial . " al " . $fechaFinal . ".pdf", 'I');
    } else {
        $mpdf->Output("Reporte de " . $nombreComprobante . "(s) del " . $fechaInicial . " al " . $fechaFinal . ".pdf", 'I');
    }
}
?>