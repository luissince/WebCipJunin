<?php

use SysSoftIntegra\Src\QRImageWithLogo;
use chillerlan\QRCode\{QRCode, QROptions};
use Mpdf\Mpdf;

require __DIR__ . './../src/autoload.php';


$data = 'https://www.youtube.com/watch?v=DLzxrzFCyOs&t=43s';

class LogoOptions extends QROptions
{
    protected int $logoSpaceWidth;
    protected int $logoSpaceHeight;
}

$options = new LogoOptions;

$options->version          = 7;
$options->eccLevel         = QRCode::ECC_H;
$options->imageBase64      = true;
$options->logoSpaceWidth   = 13;
$options->logoSpaceHeight  = 13;
$options->scale            = 5;
$options->imageTransparent = true;

$qrOutputInterface = new QRImageWithLogo($options, (new QRCode($options))->getMatrix($data));

$html = '<html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
                <title>Mi pdf</title>
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
                        <p class="font-size-13 margin-0" style=" text-align: justify;">El Decano del Consejo Departamental de Junín del Colegio de Ingenieros del Perú, otorga el presente certificado a:</p>
                    </div>
                    <div style="background-color: transparent; text-align: center; padding-top: 10px; padding-bottom: 0px;">
                        <h1 class="font-fjallaone font-size-33 font-letter-spacing-3 margin-0">FRANCISCO CYL GODIÑO POMA</h1>
                    </div>  
                    <div style="width: 100%; background-color: transparent;">
                        <div style="width: 27%; float: left; background-color: transparent; text-align: right;">
                            <img width="160" height="160" src="' . $qrOutputInterface->dump(null, __DIR__.'/logoemail.png') . '" />
                        </div>

                        <div style="width: 73%; float: left; background-color: transparent;">
                            <p class="font-size-12" style="text-align: justify;  margin-right: 90px; margin-top: 10px;">En merito a su participación como <strong>ORGANIZADOR</strong> del evento por el día del campesino realizado por el Capitulo de Ingenieria Agrinómica del Colegio de Ingenieros del Perú - Consejo Departamental de Junín, realizado en la cuidad de Huancayo los días 24 de Junio del presente año, con una duración de 32 horas lectivas.</p>
                        </div>
                    </div>
                    <div style=" background-color: transparerent; padding-right:90px;">
                        <p class="font-size-12 margin-0" style="text-align: right;">Huancayo, Julio de 2022</p>
                    </div>
                    <div style="width: 100%; margin-top: 70px;">
                        <div style="width: 50%; float: left; text-align: center;">                            
                            <span class="margin-0 border-top">ING. FRANCISCO CYL GODIÑO POMA</span>
                            <br/>
                            <p class="margin-0 font-size-6">DECANO DEPARTAMENTAL DEL CIP-CDJ</p>
                        </div>

                        <div style="width: 50%; float: left; text-align: center;">
                            <span class="margin-0 border-top">ING. JOVINO ACOSTA MENDOZA</span>
                            <br/>
                            <p class="margin-0 font-size-6">PRESIDENTE DE CAPÍTULO AGRONÓMICA</p>
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
$mpdf->SetTitle(" CIP-JUNIN");
$mpdf->SetAuthor("Cip Junin");
// $mpdf->SetWatermarkText(("ANULADO"));   // anulada
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha =  0.5;
$mpdf->SetDisplayMode('fullpage');
$mpdf->WriteHTML($html);

// Output a PDF file directly to the browser
$mpdf->Output("CERT HABILIDAD-CIP-JUNIN.pdf", 'I');