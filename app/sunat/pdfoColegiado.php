<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/PersonaAdo.php');
include_once('../model/CapituloAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";

$total_cap_esp = CapituloAdo::getAllCountCapAndEsp();
$total_condicion = PersonaAdo::getCountConditionPerson();


$html = '
<html>
<head>
<style>
    body{
        font-family: "Helvetica Neue", Helvetica, Arial;
    }

    table thead th {
        padding: 5px;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }

    table tbody td {
        padding: 5px;
        font-size: 12px;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
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

    <table width="100%" border="0" cellspacing="0">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="' . $rutaImage . '" style="width:80px;">                        
            </td>
            <td width="75%" style="text-align: center;">               
                    <h3>Resumen de Ingresos </h3>                                               
            </td>
        </tr>

        <tr>
            <td width="15%" style="text-align: center;padding-top:10px;">
                <h5>CIP-JUNÍN</h5>                                       
            </td>
        </tr>
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
$mpdf->Output();
