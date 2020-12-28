<?php
define('_MPDF_PATH', '/lib');
require('./lib/mpdf/vendor/autoload.php');
include('../src/GenerateCoinToLetters.php');
require_once("./lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');



$html .= '<html>
<head>
    <style>
        body {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
        }
        .header-one {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:60px;
        }
        .header-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:35px;
        }
        .body-one{
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:213px;
        }
        .body-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:120px;
        }
        .footer-one {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:83px;
            text-align: center; 
            padding-left: 400px;
        }
        .footer-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:36px; 
            padding-left:320px;
        }
    </style>
</head>
<body>
    <!--############################################## cabecera ###############################################################################-->
    <div class="header-one">
        <div style="padding-left:140px; padding-top:5px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:270px; padding-top:9px;">
            <div style="width:250px; float:left;">JUNIN</div>
            <div style="width:130px;padding-left:110px; float:left;">123456</div>
        </div>
        <div style="padding-left:155px; padding-top:2px;">
            <div style="width:150px; float:left;padding-left:10px;">12/12/2000</div>
            <div style="width:180px;padding-left:100px; float:left;">Ingenieria de sistemas</div>
        </div>
    </div>
    <div class="header-two">
        <div style="padding-left:120px;">EJERCICIO DE LA PROFESION</div>
        <div style="padding-left:120px; padding-top:5px; width: 510px;">VARIOS </div>
        <div style="padding-left:120px; padding-top:5px; width: 700px;">
            <div style="width:510px;float:left;">A NIVEL NACIONAL</div>
            <div style="text-align:center; width:145px; padding-top: 17px;">
                <div style="width: 40px; float:right; padding-left:6px;">2021</div>
                <div style="width: 50px; float:right; padding-left:6px;">03</div>
                <div style="width: 40px; float:right;">31</div>
            </div>
        </div>
        <div style="padding-top:12px;">
            <div style="padding-left:470px; width:120px; float:left; text-align:center;">Huancayo</div>
            <div style="width:25px; float:left; padding-left:10px;">14</div>
            <div style="width:70px; float:left; padding-left:35px;">Noviembre</div>
            <div style="width:25px; float:left; padding-left:37px;">20</div>
        </div>
    </div>
    <!--############################################### Fin de la cabecera #############################################################-->

    <!--########################################################## Cuerpo del documento ###################################################-->
    <div class="body-one">
        <div style="padding-left:240px; padding-top: 4px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:355px; padding-top:10px;">JUNIN </div>
        <div style="padding-left:355px; padding-top:15px; width: 700px;">
            <div style="width: 150px; float:left;">123456</div>
            <div style="width: 100px; float:left; padding-left:155px;">08/09/2009</div>
        </div>
        <div style="padding-left:240px; padding-top:12px;">Ingenieria de Sistemas </div>
    </div>
    <div class="body-two">
        <div style="padding-left:210px;">EJERCICIO DE LA PROFESION</div>
        <div style="padding-left:210px; padding-top:25px;">VARIOS </div>
        <div style="padding-left:210px; padding-top:25px;">A NIVEL NACIONAL</div>
    </div>
    <!--######################################### Fin Cuerpo del documento ##################################################################-->

    <!--################################################## Pie del Documento ###############################################################-->
    <div class="footer-one">
            <div style="width:50; float:left;">31</div>
            <div style="width:50; float:left;">03</div>
            <div style="width:50; float:left; padding-left:5px;">2021</div>
    </div>
    <div class="footer-two">
            <div style="width:155; float:left;">Huancayo</div>
            <div style="width:65; float:left;">14</div>
            <div style="width:100; float:left;">Noviembre</div>
            <div style="width:50; float:left; padding-left: 27px;">20</div>
    </div>
    <!--################################################## Fin del Pie del Documento ###############################################################-->
</body>
</html>';

$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'P'
]);

$mpdf->SetProtection(array('print'));
$mpdf->SetTitle(" CIP-JUNIN");
$mpdf->SetAuthor("Cip Junin");
// $mpdf->SetWatermarkText(("ANULADO"));   // anulada
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha =  0.5;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output(" CIP-JUNIN.pdf", 'I');
