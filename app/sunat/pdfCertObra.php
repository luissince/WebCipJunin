<?php

use SysSoftIntegra\Src\Tools;
use chillerlan\QRCode\QRCode;

use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

setlocale(LC_TIME, 'Spanish_Peru');

if (!isset($_GET["idIngreso"])) {
    echo '<script>location.href = "404.php";</script>';
} else {

    $CertificadoObra = IngresosAdo::ObtenerDatosPdfCertObra($_GET["idIngreso"]);
    if (!is_array($CertificadoObra)) {
        echo $CertificadoObra;
    } else {
        $Datos = $CertificadoObra[0];

        $Nombreingeniero = $Datos['usuario'];
        $Apellidosingeniero = $Datos['apellidos'];
        $ConsejoDepartamental = 'JUNIN';
        $NumeroCIP = $Datos['cip'];

        $FechaIncorporacion = $Datos['fechaIncorporacion'];
        $DiaIncorporacion = $Datos['fiDia'];
        $MesIncorporacion = $Datos['fiMes'];
        $AnioIncorporacion = $Datos['fiAnio'];

        $Especialidad = $Datos['especialidad'];
        $Modalidad = $Datos['modalidad'];
        $Proyecto = $Datos['proyecto'];
        $Propietario = $Datos['propietario'];
        $Monto = number_format(round($Datos['monto'], 2, PHP_ROUND_HALF_UP), 2, '.', ',');
        $MontoenLetras = 'CINCUENTA NUEVOS SOLES CON 00 SOLES';
        $Departamento = $Datos['departamento'];
        $Provincia = $Datos['provincia'];
        $Distrito = $Datos['distrito'];

        $FechaVencimiento = $Datos['fechaVencimiento'];
        $DiaVencimiento = $Datos['fvDia'];
        $MesVencimiento = $Datos['fvMes'];
        $AnioVencimiento = $Datos['fvAnio'];

        $LugarRegistro = 'Huancayo'; //modificar****************************************************

        $FechaRegistro = $Datos['fechaRegistro'];
        $DiaRegistro = $Datos['frDia'];
        $Mes = $Datos['frMes'];
        $MesRegistro = IngresosAdo::getMothName($Mes);
        $AnioRegistro = substr($Datos['frAnio'], 2, 2);

        $token = Tools::my_encrypt($json, "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=CIPJUNIN");
        $codbar = "https://www.intranet.cip-junin.org.pe/view/validatecert.php?token=" . $token;

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
                        background-color:transparent;               
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
                        padding-top:100px;
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
                    <div style="padding-left:140px; padding-top:98px;">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:271px;padding-top:2px;">
                        <div style="width:250px; float:left;">' . $ConsejoDepartamental . '</div>
                        <div style="width:130px;padding-left:90px; float:left;">' . $NumeroCIP . '</div>
                    </div>
                    <div style="padding-left:155px; padding-top:6px;">
                        <div style="width:150px; float:left;padding-left:26px;">' . $FechaIncorporacion . '</div>
                        <div style="width:180px;padding-left:70px; float:left;">' . $Especialidad . '</div>
                    </div>
                </div>
                <div class="header-two">
                    <div style="width:100%; padding-top:1px;background-color:transparent;">
                        <div style="width: 350px; float:left; padding-left:120px;background-color:transparent;">' . $Modalidad . '</div>                     
                        <div style="width: 200px; float:left; padding-left:110px;background-color:transparent;">' . $Proyecto . '</div>
                    </div>
                    <div style="width:100%; padding-top:15px;">
                        <div style="width: 350px; float:left; padding-left:120px;">' . $Propietario . '</div>
                        <div style="width: 110px; float:left; padding-left:170px;">' . $Monto . '</div>
                    </div>
                    <div style="padding-top:5px; width: 100%;">
                        <div style="text-align:center; width:155px; padding-top: 15px; float:left; padding-left:120px; ">
                            <div style="width: 40px; float:left; padding-left:24px;">' . $DiaVencimiento . '</div>
                            <div style="width: 40px; float:left; padding-left:6px;">' . $MesVencimiento . '</div>
                            <div style="width: 40px; float:left; padding-left:3px;">' . $AnioVencimiento . '</div>
                        </div>
                        <div style="width:512; float:left; padding-top: 13px;">
                            <div style="width:120px; float:left;  padding-left:187px;background-color:transparent;">' . $LugarRegistro . '</div>
                            <div style="width:25px; float:left; padding-left:6px;background-color:transparent;">' . $DiaRegistro . '</div>
                            <div style="width:70px; float:left; padding-left:30px;background-color:transparent;">' . $MesRegistro . '</div>
                            <div style="width:25px; float:left; padding-left:30px;background-color:transparent;">' . $AnioRegistro . '</div>
                        </div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->
                        
                <!--########################################################## Cuerpo del documento ###################################################-->
                <div class="body-one">
                    <div style="padding-left:240px; padding-top: 4px;">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:355px; padding-top: 7px;">' . $ConsejoDepartamental . '</div>
                    <div style="padding-left:355px; padding-top:8px; width: 700px;">
                        <div style="width: 150px; float:left;">' . $NumeroCIP . '</div>
                        <div style="width: 100px; float:left; padding-left:155px;">' . $FechaIncorporacion . '</div>
                    </div>
                    <div style="padding-left:240px; padding-top: 7px;">' . $Especialidad . '</div>
                </div>
                <div class="body-two">
                    <div style="padding-left:210px; padding-top:2px;">' . $Modalidad . '</div>
                    <div style="padding-left:210px; padding-top:6px;">' . $Proyecto . '</div>
                    <div style="padding-left:210px; padding-top:27px;">' . $Propietario . '</div>
                    <div style="padding-left:250px; padding-top:6px;">' . $Monto . '</div>
                </div>
                <!--######################################### Fin Cuerpo del documento ##################################################################-->
                            
                <!--################################################## Pie del Documento ###############################################################-->
                <div class="footer-one">
                    <div style="width:690px; padding-left:225px;">
                        <div style="width:250px; float:left; padding-left:10px;">' . $Departamento . '</div>
                        <div style="width:100px; float:left; padding-left:95px; padding-top:1px;">' . $Provincia . '</div>
                    </div>
                    <div style="width:690px; padding-left:200px; padding-top:4px;">' . $Distrito . '</div>
                    <div style="width:690px; padding-left:145x; padding-top:60px;">
                        <div style="float:left; width:170; float:left;">
                            <div style="width:65px; float:left;padding-left:10px;">' . $DiaVencimiento . '</div> 
                            <div style="width:40px; float:left;padding-left:0px;">' . $MesVencimiento . '</div> 
                            <div style="width:40px; float:left;padding-left:10px;">' . $AnioVencimiento . '</div>
                        </div>
                        <div style="width:360px; float:left; padding-left: 65px;">
                            <div style="width:65px; float:left;background-color:transparent;">' . $LugarRegistro . '</div>    
                            <div style="width:65px; float:left;padding-left:50px;background-color:transparent;">' . $DiaRegistro . '</div>
                            <div style="width:100px; float:left;background-color:transparent;">' . $MesRegistro . '</div>
                            <div style="width:50px; float:left;padding-left:22px;background-color:transparent;">' . $AnioRegistro . '</div>
                        </div>
                    </div>

                </div>
                <!--<div>
                    <span>
                        <img width="100" height="100" style="margin-left:160px;margin-top:35px;" src="' . (new QRCode)->render($codbar) . '" />
                    </span>
                    <span>
                        <img width="196" height="90" style="margin-left:230px;margin-top:35px;background-color:transparent;" src="firmadecano.png" />
                    </span>           
                </div>-->
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

        // $mpdf->SetProtection(array('print'));
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
    }
}
