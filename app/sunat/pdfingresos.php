<?php
if (!isset($_GET["idIngreso"])) {
    echo '<script>location.href = "404.php";</script>';
} else {
    define('_MPDF_PATH', '/lib');
    require('./lib/mpdf/vendor/autoload.php');
    include('../src/GenerateCoinToLetters.php');
    require_once("./lib/phpqrcode/qrlib.php");
    include_once('../model/IngresosAdo.php');

    $detalleventa = IngresosAdo::ObtenerIngresoXML($_GET["idIngreso"]);
    if (!is_array($detalleventa)) {
        echo $detalleventa;
    } else {
        if (!isset($detalleventa[3])) {
            echo 'Hay con valores nulos en el registro de empresa, por favor corregir.';
        } else {
            $ingreso = $detalleventa[0];
            $detalleIngreso = $detalleventa[1];
            $cuotas = $detalleventa[2];
            $empresa = $detalleventa[3];
            $totales = $detalleventa[4];

            $rutaImage = "../../view/images/logologin.png";
            $nombre = $empresa->RazonSocial;
            $direccion = $empresa->Domicilio;
            $web = $empresa->PaginaWeb;
            $email = $empresa->Email;
            $telefono = "Tesorería " . $empresa->Telefono . " Anexo 202";
            $ruc = $empresa->NumeroDocumento;

            $gcl = new GenerateCoinToLetters();

            $textoCodBar =
                '|' . $ruc
                . '|' . $ingreso->TipoComprobante
                . '|' . $ingreso->Serie
                . '|' . $ingreso->Numeracion
                . '|' . number_format(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
                . '|' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
                . '|' . $ingreso->FechaEmision
                . '|' . $ingreso->TipoDocumento
                . '|' . $ingreso->NumeroDocumento
                . '|';

            $qrCode = QrCode::png($textoCodBar, 'codbar.png', 'L', 4, 2);

            $html .= '<html>
            <head>
                <style>
                    body {
                        font-family: "Arial";
                        font-size: 10pt;
                        color:#000000;
                    }
                    .cont-header{
                        padding-bottom:10px;
                        border-bottom: 1px solid #000000;
                    }
                    .caja-info-cero{
                        float:left;
                        width:20%;
                        height:120px;
                        text-align: center;
                    }
                    .caja-info-uno{
                        float:left;
                        width:50%;
                        height:120px;
                    }
                    .texto{
                        text-align:center;
                        font-size:11px;   
                        padding-top: 15px;         
                        padding-left: 0px;
                    
                    }
                    .caja-info-dos{
                        float:right; 
                        width: 29%;
                        height:auto;  
                        text-align: center;
                        padding-top: 20px; 
                    }
                    .container-info{
                    width: 100%;  height:100px;  margin-top: 6px;
                    }
                    .caja-one{
                        float: left;  width:100%;
                    }
                    .caja-two{
                        display: block; float:left; width: 100%;   height: 110px;  padding-top: 5px;
                    }
                    .caja-three{
                        display: block; float:left; width: 33%;   height: 110px;  padding-top: 10px;
                    }
                    .caja-four{
                        display: block; float:left; width: 33%;   height: 110px; padding-top: 10px;
                    }
                    .detalle-compra{
                        margin-top:10px;
                        width: 100%;
                        height: 52%;
                    }
                    p {	
                        margin: 0pt; 
                    }
                    table.items {
	                    border: 1px solid #000000;
                    }
                    td { 
                        vertical-align: center; 
                    }
                    .items td {
	                    border-left: 0px solid #E11E1E;
                    }
                    table thead td { 
                        background-color: #B4B6B4;
	                    text-align: center;
	                    border: 1px solid #000000;
	                    font-variant: small-caps;
                    }
                    table tbody td{
                        text-align: center;
	                    font-variant: small-caps;
                    }
                    .items td.blanktotal {
                        border: 1px solid #000000;
                        background-color: #FFFFFF;
                        border-top: 1px solid #000000;
                        border-right: 1px solid #000000;
                    }
                    .items td.totals {
                        text-align: right;
                        padding:5px;
                    }
                    .items td.simbolo{

                    }
                    .items td.costt {            
                        text-align: "." center;

                    }
                    .items td.cost {           
                        text-align: center;
                        font-weight: bold;
                    }
                    .items td.qr {
                        border: 0px;
                    }
                    .items td.estado {
                        border: 0px;
                        text-align:center;
                        font-size: 16px;
                    }
                    footer {
                        color: #000000;
                        width: 100%;
                        position: absolute;
                        left: 0;
                        bottom: 0;
                        border-top: 1px solid #AAAAAA;
                        padding: 10px;
                        text-align: center;
                        content: "";
                        clear: both;
                    }
    
                </style>
            </head>
            <body>
                <!--#####################cabecera###################################-->
                <div class="cont-header">
                    <div class="caja-info-cero">
                        <img src="' . $rutaImage . '" style="width:70%;"><br>
                        <span style="font-size:10pt;font-style: italic;color: #b72928;font-weight: bold;">"A más Ingeniería, Cero corrupción"</span>
                    </div>
                    <div class="caja-info-uno">
                        <div class="my-img" >                
                            <div class="texto">
                                <b style="font-size:13pt; ">' . $nombre . '</b><br>                 
                                <span style="font-size:10pt;">' . $direccion . '</span><br> 
                                <span style="font-size:10pt;">Teléfono: ' . $telefono . '</span><br> 
                                <span style="font-size:10pt;color: #b72928;">' . $email . '</span><br> 
                                <span style="font-size:10pt;color: #b72928;">' . $web . '</span><br>   
                            </div>
                        </div>
                    </div>    
                    <div class="caja-info-dos">
                        <div style="border:1px solid  #000000; ">
                            <h4 style="line-height: 15px;"><strong>RUC: ' . $ruc . '</strong></h4>
                            <h3 style="line-height: 15px;"><strong> ' . $ingreso->Comprobante . ' ELECTRÓNICA</strong></h3>
                            <h4 style="line-height: 15px;"><strong>' . $ingreso->Serie . ' - ' . $ingreso->Numeracion . '</strong></h4>
                        </div>            
                    </div>
                </div>
                <!--#########################Fin de la cabecera###################################-->

                <!--#####este es el contenedor donde se encuentra toda la informacion correspondiente del cliente########-->
                <div class="container-info">
                    <div class="caja-two" >
                        <table  style="font-family: arial;" cellpadding="1" border="0">
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>' . $ingreso->NombreDocumento . '</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b> ' . $ingreso->idDNI . '</td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>' . $ingreso->TipoNombrePersona . '</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b>' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . '</td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>Dirección</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b>'.$ingreso->Direccion.' </td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>Fecha Emisión</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b> ' . $ingreso->FechaEmision . '</td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>Moneda</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b>SOL-PEN</td>
                            </tr>';
                            ?>
                            <?php
                            if ($ingreso->TipoDocumento == 6) {
                                $html .= '<tr>
                                            <td style="line-height: 0px;padding:2px 0px;"><b>Ref</b></td>
                                            <td style="line-height: 0px;padding:2px 0px;"><b>:</b> N° Cip '.$ingreso->CIP.' - ING. '.$ingreso->Apellidos.' '.$ingreso->Nombres .'</td>
                                            </tr>  ';
                            }
                            ?>
                            <?php
                            $html .= '</table>
                    </div>
                </div>
                <!--#####################Fin de la caja de informacion del cliente###################################-->

                <!--##################### Inicio detalle de la compra ###################################-->
                <div class="detalle-compra" >
                    <table class="items" width="100%" style="font-family:Arial;font-size: 11pt; border: none; border-collapse: collapse;" cellpadding="6">
                        <thead>
                            <tr>
                                <td width="5%" style="background-color:#b72928;border: none;color:white;font-weight: bold;">Ítem</td>                    
                                <td width="50%" style="background-color:#cccccc;border: none;color:black;font-weight: bold;text-aligh:left;">Concepto</td>
                                <td width="15%" style="background-color:#e6e6e6;border: none;color:black;font-weight: bold;">Cantidad</td>                    
                                <td width="15%" style="background-color:#cccccc;border: none;color:black;font-weight: bold;">P. Unitario</td>
                                <td width="15%" style="background-color:#b72928;border: none;color:white;font-weight: bold;">Importe</td>
                            </tr>
                        </thead>
                        <tbody>';
?>

                            <?php foreach ($detalleIngreso as $value) {
                                $cantidad = $value['Cantidad'];
                                $impuesto = 0;
                                $precioBruto = $value['Precio'];

                                $impuestoGenerado = $precioBruto * ($impuesto / 100.00);
                                $impuestoTotal = $impuestoGenerado * $cantidad;
                                $importeBrutoTotal = $precioBruto * $cantidad;
                                $importeNeto = $precioBruto + $impuestoGenerado;
                                $importeNetoTotal = $importeBrutoTotal + $impuestoTotal;
                                $html .= '
                                <tr>
                                    <td align="center" style="background-color:#b72928;border: none;color:white;">' . $value['Id'] . '</td>
                                    <td align="center" style="background-color:#cccccc;border: none;color:black;">' . $value['Concepto'] . '</td>
                                    <td class="costt" align="right" style="background-color:#e6e6e6;border: none;color:black;">' . round($cantidad, 2, PHP_ROUND_HALF_UP) . '</td>
                                    <td class="costt" align="right" style="background-color:#cccccc;border: none;color:black;">' . number_format(round($importeNeto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                                    <td class="costt" align="right" style="background-color:#b72928;border: none;color:white;">' . number_format(round($importeNetoTotal, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                                </tr>';
                            }
                            $html .= '</tbody>
                    </table>

                    <div style="font-style: italic;font-weight: bold;padding:5px 0px;">' . (isset($cuotas->Pago) ? 'CUOTAS: ' . $cuotas->Pago : '') . '</div>
       
                    <table class="items" style="font-family:Arial;font-size: 11pt; border-collapse: collapse; border: 0px;margin-bottom:10px;" width="100%">
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Op.Gravadas:</td>
                            <td class="cost" align="right" width="15%">S/ 0.00</td>
                        </tr>  
                        <tr>
                            <td class="estado" width="50%"></td>    
                            <td class="totals" width="15%" align="right">Op.Gratuitas: </td>
                            <td class="cost" align="right" width="15%">S/ 0.00</td>
                        </tr>         
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Op.Exogeneradas: </td>
                            <td class="cost" align="right" width="15%">S/ ' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                        </tr>            
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Op.Inafectas: </td>
                            <td class="cost" align="right" width="15%">S/ 0.00</td>
                        </tr>
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Descuentos: </td>
                            <td class="cost" align="right" width="15%">S/ 0.00</td>
                        </tr>
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Igv(18%). </td>
                            <td class="cost" align="right" width="15%">S/ 0.00</td>
                        </tr>
                        <tr>
                            <td class="estado" width="50%"></td>
                            <td class="totals" width="15%" align="right">Imperte Total:</td>
                            <td class="cost" align="right" width="15%">S/ ' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                        </tr>
                    </table>
 
                    <div style="border-top: 1px solid #000000">
                        <p style="padding:7px 0px;">SON:<strong> ' . $gcl->getResult(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), "SOL") . '</strong></p>
                    </div>

                    <div style="border-left: 6px solid #b72928; font-size:11pt; text-align: center; padding-top: 3mm; ">
                        <p style="text-align:center; margin_bottom:5px;">Representación Impresa de la Factura Electrónica Autorizado para ser Emisor electrónico mediante la Resolución de Intendencia N° 0340050004781/SUNAT/ Para consultar el comprobante ingrese a: https://sunat.god.pe</p>
                        <div style="margin-bottom:0px;" width="100%">
                            <img style="width:100px; height:100px;" src="codbar.png" />
                            <div>Hashcode: ' . $ingreso->CodigoHash . '</div>
                        </div>
                    </div>
                </div>
                <footer>
                    <div style="width:50%;float:left;">
                        Colegio de Ingenieros del Perú
                    </div>
                    <div style="width:50%;float:left;">
                        Consejo Departamental de Junín
                    </div>      
                </footer>
            </body>
        </html>';

                            $mpdf = new \Mpdf\Mpdf([
                                'margin_left' => 10,
                                'margin_right' => 10,
                                'margin_top' => 10,
                                'margin_bottom' => 10,
                                'margin_header' => 10,
                                'margin_footer' => 10,
                                'mode' => 'utf-8',
                                'format' => 'A4',
                                'orientation' => 'P'
                            ]);

                            $mpdf->SetProtection(array('print'));
                            $mpdf->SetTitle($ingreso->Comprobante . " " . $ingreso->Serie . '-' . $ingreso->Numeracion . " CIP-JUNIN");
                            $mpdf->SetAuthor("SysSoftIntegra");
                            $mpdf->SetWatermarkText(($ingreso->Estado === "C" ? "PAGADO" : "ANULADO"));   // anulada
                            $mpdf->showWatermarkText = true;
                            $mpdf->watermark_font = 'DejaVuSansCondensed';
                            $mpdf->watermarkTextAlpha = $ingreso->Estado === "C" ? 0.1 : 0.5;
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->WriteHTML($html);
                            // Output a PDF file directly to the browser
                            $mpdf->Output($ingreso->Comprobante . " " . $ingreso->Serie . '-' . $ingreso->Numeracion . " CIP-JUNIN.pdf", 'I');
                        }
                    }
                }
