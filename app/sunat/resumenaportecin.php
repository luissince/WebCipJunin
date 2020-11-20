<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE APORTACIONES AL CIP NACIONAL";
$fechaIngreso = "DE LA FECHA: 11/02/2020";
$totalISSCIP = 0;
$totalSOCIALCIP = 0;
$resumen = IngresosAdo::ResumenAporteCIN("20-11-2020", "20-11-2020");
if (!is_array($resumen)) {
    echo $resumen;
} else {
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
            <span style="font-size: 14pt; color: black; font-family: sans;">
                <b>' . $title . ' </b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
                ' . $fechaIngreso . ' 
        </span>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>   
            <th width="3%" rowspan="2">N°</th>  
            <th width="10%" rowspan="2">Capítulo</th>        
            <th width="6%" rowspan="2">N° Cip</th>
            <th width="6%" rowspan="2">Condición</th>
            <th width="20%" rowspan="2">Ingeniero</th>
            <th width="4%" rowspan="2">Año</th>

            <th width="15%" colspan="13">Cuotas al ISS CIP</th>
            <th width="15%" colspan="13">Cuotas Sociales CIP</th>
            <th width="4%" rowspan="2">T.</th>
        </tr>
        <tr>
            <th>E</th>
            <th>F</th>
            <th>M</th>
            <th>A</th>
            <th>M</th>
            <th>J</th>
            <th>J</th>
            <th>A</th>
            <th>S</th>
            <th>O</th>
            <th>N</th>
            <th>D</th>
            <th>S1</th>

            <th>E</th>
            <th>F</th>
            <th>M</th>
            <th>A</th>
            <th>M</th>
            <th>J</th>
            <th>J</th>
            <th>A</th>
            <th>S</th>
            <th>O</th>
            <th>N</th>
            <th>D</th>
            <th>S2</th>
        </tr>
    </thead>
    <tbody>
    ';
?>
    <?php
    foreach ($resumen as $value) {
        $totalISSCIP += $value["XZ"];
        $totalSOCIALCIP += $value["YZ"];
        $html .= '
        <tr>            
            <td rowspan="1" align="center">' . $value["Id"] . '</td>
            <td rowspan="1">' . $value["Capitulo"] . '</td>
            <td rowspan="1">' . $value["CIP"] . '</td>       
            <td rowspan="1">' . $value["Condicion"] . '</td>     
            <td rowspan="1">' . $value["Ingeniero"] . '</td>
            <td rowspan="1" align="center">' . $value["Anno"] . '</td>            

            <td>' . number_format(round($value["X1"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X2"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X3"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X4"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X5"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X6"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X7"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X8"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X9"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X10"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X11"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["X12"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["XZ"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>

            <td>' . number_format(round($value["Y1"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y2"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y3"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y4"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y5"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y6"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y7"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y8"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y9"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y10"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y11"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["Y12"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            <td>' . number_format(round($value["YZ"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>

            <td>' . number_format(round($value["XYZ"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
        </tr>';
    }

    ?>
    <?php

    $html .= '
    </tbody>
    
</table>
<br>
<div>
    <span style="font-size:8pt;font-weight:bold;">RESUMEN GENERAL</span>
</div>
<table class="items" width="30%" style="font-size: 7pt; border-collapse: collapse;" >
    <thead>        
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Cuotas al ISS CIP:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalISSCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Cuotas Sociales CIP:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalSOCIALCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Resumen Total:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalISSCIP + $totalSOCIALCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
    </thead>
</table>
</body>
</html>
';


    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10,
        'orientation' => 'L',
    ]);

    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("Acme Trading Co. - Invoice");
    $mpdf->SetAuthor("Acme Trading Co.");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);

    $mpdf->Output();
}
