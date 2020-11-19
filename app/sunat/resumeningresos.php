<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");

$rutaImage = __DIR__ . "/../images/logologin.png";
$title = "RESUMEN DE INGRESOS";
$fechaIngreso = "DE LA FECHA: 11/02/2020";
$recibos = "RECIBOS DEL : B001-000001 al B001-000002";

$html = '
<html>
<head>
<style>
body {
    font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { 
    vertical-align: top; 
}
.items th {
    border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
    border-top: 0.1mm solid #000000;
    border-bottom: 0.1mm solid #000000;
}
.items td {
	border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
    border-top: 0.1mm solid #000000;
    border-bottom: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
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
        <td width="15%" style="border: 0mm solid #888888; ">
            <img src="' . $rutaImage . '" style="width:80px;">
        </td>
        <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
            <span style="font-size: 15pt; color: black; font-family: sans;">
                <b>'.$title.' </b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
                '.$fechaIngreso.' 
        </span>
        </td>
    </tr>
</table>
<div style="text-align: right">
    '.$recibos .'
</div>
<br />
<table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>
            <th width="5%">N°</th>
            <th width="10%">Codigo</th>
            <th width="35%">Concepto</th>
            <th width="10%">Cant.</th>
            <th width="20%" colspan="2">Cip Junin</th>
            <th width="20%" colspan="2">Cip Nacional</th>
        </tr>
    </thead>
    <tbody>
<!-- ITEMS HERE -->
        <tr>
            <td align="center">1</td>
            <td align="center">101010</td>
            <td>Large pack Hoover bags</td>
            <td align="center">1</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
        </tr>
<!-- END ITEMS HERE -->
    </tbody>
    <tfoot>
        <tr>
            <td align="center" colspan="4"></td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
        </tr>
    </tfoot>
</table>
<br>
<div>
    <span style="font-size:11pt;font-weight:bold;">RESUMEN GENERAL</span>
</div>
<table class="items" width="30%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>        
        <tr>
            <th align="left">EFECTIVO:</th>
            <th align="right">0.00</th>
        </tr>
        <tr>
            <th align="left">EN DEPOSITO</th>
            <th align="right">0.00</th>
        </tr>
        <tr>
            <th align="left">TOTAL</th>
            <th align="right">0.00</th>
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
$mpdf->SetTitle("Acme Trading Co. - Invoice");
$mpdf->SetAuthor("Acme Trading Co.");
$mpdf->SetWatermarkText("");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);

$mpdf->Output();