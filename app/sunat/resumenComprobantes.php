<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE COMPROBANTES";
$fechaInicial = $_GET["txtFechaInicial"];
$fechaFinal = $_GET["txtFechaFinal"];
$tipoDocumento = $_GET["cbTipoDocumento"];
$nombreComprobante = $_GET["nombreComprobante"];

$recibos = "Detalle del resumen";

if ($_GET["cbTipoDocumento"] == 'null') {
    $ventas = IngresosAdo::ReporteGeneralIngresosPorFechas($_GET["txtFechaInicial"], $_GET["txtFechaFinal"]);
} else {
    $ventas = IngresosAdo::ReporteGeneralIngresosPorFechasyTipoDocumento($_GET["txtFechaInicial"], $_GET["txtFechaFinal"], $_GET["cbTipoDocumento"]);
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
            <span style="font-size: 14pt; color: black; font-family: sans;">
                <b>' . $title . ' </b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
            FECHA: ' . $fechaInicial . ' al ' . $fechaFinal . '
        </span>
        </td>
    </tr>
</table>
<div style="text-align: right;font-size: 11pt;">
    ' . $recibos . '
</div>
<br />
<table class="items" width="100%" style="font-size: 6pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr style="background: #BFBFBF;">
            <th width="3%" rowspan="1">ID</th>
            <th width="9%" rowspan="1">MOTIVO ANULACIÓN</th>
            <th width="8%" rowspan="1">FECHA ANULACIÓN</th>
            <th width="5%" rowspan="1">SERIE</th>
            <th width="6%" rowspan="1">NUMERACIÓN</th>
            <th width="8%" rowspan="1">FECHA INGRESO</th>
            <th width="5%" rowspan="1">ESTADO</th>
            <th width="7%" rowspan="1">NUM. DNI</th>
            <th width="7%" rowspan="1">NUM. CIP</th>
            <th width="14%" rowspan="1">APELLIDOS</th>
            <th width="14%" rowspan="1">NOMBRES</th>
            <th width="7%" rowspan="1">MONTO</th>
            <th width="7%" rowspan="1">MONTO ANULADO</th>
        </tr>
    </thead>
    <tbody>';
?>
    <?php
    foreach ($ventas as $value) {
        // $totalCipJunin += $value["CIPJunin"];
        // $totalCipNacional += $value["CIPNacional"];
        if ($value["Estado"] === "C") {
            $html .= ' <tr>
                <td align="center" rowspan="1">
                    ' . $value["Id"] . '     
                </td>
                <td rowspan="1">
                    ' . $value["MotivoAnulacion"] . '      
                </td>
                <td rowspan="1">
                    ' . $value["FechaAnulacion"] . '       
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
                <td align="center" rowspan="1">
                    ' . $value["Estado"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["idDNI"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["CIP"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Apellidos"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Nombres"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Total"] . '      
                </td>
                <td align="center" rowspan="1">
                    0.00      
                </td>
            </tr>';
        } else {
            $html .= ' <tr style="background: #D9D8D8;">
                <td align="center" rowspan="1">
                    ' . $value["Id"] . '     
                </td>
                <td rowspan="1">
                    ' . $value["MotivoAnulacion"] . '      
                </td>
                <td rowspan="1">
                    ' . $value["FechaAnulacion"] . '       
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
                <td align="center" rowspan="1">
                    ' . $value["Estado"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["idDNI"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["CIP"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Apellidos"] . '      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Nombres"] . '      
                </td>
                <td align="center" rowspan="1">
                    0.00      
                </td>
                <td align="center" rowspan="1">
                    ' . $value["Total"] . '    
                </td>
            </tr>';
        }
    }
    ?>
<?php
    $html .= '</tbody>
</table>
<br>
</body>
</html>
';


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
    $mpdf->SetTitle("CIPJUNIN");
    $mpdf->SetAuthor("SysSoftIntegra");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);
    if($tipoDocumento == "null"){
        $mpdf->Output("Reporte de Ingresos del ".$fechaInicial." al ".$fechaFinal.".pdf",'I');
    }else{
        $mpdf->Output("Reporte de ".$nombreComprobante."(s) del ".$fechaInicial." al ".$fechaFinal.".pdf",'I');
    }
    
}
?>

<!-- <div>
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
</table> -->