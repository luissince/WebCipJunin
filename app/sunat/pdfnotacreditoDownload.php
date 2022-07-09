<?php
use SysSoftIntegra\Src\NumberLleters;
use chillerlan\QRCode\QRCode;

use SysSoftIntegra\Model\NotaCreditoAdo;

require __DIR__ . './../src/autoload.php';

if (!isset($_GET["idNotaCredito"])) {
    echo '<script>location.href = "404.php";</script>';
} else {


    $detallnotacredito = NotaCreditoAdo::ObtenerNotaCreditoXML($_GET["idNotaCredito"]);
    if (!is_array($detallnotacredito)) {
        echo $detallnotacredito;
    } else {
        $notacredito = $detallnotacredito[0];
        $detalle = $detallnotacredito[1];
        $empresa = $detallnotacredito[2];
        $totales = $detallnotacredito[3];


        //Datos de la empresa que factura
        $rutaImage = "../../view/images/logologin.png";
        $nombre = $empresa->RazonSocial;
        $direccion = $empresa->Domicilio;
        $web = $empresa->PaginaWeb;
        $email = $empresa->Email;
        $telefono = "Tesorería " . $empresa->Telefono . " Anexo 202";
        $ruc = $empresa->NumeroDocumento;

        $gcl = new NumberLleters();

        $textoCodBar =
            '|' . $ruc
            . '|' . $notacredito->TipoDocumentoNotaCredito
            . '|' . $notacredito->SerieNotaCredito
            . '|' . $notacredito->NumeracionNotaCredito
            . '|' . number_format(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
            . '|' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '')
            . '|' . $notacredito->FechaNotaCredito
            . '|' . $notacredito->HoraNotaCredito
            . '|' . $notacredito->NumeroDocumento
            . '|';



        // $pdf417 = new PDF417();
        // $codigo_barra = $pdf417->encode($textoCodBar);

        // $renderer = new ImageRenderer([
        //     'format' => 'png'
        // ]);

        // $image = $renderer->render($codigo_barra);
        // $imagenurl = 'codbar.png';
        // $image->save(''.$imagenurl);

        $html = '<html>
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

    .totals{
        padding:5px;
        font-weight:normal;
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

    .th-white{
        background-color:#b72928;
        border: none;
        color:white;
        font-weight: bold;
    }

    .th-dark{
        background-color:#cccccc;
        border: none;
        color:black;
        font-weight: bold;
    }

    .td-white{
        background-color:#b72928;
        border: none;
        color:white;
        vertical-align:middle;
    }

    .td-dark{
        background-color:#cccccc;
        border: none;
        color:black;
        vertical-align:middle;
    }

    
    </style>
</head>
<body>
    <!--#####################cabecera###################################-->
    <div class="cont-header">
    <div class="caja-info-cero">
        <img src="' . $rutaImage . '" style="width:70%;"><br>
        <span style="font-size:10pt;font-style: italic;color: #b72928;font-weight: bold;">"Ingenieros por la competitividad y productividad"</span>
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
            <h3 style="line-height: 15px;"><strong> ' . $notacredito->Comprobante . ' ELECTRÓNICA</strong></h3>
            <h4 style="line-height: 15px;"><strong>' . $notacredito->SerieNotaCredito . ' - ' . $notacredito->NumeracionNotaCredito . '</strong></h4>
        </div>            
    </div>
</div>
    <!--#########################Fin de la cabecera###################################-->

    <!--#####este es el contenedor donde se encuentra toda la informacion correspondiente del cliente########-->
    <!--#####este es el contenedor donde se encuentra toda la informacion correspondiente del cliente########-->
    <div class="container-info">
        <div class="caja-two" >
            <table  style="font-family: arial;" cellpadding="1" border="0">
                <tr>
                    <td style="line-height: 0px;padding:2px 0px;"><b>' . $notacredito->NombreDocumento . '</b></td>
                    <td style="line-height: 0px;padding:2px 0px;"><b>: </b> ' . $notacredito->NumeroDocumento . '</td>
                </tr>
                <tr>
                    <td style="line-height: 0px;padding:2px 0px;"><b>' . $notacredito->TipoNombrePersona . '</b></td>
                    <td style="line-height: 0px;padding:2px 0px;"><b>: </b>' . $notacredito->DatosPersona . '</td>
                </tr>
                <tr>
                    <td style="line-height: 0px;padding:2px 0px;"><b>Dirección</b></td>
                    <td style="line-height: 0px;padding:2px 0px;"><b>: </b>' . $notacredito->Direccion . ' </td>
                </tr>
                <tr>
                    <td style="line-height: 0px;padding:2px 0px;"><b>Fecha Emisión</b></td>
                    <td style="line-height: 0px;padding:2px 0px;"><b>: </b> ' . date("d/m/Y", strtotime($notacredito->FechaNotaCredito)) . '</td>
                </tr>
                <tr>
                    <td style="line-height: 0px;padding:2px 0px;"><b>Moneda</b></td>
                    <td style="line-height: 0px;padding:2px 0px;"><b>: </b>SOL-PEN</td>
                </tr>';
?>
                <?php
                if ($notacredito->TipoDocumento == 6) {
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
                    <th width="5%" class="th-white">Ítem</th>                    
                    <th width="50%" class="th-dark">Concepto</th>
                    <th width="15%" class="th-dark">Cantidad</th>                    
                    <th width="15%" class="th-dark">P. Unitario</th>
                    <th width="15%" class="th-white">Importe</th>
                </tr>
            </thead>
            <tbody>';
                ?>

<?php
        foreach ($detalle as $value) {
            $cantidad = $value['Cantidad'];
            $impuesto = $value['Valor'];
            $precioVenta = $value['Precio'];

            $precioBruto = $precioVenta / (($impuesto / 100.00) + 1);
            $impuestoGenerado = $precioBruto * ($impuesto / 100.00);
            $impuestoTotal = $impuestoGenerado * $cantidad;
            $importeBrutoTotal = $precioBruto * $cantidad;
            $importeNeto = $precioBruto + $impuestoGenerado;
            $importeNetoTotal = $importeBrutoTotal + $impuestoTotal;

            $html .= '
                <tr>
                    <td align="center" class="td-white">' . $value['Id'] . '</td>
                    <td align="center" class="td-dark">' . $value['Concepto'] . '</td>
                    <td align="right" class="td-dark">' . round($cantidad, 2, PHP_ROUND_HALF_UP) . '</td>
                    <td align="right" class="td-dark">' . number_format(round($importeNeto, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right" class="td-white">' . number_format(round($importeNetoTotal, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                </tr>';
?>

<?php
        }
        $html .= ' </tbody>
        </table>

        <table style="font-family:Arial;font-size: 14px; border-collapse: collapse; border: 0px;margin-bottom:10px;" width="100%">
        <thead>
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Op.Gravadas:</td>
                <th class="cost" align="right" width="15%">S/ ' . number_format(round($totales['opgravada'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            </tr>  
            <tr>
                <th class="estado" width="50%"></td>    
                <th class="totals" width="15%" align="right">Op.Gratuitas: </td>
                <th class="cost" align="right" width="15%">S/ 0.00</td>
            </tr>         
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Op.Exoneradas: </td>
                <th class="cost" align="right" width="15%">S/ ' . number_format(round($totales['opexonerada'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            </tr>            
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Op.Inafectas: </td>
                <th class="cost" align="right" width="15%">S/ 0.00</td>
            </tr>
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Descuentos: </td>
                <th class="cost" align="right" width="15%">S/ 0.00</td>
            </tr>
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Igv(18%). </td>
                <th class="cost" align="right" width="15%">S/ ' . number_format(round($totales['totalimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            </tr>
            <tr>
                <th class="estado" width="50%"></td>
                <th class="totals" width="15%" align="right">Importe Total:</td>
                <th class="cost" align="right" width="15%">S/ ' . number_format(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
            </tr>
        </thead>                        
    </table>
 
        <div style="border-top: 1px solid #000000">
            <p style="padding:7px 0px;">SON:<strong> ' . $gcl->getResult(round($totales['totalconimpuesto'], 2, PHP_ROUND_HALF_UP), "SOL") . '</strong></p>
        </div>

        <div style="border-left: 6px solid #b72928; font-size:11pt; text-align: center; padding-top: 3mm; ">
            <p style="text-align:center; margin_bottom:5px;">Representación Impresa de la Factura Electrónica Autorizado para ser Emisor electrónico mediante la Resolución de Intendencia N° 0340050004781/SUNAT/ Para consultar el comprobante ingrese a: https://sunat.god.pe</p>
            <div style="margin-bottom:0px;" width="100%">
                <img style="width:100px; height:100px;" src="' . (new QRCode)->render($textoCodBar) . '"  />
                <div>Hashcode: ' . $notacredito->CodigoHash . '</div>
            </div>
            <p style="text-align:left; margin_bottom:5px;"><b>&nbsp;Motivo de Emisión:</b> ' . $notacredito->CodigoAnulacion . "-" . $notacredito->MotivoAnulacion . '</p>
            <p style="text-align:left; margin_bottom:5px;"><b>&nbsp;Documento Relacionado:</b> ' . $notacredito->Serie . "-" . $notacredito->NumRecibo . '</p>
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
        $mpdf->SetTitle("NOTA DE CRÉDITO " . $notacredito->SerieNotaCredito  . "-" . $notacredito->NumeracionNotaCredito);
        $mpdf->SetAuthor("Cip Junin");
        $mpdf->SetWatermarkText("");   // anulada
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        $mpdf->Output("NOTA DE CRÉDITO " . $notacredito->SerieNotaCredito . "-" . $notacredito->NumeracionNotaCredito . ".pdf", 'I');
    }
}
