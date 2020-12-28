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
            padding-top:230px;
        }
        .body-two {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:107px;
        }
        .footer-one {
            font-family: "Arial";
            font-size: 10pt;
            color:#000000;
            padding-top:28px; 
        }
    </style>
</head>
<body>
    <!--############################################## cabecera ###############################################################################-->
    <div class="header-one">
        <div style="padding-left:140px; padding-top:15px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:270px; padding-top:9px;">
            <div style="width:250px; float:left;">JUNIN</div>
            <div style="width:130px;padding-left:90px; float:left;">123456</div>
        </div>
        <div style="padding-left:155px; padding-top:2px;">
            <div style="width:150px; float:left;padding-left:20px;">12/12/2000</div>
            <div style="width:180px;padding-left:70px; float:left;">Ingenieria de sistemas</div>
        </div>
    </div>
    <div class="header-two">
        <div style="width:790px; padding-top:5px;">
            <div style="width: 350px; float:left; padding-left:140px;">
                EJERCICIO DE LA PROFESION
            </div>
            <div style="width: 150px; float:left; padding-left:110px;">
                SIN NOMBRE
            </div>
        </div>
        <div style="width:790px; padding-top:15px;">
            <div style="width: 350px; float:left; padding-left:140px;">
                SIN PROPIETARIO
            </div>
            <div style="width: 110px; float:left; padding-left:170px;">
                SIN MONTO
            </div>
        </div>
        <div style="padding-top:5px; width: 790px;">
            <div style="text-align:center; width:155px; padding-top: 17px; float:left; padding-left:120px; ">
                <div style="width: 40px; float:left; padding-left:16px;">31</div>
                <div style="width: 40px; float:left; padding-left:5px;">03</div>
                <div style="width: 40px; float:left; padding-left:10px;">2021</div>
            </div>
            <div style="width:512; float:left; padding-top: 19px;">
                <div style="width:120px; float:left;  padding-left:187px;">Huancayo</div>
                <div style="width:25px; float:left; padding-left:10px;">14</div>
                <div style="width:70px; float:left; padding-left:30px;">Noviembre</div>
                <div style="width:25px; float:left; padding-left:44px;">20</div>
            </div>
        </div>
    </div>
    <!--############################################### Fin de la cabecera #############################################################-->

    <!--########################################################## Cuerpo del documento ###################################################-->
    <div class="body-one">
        <div style="padding-left:240px; padding-top: 16px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:355px; padding-top: 9px;">JUNIN </div>
        <div style="padding-left:355px; padding-top:10px; width: 700px;">
            <div style="width: 150px; float:left;">123456</div>
            <div style="width: 100px; float:left; padding-left:155px;">08/09/2009</div>
        </div>
        <div style="padding-left:240px; padding-top: 7px;">Ingenieria de Sistemas </div>
    </div>
    <div class="body-two">
        <div style="padding-left:230px;">EJERCICIO DE LA PROFESION</div>
        <div style="padding-left:230px; padding-top:7px;">VARIOS </div>
        <div style="padding-left:240px; padding-top:31px;">RAHAMSIS CORREA GAMARRA</div>
        <div style="padding-left:260px; padding-top:7px;">CINCUENTA NUEVOS SOLES CON 00 SOLES </div>
    </div>
    <!--######################################### Fin Cuerpo del documento ##################################################################-->

    <!--################################################## Pie del Documento ###############################################################-->
    <div class="footer-one">
        <div style="width:690px; padding-left:225px;">
            <div style="width:250px; float:left; padding-top:1px;">Huancayo</div>
            <div style="width:100px; float:left; padding-left:95px; padding-top:2px;">Huancayo</div>
        </div>
        <div style="width:690px; padding-left:200px; padding-top:7px;">Lima</div>
        <div style="width:690px; padding-left:145x; padding-top:62px;">
            <div style="float:left; width:170; float:left;">
                <div style="width:65px; float:left;">14</div>
                <div style="width:50px; float:left;">03</div>
                <div style="width:50px; float:left;">2020</div>
            </div>
            <div style="width:360px; float:left; padding-left: 65px;">
                <div style="width:65px; float:left;">Huancayo</div>    
                <div style="width:65px; float:left;padding-left:50px;">14</div>
                <div style="width:100px; float:left;">Noviembre</div>
                <div style="width:50px; float:left;padding-left:27px;">20</div>
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
