<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE INGRESOS";
$fechaIngreso = date("d-m-Y", strtotime($_GET["fechaInicial"]))." al ".date("d-m-Y", strtotime($_GET["fechaFinal"]));
$recibos = "RECIBOS DEL : - al -";
$totalCipJunin = 0;
$totalCipNacional = 0;
$result = IngresosAdo::ResumenIngresosPorFecha($_GET["fechaInicial"],$_GET["fechaFinal"]);
if (!is_array($result)) {
    echo $result;
} else {
    $resumen = $result[0];
    $recibos = "RECIBOS DEL :".$result[1]->SerieMin."-".$result[1]->NumReciboMin." al ".$result[1]->SerieMax."-".$result[1]->NumReciboMax;
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
                FECHA: ' . $fechaIngreso . ' 
        </span>
        </td>
    </tr>
</table>
<div style="text-align: right;font-size: 11pt;">
    ' . $recibos . '
</div>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>
            <th width="5%" rowspan="2">N°</th>
            <th width="10%" rowspan="2">Codigo</th>
            <th width="35%" rowspan="2">Concepto</th>
            <th width="10%" rowspan="2">Cant.</th>
            <th width="20%" colspan="2">Cip Junin</th>
            <th width="20%" colspan="2">Cip Nacional</th>
        </tr>
        <tr>
            <th>Efectivo</th>
            <th>Desposito</th>
            <th>Efectivo</th>
            <th>Desposito</th>
        </tr>
    </thead>
    <tbody>';
?>

    <?php
    foreach ($resumen as $value) {
        $totalCipJunin += $value["CIPJunin"];
        $totalCipNacional+=$value["CIPNacional"];
        $html .= ' <tr>
                    <td align="center" rowspan="1">
                        ' . $value["Id"] . '     
                    </td>
                    <td rowspan="1">
                        ' . $value["Codigo"] . '      
                    </td>
                    <td rowspan="1">
                        ' . $value["Concepto"] . '       
                    </td>
                    <td align="center" rowspan="1">
                        ' . $value["Cantidad"] . '      
                    </td>
                    <td align="right">
                        ' . ($value["CIPJunin"] == 0 ? '' : number_format(round($value["CIPJunin"], 2, PHP_ROUND_HALF_UP), 2, '.', '')) . '   
                    </td>
                    <td align="right">
                           
                    </td>
                    <td align="right">
                        ' . ($value["CIPNacional"] == 0 ? '' : number_format(round($value["CIPNacional"], 2, PHP_ROUND_HALF_UP), 2, '.', '')) . '   
                    </td>
                    <td align="right">
                           
                    </td>
                </tr>';
    }

    ?>
    <?php

    $html .= '</tbody>
    <tfoot>
        <tr>
            <td align="center" colspan="4" style="border-left:1px solid white;border-bottom:1px solid white;"></td>
            <td align="right">'.number_format(round($totalCipJunin, 2, PHP_ROUND_HALF_UP), 2, '.', '').'</td>
            <td align="right">0.00</td>
            <td align="right">'.number_format(round($totalCipNacional, 2, PHP_ROUND_HALF_UP), 2, '.', '').'</td>
            <td align="right">0.00</td>
        </tr>
    </tfoot>
</table>
<br>
<div>
    <span style="font-size:10pt;font-weight:bold;">RESUMEN GENERAL</span>
</div>
<table class="items" width="30%" style="font-size: 9pt; border-collapse: collapse;" >
    <thead>        
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">EFECTIVO:</th>
            <th align="right" style="padding:8pt;">'.number_format(round($totalCipJunin+$totalCipNacional, 2, PHP_ROUND_HALF_UP), 2, '.', '').'</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">DEPOSITO:</th>
            <th align="right" style="padding:8pt;">0.00</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">TOTAL:</th>
            <th align="right" style="padding:8pt;">'.number_format(round($totalCipJunin+$totalCipNacional, 2, PHP_ROUND_HALF_UP), 2, '.', '').'</th>
        </tr>
    </thead>
</table>
</body>
</html>
';


    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10
    ]);

    $mpdf->SetProtection(array('print'));
    $mpdf->SetTitle("CIPJUNIN");
    $mpdf->SetAuthor("SysSoftIntegra");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);

    $mpdf->Output("Reporte de Ingresos CIP-JUNIN del ".$fechaIngreso.".pdf",'I');
}
