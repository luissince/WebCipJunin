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
            padding-top:56px;
        }
        .header-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:40px;
        }
        .body-one{
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:200px;
        }
        .body-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:115px;
        }
        .footer-one {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:58px; 
        }
    </style>
</head>
<body>
    <!--############################################## cabecera ###############################################################################-->
    <div class="header-one">
        <div style="padding-left:140px; padding-top:15px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:270px; padding-top:9px;">
            <div style="width:250px; float:left;">JUNIN</div>
            <div style="width:130px;padding-left:110px; float:left;">123456</div>
        </div>
        <div style="padding-left:155px; padding-top:2px;">
            <div style="width:150px; float:left;padding-left:20px;">12/12/2000</div>
            <div style="width:180px;padding-left:90px; float:left;">Ingenieria de sistemas</div>
        </div>
    </div>
    <div class="header-two">
        <div style="width:790px; padding-top:5px;">
            <div style="width: 350px; float:left; padding-left:140px;">
                EJERCICIO DE LA PROFESION
            </div>
        </div>
        <div style="width:790px; padding-top:15px;">
            <div style="width: 350px; float:left; padding-left:140px;">
                SIN PROPIETARIO
            </div>
        </div>
        <div style="padding-top:5px; width: 790px;">
            <div style="text-align:center; width:145px; padding-top: 17px; float:left; padding-left:120px; ">
                <div style="width: 40px; float:left; padding-left:16px;">31</div>
                <div style="width: 40px; float:left; padding-left:5px;">03</div>
                <div style="width: 40px; float:left;">2021</div>
            </div>
            <div style="width:520; float:left; padding-top: 19px;">
                <div style="width:120px; float:left;  padding-left:197px;">Huancayo</div>
                <div style="width:25px; float:left; padding-left:10px;">14</div>
                <div style="width:70px; float:left; padding-left:30px;">Noviembre</div>
                <div style="width:25px; float:left; padding-left:40px;">20</div>
            </div>
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
        <div style="padding-left:270px;">EJERCICIO DE LA PROFESION</div>
        <div style="padding-left:260px; padding-top:10px;">VARIOS </div>
    </div>
    <!--######################################### Fin Cuerpo del documento ##################################################################-->

    <!--################################################## Pie del Documento ###############################################################-->
    <div class="footer-one">
        <div style="width:690px; padding-left:215px;">
            <div style="width:250px; float:left; padding-top:5px;">Huancayo</div>
            <div style="width:100px; float:left; padding-left:95px;">Huancayo</div>
        </div>
        <div style="width:690px; padding-left:200px; padding-top:10px;">Lima</div>
        <div style="width:690px; padding-left:300px; padding-top:13px;">Lima</div>
        <div style="width:690px; padding-left:250px; padding-top:12px;">Lima</div>
        <div style="width:690px; padding-left:145x; padding-top:63px;">
            <div style="float:left; width:170; float:left;">
                <div style="width:65px; float:left;">14</div>
                <div style="width:50px; float:left;">03</div>
                <div style="width:50px; float:left;">202</div>
            </div>
            <div style="width:350px; float:left; padding-left: 65px;">
                <div style="width:65px; float:left;">Huancayo</div>    
                <div style="width:65px; float:left;padding-left:50px;">14</div>
                <div style="width:100px; float:left;">Noviembre</div>
                <div style="width:50px; float:left;padding-left:17px;">20</div>
            </div>
        </div>
        
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
