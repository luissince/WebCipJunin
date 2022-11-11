<?php

/**
 * Class pdfCertCurso
 *
 * @filesource   pdfCertCurso.php
 * @created      3.10.2022
 * @author       Luis Alexander <alexanderlara1996@gmail.com>
 * @copyright    2022 Luis Alexander
 * @license      MIT
 */

use SysSoftIntegra\Src\QRImageWithLogo;
use chillerlan\QRCode\{QRCode, QROptions};
use SysSoftIntegra\Model\CursoAdo;
use SysSoftIntegra\Src\LogoOptions;
use SysSoftIntegra\Src\Tools;
use Mpdf\Mpdf;

require __DIR__ . './../src/autoload.php';

$result = CursoAdo::generarCertificado($_GET["idCurso"], $_GET["idParticipante"]);

if (!is_array($result)) {
    Tools::printErrorJson($result);
}

if (!is_object($result[0])) {
    Tools::printErrorJson("No se pudo procesar la información del curso, comuníquese con el administrador");
}

if (!is_object($result[1])) {
    Tools::printErrorJson("No se pudo procesar la información del decano o encargado, comuníquese con el administrador");
}

$curso = $result[0];
$decano =  $result[1];

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

$codbar = $uri . "/view/validatecurso.php?token=" . Tools::open_ssl_encrypt(array("idCurso" => $_GET["idCurso"], "idParticipante" => $_GET["idParticipante"]));

$options = new LogoOptions();

$qrOutputInterface = new QRImageWithLogo($options, (new QRCode($options))->getMatrix($codbar));

$html = '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>CERTIFICADO POR CURSO</title>
                <style>
                    
                    *{
                        padding: 0;
                        margin: 0;
                    }
                    body {
                        font-family: inter, cursive;
                        font-size: 9pt;
                        color:#000000;
                        background: #fcfdf8;
                    }
                    #headerCert{
                        position: relative;
                        height: 100%;
                        width: 100%;
                        background-image: url("fondoCertificadoCurso.jpg") no-repeat fixed center;
                        background-size: cover;
                    }

                    .border-top{
                        border-top: 1px solid black
                    }

                    .margin-0{
                        margin: 0px 0px 0px 0px;
                    }
                    
                    .font-anton{
                        font-family: anton;
                    }

                    .font-fjallaone{
                        font-family: fjallaone;
                    }
                    
                    .font-size-40{
                        font-size: 40pt;
                    }

                    .font-size-6{
                        font-size: 6pt;
                    }

                    .font-size-12{
                        font-size: 12pt;
                    }

                    .font-size-13{
                        font-size: 13pt;
                    }

                    .font-size-33{
                        font-size: 33pt;
                    }

                    .font-letter-spacing-4{
                        letter-spacing:4pt;
                    }

                    .font-letter-spacing-3{
                        letter-spacing:3pt;
                    }
                </style>
            </head>
            <body>
                <!--############################################## cabecera ###############################################################################-->
                <div id="headerCert">
                    <div style="background-color: transparent; text-align: center; padding-top: 170px; padding-bottom: 10px;">
                        <h1 class="font-anton font-size-40 font-letter-spacing-4 margin-0">CERTIFICADO</h1>
                    </div>      
                    
                    <div style="background-color: transparent; padding-left:160px; padding-top: 0px; padding-right:90px; ">
                        <p class="font-size-13 margin-0" style=" text-align: justify;">' . $curso->Titulo . '</p>
                    </div>

                    <div style="background-color: transparent; text-align: center; padding-top: 10px; padding-bottom: 0px;">
                        <h1 class="font-fjallaone font-size-33 font-letter-spacing-3 margin-0">' . $curso->Estudiante . '</h1>
                    </div>  
                    
                    <div style="width: 100%; background-color: transparent;">
                        <div style="width: 27%; float: left; background-color: transparent; text-align: right;">
                            <img width="160" height="160" src="' . $qrOutputInterface->dump(null, __DIR__ . '/logoemail.png') . '" />
                        </div>

                        <div style="width: 73%; float: left; background-color: transparent;">
                            <p class="font-size-12" style="text-align: justify;  margin-right: 90px; margin-top: 10px;">' . $curso->Detalle . '</p>
                        </div>
                    </div>

                    <div style="width: 100%; background-color: transparent;">
                        <div style="width: 40%; float: left; background-color: transparent; text-align: center;">
                            <span>' . $curso->Serie . '-' . $curso->Correlativo . '</span>
                        </div>
                    </div>

                    <div style=" background-color: transparerent; padding-right:90px;">
                        <p class="font-size-12 margin-0" style="text-align: right;">Huancayo, ' . Tools::MonthName(intval($curso->FechaMoth)) . ' de ' . $curso->FechaYear . '</p>
                    </div>

                    <div style="width: 100%; margin-top: 10px;">
                        <div style="width: 50%; float: left; text-align: center;">         
                            ' . ($decano->Ruta == "" ? "" : '<img width="196" height="90" style="background-color:transparent;" src="../resources/images/' . $decano->Ruta . '" /> ') . '
                               
                            <br />               
                            <span class="margin-0 border-top">ING. ' . $decano->Decano . '</span>
                            <br/>
                            <p class="margin-0 font-size-6">DECANO DEPARTAMENTAL DEL CIP-CDJ</p>
                        </div>

                        <div style="width: 50%; float: left; text-align: center;">
                            ' . ($curso->Ruta == "" ? "" : '<img width="196" height="90" style="background-color:transparent;" src="../resources/images/' . $curso->Ruta . '" /> ') . '
                            
                            <br />  
                            <span class="margin-0 border-top">ING. ' . $curso->Presidente . '</span>
                            <br/>
                            <p class="margin-0 font-size-6">PRESIDENTE DE CAPÍTULO ' . $curso->Capitulo . '</p>
                        </div>
                    </div>
                </div>                
            </body>
        </html>';

$mpdf = new Mpdf([
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 0,
    'margin_bottom' => 0,
    'margin_header' => 0,
    'margin_footer' => 0,
    'mode' => 'utf-8',
    'format' => 'A4',
    'orientation' => 'L'
]);
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle("CERTIFICADO PARA " . $curso->Estudiante . "");
$mpdf->SetAuthor("Cip Junin");
// $mpdf->SetWatermarkText(("ANULADO"));   // anulada
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha =  0.5;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output("CERTIFICADO PARA " . $curso->Estudiante . ".pdf", 'I');
