<?php

use SysSoftIntegra\Src\Tools;
use chillerlan\QRCode\QRCode;
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

date_default_timezone_set('America/Lima');

if (!isset($_GET["idIngreso"])) {
    Tools::printErrorJson("Url no valida");
}

$CertificadoHabilidad = IngresosAdo::ObtenerDatosPdfCertHabilidad($_GET["idIngreso"]);

if (!is_array($CertificadoHabilidad)) {
    Tools::printErrorJson($CertificadoHabilidad);
}

if (!is_object($CertificadoHabilidad[0])) {
    Tools::printErrorJson("No se pudo procesar la información del certificado, comuníquese con el administrador");
}

if (!is_object($CertificadoHabilidad[1])) {
    Tools::printErrorJson("No se pudo procesar la información del decano o encargado, comuníquese con el administrador");
}

$Datos = $CertificadoHabilidad[0];

$Nombreingeniero = $Datos->usuario;
$Apellidosingeniero = $Datos->apellidos;
$ConsejoDepartamental = 'JUNIN';
$NumeroCIP = $Datos->cip;

$FechaIncorporacion = $Datos->fechaIncorporacion;
$DiaIncorporacion = $Datos->fiDia;
$MesIncorporacion = $Datos->fiMes;
$AnioIncorporacion = $Datos->fiAnio;

$Especialidad = $Datos->especialidad;
$Asunto = $Datos->asunto;
$Entidad = $Datos->entidad;
$Lugar = $Datos->lugar;

$FechaVencimiento = $Datos->fechaVencimiento;
$DiaVencimiento = $Datos->fvDia;
$MesVencimiento = $Datos->fvMes;
$AnioVencimiento = $Datos->fvAnio;

$LugarRegistro = 'Huancayo'; //modificar****************************************************

$FechaRegistro = $Datos->fechaRegistro;
$DiaRegistro = $Datos->frDia;
$Mes = $Datos->frMes;
$numCertificado = $Datos->numCertificado;
$MesRegistro = IngresosAdo::getMothName($Mes);
$AnioRegistro = substr($Datos->frAnio, 2, 2);

$decano =  $CertificadoHabilidad[1];

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

$codbar = $uri . "/view/validatecert.php?token=" . Tools::open_ssl_encrypt(array("tipo" => "a", "idIngreso" => $_GET["idIngreso"]));

$html = '<html>
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
                        padding-top:70px;
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
                        padding-top:209px;
                    }
                    .body-two {
                        font-family: "Arial";
                        font-size: 10pt;
                        color:#000000;
                        padding-top:108px;
                    }
                    .footer-one {
                        font-family: "Arial";
                        font-size: 10pt;
                        color:#000000;
                        padding-top:76px;
                        text-align: center; 
                        padding-left: 386px;
                    }
                    .footer-two {
                        font-family: "Arial";
                        font-size: 10pt;
                        color:#000000;
                        padding-top:34px;  
                        padding-left:305px;
                    }

                    .background-div{
                        background-color:transparent;
                    }
                </style>
            </head>
            <body>
                <!--############################################## cabecera ###############################################################################-->
                <div class="header-one">
                    <div style="padding-left:140px; padding-top:5px;" class="background-div">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:270px; padding-top:9px;" class="background-div">
                        <div style="width:250px; float:left;">' . $ConsejoDepartamental . '</div>
                        <div style="width:130px;padding-left:110px; float:left;">' . $NumeroCIP . '</div>
                    </div>
                    <div style="padding-left:155px; padding-top:2px;">
                        <div style="width:150px; float:left;padding-left:10px;">' . $FechaIncorporacion . '</div>
                        <div style="width:360px;padding-left:100px; float:left;">' . $Especialidad . '</div>
                    </div>
                </div>
                <div class="header-two">
                    <div style="padding-left:120px;" class="background-div">' . $Asunto . '</div>
                    <div style="padding-left:120px; padding-top:5px; width: 510px;" class="background-div">' . $Entidad . '</div>
                    <div style="padding-left:120px; padding-top:5px; width: 700px;" class="background-div">
                        <div style="width:510px;float:left;" class="background-div">' . $Lugar . '</div>
                        <div style="text-align:center; width:145px; padding-top: 12px;" class="background-div">
                            <div style="width: 40px; float:right; padding-right:10px;">' . $AnioVencimiento . '</div>
                            <div style="width: 50px; float:right; padding-right:1px;">' . $MesVencimiento . '</div>
                            <div style="width: 40px; float:right;">' . $DiaVencimiento . '</div>
                        </div>
                    </div>
                    <div style="padding-top:12px;">
                        <div style="padding-left:470px; width:120px; float:left; text-align:center;" class="background-div">' . $LugarRegistro . '</div>
                        <div style="width:25px; float:left; padding-left:10px;" class="background-div">' . $DiaRegistro . '</div>
                        <div style="width:70px; float:left; padding-left:35px;" class="background-div">' . $MesRegistro . '</div>
                        <div style="width:25px; float:left; padding-left:37px;" class="background-div">' . $AnioRegistro . '</div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->

                <!--########################################################## Cuerpo del documento ###################################################-->
                <div class="body-one">
                    <div style="padding-left:240px; padding-top: 4px;" class="background-div">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:355px; padding-top:9px;" class="background-div">' . $ConsejoDepartamental . '</div>
                    <div style="padding-left:355px; padding-top:14px; width: 700px;" class="background-div">
                        <div style="width: 150px; float:left;">' . $NumeroCIP . '</div>
                        <div style="width: 100px; float:left; padding-left:155px;">' . $FechaIncorporacion . '</div>
                    </div>
                    <div style="padding-left:240px; padding-top:12px;" class="background-div">' . $Especialidad . '</div>
                </div>
                <div class="body-two">
                    <div style="padding-left:230px;" class="background-div">' . $Asunto . '</div>
                    <div style="padding-left:230px; padding-top:29px;" class="background-div">' . $Entidad . '</div>
                    <div style="padding-left:230px; padding-top:26px;" class="background-div">' . $Lugar . '</div>
                </div>
                <!--######################################### Fin Cuerpo del documento ##################################################################-->

                <!--################################################## Pie del Documento ###############################################################-->
                <div class="footer-one">
                    <div style="width:50; float:left;" class="background-div">' . $DiaVencimiento . '</div>
                    <div style="width:50; float:left; padding-left: 10px;" class="background-div">' . $MesVencimiento . '</div>
                    <div style="width:50; float:left; padding-left:5px;" class="background-div">' . $AnioVencimiento . '</div>
                </div>
                <div class="footer-two">
                    <div style="width:155; float:left;" class="background-div">' . $LugarRegistro . '</div>
                    <div style="width:65; float:left;" class="background-div">' . $DiaRegistro . '</div>
                    <div style="width:100; float:left;" class="background-div">' . $MesRegistro . '</div>
                    <div style="width:50; float:left; padding-left: 27px;" class="background-div">' . $AnioRegistro . '</div>
                </div>
                <div>
                    <span>
                        <img width="100" height="100" style="margin-left:160px;margin-top:35px;" src="' . (new QRCode)->render($codbar) . '" />
                    </span>
                    <span>
                    ' . ($decano->Ruta == "" ? "" : '<img width="196" height="90" style="margin-left:230px;margin-top:35px;background-color:transparent;" src="../resources/images/' . $decano->Ruta . '" /> ') . '
                    </span>           
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
$mpdf->Output("CERT HABILIDAD-" . $numCertificado . "-CIP-JUNIN.pdf", 'I');
