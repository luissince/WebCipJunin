<?php
use SysSoftIntegra\Model\IngresosAdo;
use SysSoftIntegra\Src\Tools;

require __DIR__ . './../src/autoload.php';

setlocale(LC_TIME, 'Spanish_Peru');

if (!isset($_GET["idIngreso"])) {
    echo '<script>location.href = "404.php";</script>';
} else {

    $CertificadoProyecto = IngresosAdo::ObtenerDatosPdfCertProyecto($_GET["idIngreso"]);
    if (!is_array($CertificadoProyecto)) {
        echo $CertificadoProyecto;
    } else {
        $Datos = $CertificadoProyecto[0];

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
        $Monto = $Datos['monto'];
        $MontoenLetras = 'CINCUENTA NUEVOS SOLES CON 00 SOLES';
        $Departamento = $Datos['departamento'];
        $Provincia = $Datos['provincia'];
        $Distrito = $Datos['distrito'];
        $UrbAahhPpjjAsoc = $Datos['adicional1'];
        $JrAvCallePasaje = $Datos['adicional2'];

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

        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
            $uri = 'https://';
        } else {
            $uri = 'http://';
        }
        $uri .= $_SERVER['HTTP_HOST'];

        $token = Tools::my_encrypt($json, "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=CIPJUNIN");
        $codbar = $uri . "/view/validatecert.php?token=" . $token;

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
                    <div style="padding-left:140px; padding-top:15px;">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:270px; padding-top:9px;">
                        <div style="width:250px; float:left;">' . $ConsejoDepartamental . '</div>
                        <div style="width:130px;padding-left:110px; float:left;">' . $NumeroCIP . '</div>
                    </div>
                    <div style="padding-left:155px; padding-top:2px;">
                        <div style="width:150px; float:left;padding-left:20px;">' . $FechaIncorporacion . '</div>
                        <div style="width:180px;padding-left:90px; float:left;">' . $Especialidad . '</div>
                    </div>
                </div>
                <div class="header-two">
                    <div style="width:790px; padding-top:5px;">
                        <div style="width: 350px; float:left; padding-left:140px;">' . $Proyecto . '</div>
                    </div>
                    <div style="width:790px; padding-top:15px;">
                        <div style="width: 350px; float:left; padding-left:140px;">' . $Propietario . '</div>
                    </div>
                    <div style="padding-top:5px; width: 790px;">
                        <div style="text-align:center; width:145px; padding-top: 17px; float:left; padding-left:120px; ">
                            <div style="width: 40px; float:left; padding-left:16px;">' . $DiaVencimiento . '</div>
                            <div style="width: 40px; float:left; padding-left:5px;">' . $MesVencimiento . '</div>
                            <div style="width: 40px; float:left;">' . $AnioVencimiento . '</div>
                        </div>
                        <div style="width:520; float:left; padding-top: 19px;">
                            <div style="width:120px; float:left;  padding-left:197px;">' . $LugarRegistro . '</div>
                            <div style="width:25px; float:left; padding-left:10px;">' . $DiaRegistro . '</div>
                            <div style="width:70px; float:left; padding-left:30px;">' . $MesRegistro . '</div>
                            <div style="width:25px; float:left; padding-left:40px;">' . $AnioRegistro . '</div>
                        </div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->

                <!--########################################################## Cuerpo del documento ###################################################-->
                <div class="body-one">
                    <div style="padding-left:240px; padding-top: 4px;">' . $Nombreingeniero . ' ' . $Apellidosingeniero . '</div>
                    <div style="padding-left:355px; padding-top:10px;">' . $ConsejoDepartamental . '</div>
                    <div style="padding-left:355px; padding-top:15px; width: 700px;">
                        <div style="width: 150px; float:left;">' . $NumeroCIP . '</div>
                        <div style="width: 100px; float:left; padding-left:155px;">' . $FechaIncorporacion . '</div>
                    </div>
                    <div style="padding-left:240px; padding-top:12px;">' . $Especialidad . '</div>
                </div>
                <div class="body-two">
                    <div style="padding-left:270px;">' . $Propietario . '</div>
                    <div style="padding-left:260px; padding-top:10px;">' . $Proyecto . '</div>
                </div>
                <!--######################################### Fin Cuerpo del documento ##################################################################-->

                <!--################################################## Pie del Documento ###############################################################-->
                <div class="footer-one">
                    <div style="width:690px; padding-left:215px;">
                        <div style="width:250px; float:left; padding-top:5px;">' . $Departamento . '</div>
                        <div style="width:100px; float:left; padding-left:95px;">' . $Provincia . '</div>
                    </div>
                    <div style="width:690px; padding-left:200px; padding-top:10px;">' . $Distrito . '</div>
                    <div style="width:690px; padding-left:300px; padding-top:13px;">' . $UrbAahhPpjjAsoc . '</div>
                    <div style="width:690px; padding-left:250px; padding-top:12px;">' . $JrAvCallePasaje . '</div>
                    <div style="width:690px; padding-left:145x; padding-top:63px;">
                        <div style="float:left; width:170; float:left;">
                            <div style="width:65px; float:left;">' . $DiaVencimiento . '</div>
                            <div style="width:50px; float:left;">' . $MesVencimiento . '</div>
                            <div style="width:50px; float:left;">' . $AnioVencimiento . '</div>
                        </div>
                        <div style="width:350px; float:left; padding-left: 65px;">
                            <div style="width:65px; float:left;">' . $LugarRegistro . '</div>    
                            <div style="width:65px; float:left;padding-left:50px;">' . $DiaRegistro . '</div>
                            <div style="width:100px; float:left;">' . $MesRegistro . '</div>
                            <div style="width:50px; float:left;padding-left:17px;">' . $AnioRegistro . '</div>
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
    }
}
