<?php
setlocale(LC_TIME, 'Spanish_Peru');

if (!isset($_GET["idIngreso"])) {
    echo '<script>location.href = "404.php";</script>';
} else {
    
    define('_MPDF_PATH', '/lib');
    require('./lib/mpdf/vendor/autoload.php');
    include_once('../model/IngresosAdo.php');

    $CertificadoHabilidad = IngresosAdo::ObtenerDatosPdfCertHabilidad($_GET["idIngreso"]);
    if (!is_array($CertificadoHabilidad)) {
        echo $CertificadoHabilidad;
    } else {
        $Datos = $CertificadoHabilidad[0];

        $Nombreingeniero = $Datos['usuario'];
        $Apellidosingeniero = $Datos['apellidos'];
        $ConsejoDepartamental = 'JUNIN';
        $NumeroCIP = $Datos['cip'];

        $FechaIncorporacion = $Datos['fechaIncorporacion'];
        $DiaIncorporacion = $Datos['fiDia'];
        $MesIncorporacion = $Datos['fiMes'];
        $AnioIncorporacion = $Datos['fiAnio'];

        $Especialidad = $Datos['especialidad'];
        $Asunto = $Datos['asunto'];
        $Entidad = $Datos['entidad'];
        $Lugar = $Datos['lugar'];

        $FechaVencimiento = $Datos['fechaVencimiento'];
        $DiaVencimiento = $Datos['fvDia'];
        $MesVencimiento = $Datos['fvMes'];
        $AnioVencimiento = $Datos['fvAnio'];

        $LugarRegistro = 'Huancayo'; //modificar****************************************************

        $FechaRegistro = $Datos['fechaRegistro'];
        $DiaRegistro = $Datos['frDia'];
        $Mes = $Datos['frMes'];
        $MesFormat = DateTime::createFromFormat('!m', $Mes);
        $MesRegistro = strftime("%B", $MesFormat->getTimestamp());
        $AnioRegistro = substr($Datos['frAnio'],2,2);

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
                </style>
            </head>
            <body>
                <!--############################################## cabecera ###############################################################################-->
                <div class="header-one">
                    <div style="padding-left:140px; padding-top:5px;">'.$Nombreingeniero.' '.$Apellidosingeniero.'</div>
                    <div style="padding-left:270px; padding-top:9px;">
                        <div style="width:250px; float:left;">'.$ConsejoDepartamental.'</div>
                        <div style="width:130px;padding-left:110px; float:left;">'.$NumeroCIP.'</div>
                    </div>
                    <div style="padding-left:155px; padding-top:2px;">
                        <div style="width:150px; float:left;padding-left:10px;">'.$FechaIncorporacion.'</div>
                        <div style="width:360px;padding-left:100px; float:left;">'.$Especialidad.'</div>
                    </div>
                </div>
                <div class="header-two">
                    <div style="padding-left:120px;">'.$Asunto.'</div>
                    <div style="padding-left:120px; padding-top:5px; width: 510px;">'.$Entidad.'</div>
                    <div style="padding-left:120px; padding-top:5px; width: 700px;">
                        <div style="width:510px;float:left;">'.$Lugar.'</div>
                        <div style="text-align:center; width:145px; padding-top: 12px;">
                            <div style="width: 40px; float:right; padding-right:10px;">'.$AnioVencimiento.'</div>
                            <div style="width: 50px; float:right; padding-right:1px;">'.$MesVencimiento.'</div>
                            <div style="width: 40px; float:right;">'.$DiaVencimiento.'</div>
                        </div>
                    </div>
                    <div style="padding-top:12px;">
                        <div style="padding-left:470px; width:120px; float:left; text-align:center;">'.$LugarRegistro.'</div>
                        <div style="width:25px; float:left; padding-left:10px;">'.$DiaRegistro.'</div>
                        <div style="width:70px; float:left; padding-left:35px;">'.$MesRegistro.'</div>
                        <div style="width:25px; float:left; padding-left:37px;">'.$AnioRegistro.'</div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->

                <!--########################################################## Cuerpo del documento ###################################################-->
                <div class="body-one">
                    <div style="padding-left:240px; padding-top: 4px;">'.$Nombreingeniero.' '.$Apellidosingeniero.'</div>
                    <div style="padding-left:355px; padding-top:9px;">'.$ConsejoDepartamental.'</div>
                    <div style="padding-left:355px; padding-top:14px; width: 700px;">
                        <div style="width: 150px; float:left;">'.$NumeroCIP.'</div>
                        <div style="width: 100px; float:left; padding-left:155px;">'.$FechaIncorporacion.'</div>
                    </div>
                    <div style="padding-left:240px; padding-top:12px;">'.$Especialidad.'</div>
                </div>
                <div class="body-two">
                    <div style="padding-left:230px;">'.$Asunto.'</div>
                    <div style="padding-left:230px; padding-top:29px;">'.$Entidad.'</div>
                    <div style="padding-left:230px; padding-top:26px;">'.$Lugar.'</div>
                </div>
                <!--######################################### Fin Cuerpo del documento ##################################################################-->

                <!--################################################## Pie del Documento ###############################################################-->
                <div class="footer-one">
                    <div style="width:50; float:left;">'.$DiaVencimiento.'</div>
                    <div style="width:50; float:left; padding-left: 10px;">'.$MesVencimiento.'</div>
                    <div style="width:50; float:left; padding-left:5px;">'.$AnioVencimiento.'</div>
                </div>
                <div class="footer-two">
                    <div style="width:155; float:left;">'.$LugarRegistro.'</div>
                    <div style="width:65; float:left;">'.$DiaRegistro.'</div>
                    <div style="width:100; float:left;">'.$MesRegistro.'</div>
                    <div style="width:50; float:left; padding-left: 27px;">'.$AnioRegistro.'</div>
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
    }
}
