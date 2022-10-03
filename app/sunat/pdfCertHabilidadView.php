<?php

use SysSoftIntegra\Src\Tools;
use chillerlan\QRCode\QRCode;
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

// setlocale(LC_TIME, 'Spanish_Peru');

if (!isset($_GET["idIngreso"])) {
    Tools::printErrorJson("Url no valida");
}

$CertificadoHabilidad = IngresosAdo::ObtenerDatosPdfCertHabilidad($_GET["idIngreso"]);

if (!is_array($CertificadoHabilidad)) {
    Tools::printErrorJson($CertificadoHabilidad);
}

if(!is_object($CertificadoHabilidad[0])){
    Tools::printErrorJson("No se pudo procesar la información del certificado, comuníquese con el administrador");
}

if(!is_object($CertificadoHabilidad[1])){
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
$sesentaEspacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$veinteEspacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$cincoEspacios = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$tresEspacios = '&nbsp;&nbsp;&nbsp;';

$decano =  $CertificadoHabilidad[1];

$json = json_encode(array(
    "tipo" => "a",
    "idIngreso" => $_GET["idIngreso"]
));

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

$token = Tools::my_encrypt($json, "bRuD5WYw5wd0rdHR9yLlM6wt2vteuiniQBqE70nAuhU=CIPJUNIN");
$codbar = $uri . "/view/validatecert.php?token=" . $token;

$newNumCetificado = Tools::formatNumber($numCertificado);

$html = '<html>
            <head>
                <style>
                    body {
                        font-family: Comic Sans;
                        font-size: 9pt;
                        color:#44413f;
                        background: #fcfdf8;
                    }
                    #headerCert{
                        height: 20%;
                        width: 100%;
                        background-image: url("cabeceraCertificado.png") no-repeat fixed center;
                        background-size: cover;
                    }
                    #bodyCert{
                        height: 73.3%;
                        width: 100%;
                        background-image: url("fondoCertificados.png") no-repeat fixed center;
                        background-size: cover;
                        font-size:9.5pt;
                        background-repeat: no-repeat;
                    }
                    
                </style>
            </head>
            <body>
                <!--############################################## cabecera ###############################################################################-->
                <div id="headerCert">
                    <div style="width:100%; height:7.5%;text-align: left;">
                        <div style="width:22%; height:7.5%;; float:left; text-align:center;">                          
                             <img src="logoCipJunin.png" alt="" width="70px"; height="70px" style="padding-top:10px;">                                                  
                        </div>
                        <div style="width:55%; height:7.5%; float:left">
                            <div style="color: #c55f52; text-decoration: underline; font-size:14px; font-weight:bold; width:100%; text-align:center; padding-top:20px;">
                                COLEGIO DE INGENIEROS DEL PERÚ
                            </div>
                            <div style="color: #c55f52; font-size:17px; font-weight:bold; width:100%; text-align:center; padding-top:5px;">
                                Certificado De Habilidad
                            </div>
                        </div>
                        <div style="width:20%; height:7.5%; float:left">
                            <img src="../../view/barcode/barcode.php?text=N+A-' . $newNumCetificado . '&size=50&print=true" alt="" width="114px"; height="59px" style="padding-top:30px; padding-left:33px;">
                        </div>
                    </div>
                    <div style="width:100%; padding-left: 42px;" face:"georgia";>
                        El ingeniero (a): <strong>' . $tresEspacios . $Nombreingeniero . ' ' . $Apellidosingeniero . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 5px;">
                        Adscrito al Consejo Departamental de: <strong>' . $tresEspacios . $ConsejoDepartamental . ' </strong>' . $sesentaEspacios . 'Registro CIP N°: <strong>' . $tresEspacios . $NumeroCIP . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 5px;">
                        Fecha de Incorporación: <strong>' . $tresEspacios . $FechaIncorporacion . '</strong>' . $sesentaEspacios . 'Especialidad: <strong>' . $tresEspacios . $Especialidad . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 42px; padding-top: 8px;">
                        EL INGENIERO SE ENCUENTRA COLEGIADO Y HÁBIL, para el siguiente detalle:
                    </div>
                    <div style="width:100%; padding-left: 25px; padding-top: 8px;">
                        <div style="width:12%; font-weight:bold; float:left; text-align:center;padding-top:5px; font-size:8pt;">ASUNTO</div>
                        <div style="width:83%; border:1px solid black; float:left; height:25px;"><div style="margin-top:4px">' . $cincoEspacios . '<strong>' . $Asunto . '</div><strong></div>
                    </div>
                    <div style="width:74%; padding-left: 25px; padding-top: 3px; float:left;">
                        <div style="width:100%;">
                            <div style="width:15.5%; font-weight:bold; float:left; text-align:center; font-size:8pt;">ENTIDAD O <br> PROPIETARIO</div>
                            <div style="width:83.5%; border:1px solid black; float:left; height:25px;"><div style="margin-top:4px">' . $cincoEspacios . '<strong>' . $Entidad . '</div><strong></div>
                        </div>
                        <div style="width:100%; padding-top: 0px;">
                            <div style="width:15.5%; font-weight:bold; float:left; text-align:center; font-size:8pt; padding-top:5px">LUGAR </div>
                            <div style="width:83.5%; border:1px solid black; float:left; height:25px;"><div style="margin-top:4px">' . $cincoEspacios . '<strong>' . $Lugar . '</div><strong></div>
                        </div>
                    </div>
                    <div style="width:20%; float:left;">
                        <table style="width:90%; border-collapse: collapse; margin-top:3px;">
                            <tr>
                                <th colspan="3" style="color:white; border:1px solid #c55f52; background:#c55f52; width:60px; height: 25px; font-size:9px; margin-left:0">El presente documento tiene <br>vigencia hasta</th>      
                            </tr>
                            <tr>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Día</td>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Mes</td>
                                <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">AÑO</td>
                            </tr>
                            <tr>
                                <td style="width:20px; height:22px; text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $DiaVencimiento . '</strong></td>
                                <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $MesVencimiento . '</strong></td>
                                <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $AnioVencimiento . '</strong></td>
                            </tr>
                        </table>
                    </div>
                    <div style="width:100%; height:20px; padding-left: 42px; padding-top: 5px;">
                        <div style="float:left; width:40%; height:20px; padding-left: 2px;">

                        </div>
                        <div style="float:left; width:55%; height:20px; margin-top: 3px; text-align:right;">
                                <strong>' . $LugarRegistro . $cincoEspacios . $DiaRegistro . $tresEspacios . '</strong>, de<strong>' . $tresEspacios . $MesRegistro . $tresEspacios . '</strong> del 20<strong>' . $AnioRegistro . '</strong>
                        </div>
                    </div>
                </div>
                <!--############################################### Fin de la cabecera #############################################################-->

                <!--########################################################## Cuerpo del documento ###################################################-->
                <div id="bodyCert">
                    <div style="width:100%;text-align: left; margin-top:30px;">
                        <div style="width:27%; height:7.5%; float:left; text-align:right;">
                            <div>
                                <img src="logoCipJunin.png" alt="" width="90px"; height="90px" style="padding-top:10px;">
                            </div>
                            <div style="font-size:10px; width:95%;">Ley N° 24648 </div>                                             
                        </div>
                        <div style="width:53%; height:7.5%; float:left; padding-left:10px;">
                            <div style="color: #c55f52; text-decoration: underline; font-size:14px; font-weight:bold; width:100%; text-align:center; padding-top:25px;">
                                COLEGIO DE INGENIEROS DEL PERÚ
                            </div>
                            <div style="color: #c55f52; font-size:22px; font-weight:bold; width:100%; text-align:center; padding-top:10px;">
                                Certificado De Habilidad
                            </div>
                        </div>
                        <div style="width:18%; height:7.5%; float:left">
                            <img src="../../view/barcode/barcode.php?text=N+A-' . $newNumCetificado . '&size=50&print=true" alt="" width="114px"; height="59px" style="padding-top:30px;">
                        </div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top:10px;">
                        Los que suscriben certifican que:
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top:10px;">
                        El ingeniero (a) :<strong>' . $tresEspacios . $Nombreingeniero . ' ' . $Apellidosingeniero . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Adscrito al Consejo Departamental de: <strong>' . $tresEspacios . $ConsejoDepartamental . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Con Registro de Matrícula del CIP N°: <strong>' . $tresEspacios . $NumeroCIP . $veinteEspacios . '</strong>Fecha de Incorporación: <strong>' . $tresEspacios . $FechaIncorporacion . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 10px;">
                        Especialidad: <strong>' . $tresEspacios . $Especialidad . '</strong>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 20px; font-size:8.7pt;">
                        De conformidad con la Ley N° 28858, Ley que complementa a la Ley N° 16053 del Ejercicio Profesional y el Estatuto                        
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 2px; font-size:8.9pt;">
                    del Colegio de Ingenieros Del Perú, SE ENCUENTRA COLEGIADO Y HÁBIL, en consecuencia está autorizado para <br>
                    ejercer la profesión de Ingeniero(a).
                    </div>                 
                    <div style="width:100%; padding-left: 135px; padding-top: 25px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center;padding-top:8px; font-size:8pt;">ASUNTO</div>
                        <div style="width:80%; border:1px solid black; float:left; height:35px;"><div style="margin-top:9px">' . $cincoEspacios . '<strong>' . $Asunto . '</div></div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 8px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center; font-size:8pt;">ENTIDAD <br> O <br> PROPIETARIO</div>
                        <div style="width:80%; border:1px solid black; float:left; padding-top:8px; height:30px;"><div style="margin-top:3px">' . $cincoEspacios . '<strong>' . $Entidad . '</div></div>
                    </div>
                    <div style="width:100%; padding-left: 135px; padding-top: 5px;">
                        <div style="width:15%; font-weight:bold; float:left; text-align:center;padding-top:5px; font-size:8pt;">LUGAR</div>
                        <div style="width:80%; border:1px solid black; float:left; height:35px;"><div style="margin-top:10px">' . $cincoEspacios . '<strong>' . $Lugar . '</div></div>
                    </div>
                    <!--######################################### Fin Cuerpo del documento ##################################################################-->

                    <!--################################################## Pie del Documento ###############################################################-->
                    <div style="width:100%; padding-left: 135px; padding-top:20px;">
                        <div style="width:30%; height:40px; padding-left: 200px;">
                            <table style="width:90%; border-collapse: collapse;">
                                <tr>
                                    <th colspan="3" style="color:white; border:1px solid #c55f52; background:#c55f52; width:60px; height: 35px; font-size:9px; margin-left:0">El presente documento tiene <br>vigencia hasta</th>      
                                </tr>
                                <tr>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Día</td>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">Mes</td>
                                    <td style="width:20px; height:15px;  font-size:9px; text-align:center; border:1px solid #c55f52; border-bottom:0;">AÑO</td>
                                </tr>
                                <tr>
                                    <td style="width:20px; height:22px; text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $DiaVencimiento . '</strong></td>
                                    <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $MesVencimiento . '</strong></td>
                                    <td style="width:20px; height:22px;  text-align:center; border:1px solid #c55f52; border-top:0; font-size:10px;"><strong>' . $AnioVencimiento . '</strong></td>
                                </tr>
                            </table>
                        </div>
                        <div style=" width:70%; height:30px;  padding-top:35px; font-size:11pt; font-weight:bold; padding-left:135px">
                        <strong>' . $LugarRegistro . $cincoEspacios . $DiaRegistro . $tresEspacios . '</strong>, de<strong>' . $tresEspacios . $MesRegistro . $tresEspacios . '</strong> del 20<strong>' . $AnioRegistro . '</strong>
                        </div>
                        <div style=" width:70%; height:20px;  padding-top:0px; font-size:14pt; font-weight:bold; padding-left:170px">
                            VÁLIDO SOLO ORIGINAL
                        </div>
                        <div style="width:100%; height:auto;  padding-top:0px; font-size:9pt; font-weight:bold; padding-bottom:0px!important">
                            <div style="float:left; width:16%;">
                                <img width="90" height="90" style="margin-left:15px; margin-top:0px;" src="' . (new QRCode)->render($codbar) . '" />
                            </div>
                            <div style="float:left; width:35%; text-align:center; padding-left:0px; margin-top:10px; font-size:9px;">
                                <img width="166" height="60" style="margin-left:10px; background-color:transparent; margin-bottom:-8px;" src="firmanacional.png" />
                                _____________________________________________<br><br>
                                Ing. Maria del Carmen Ponce Mejia<br> Decana Nacional <br> Colegio de Ingenieros del Perú
                            </div>
                            <div style="float:left; width:35%; text-align:center; padding-left:0px; font-size:9px;">
                                <img width="166" height="60" style="margin-left:10px; background-color:transparent; margin-bottom:-8px;" src="firmadecano.png" />
                            _____________________________________________<br><br>
                                Consejo Departamental <br> del Colegio de Ingenieros del Perú
                            </div>
                        </div>
                    </div>
                    <!--################################################## Fin del Pie del Documento ###############################################################-->
                </div>                
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
