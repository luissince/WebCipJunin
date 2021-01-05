<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/PersonaAdo.php');
include_once('../model/CapituloAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN GLOBAL";
$fechaIngreso = "Fecha: ".date('d-m-Y');
$recibos = "Detalle del resumen";
// $fechaIngreso = "FECHA: ".$_GET["fechaInicial"]." al ".$_GET["fechaFinal"];
// $recibos = "RECIBOS DEL : B001-000001 al B001-000002";

$total_cap_esp = CapituloAdo::getAllCountCapAndEsp();
$total_condicion = PersonaAdo::getCountConditionPerson();

if (!is_array($total_cap_esp) && !is_array($total_condicion)) {
    echo json_encode($total_cap_esp);
    echo json_encode($total_condicion);
} else {
    // echo json_encode($total_cap_esp);
    // echo json_encode($total_condicion);
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
<div style="text-align: right;font-size: 11pt;">
    ' . $recibos . '
</div>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr style="background: gray;">
            <th width="5%" rowspan="1">N°</th>
            <th width="75%" rowspan="1">Descripción</th>
            <th width="10%" rowspan="1">Cantidad</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Total de especialidades</td>
            <td>'.$total_cap_esp["Especialidad"].'</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Total de capitulos</td>
            <td>'.$total_cap_esp["Capitulo"].'</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Total de personas registradas</td>
            <td>'.$total_condicion["Personas"].'</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Total en condicion de Ordinarios</td>
            <td>'.$total_condicion["Ordinario"].'</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Total en condicion de Transeuntes</td>
            <td>'.$total_condicion["Transeunte"].'</td>
        </tr>
        <tr>
            <td>6</td>
            <td>Total en condicion de Fallecidos</td>
            <td>'.$total_condicion["Fallecido"].'</td>
        </tr>
        <tr>
            <td>7</td>
            <td>Total en condicion de Retirados</td>
            <td>'.$total_condicion["Retirado"].'</td>
        </tr>
        <tr>
            <td>8</td>
            <td>Total en condicion de Vitalicios</td>
            <td>'.$total_condicion["Vitalicio"].'</td>
        </tr>
        <tr>
            <td>9</td>
            <td>Total en condicion de Habilitados</td>
            <td>'.$total_condicion["Habilitados"].'</td>
        </tr>
        <tr>
            <td>10</td>
            <td>Total en condicion de Inhabilitados</td>
            <td>'.$total_condicion["Vitalicio"].'</td>
        </tr>
    </tbody>
</table>
<br>
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
$mpdf->Output();

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