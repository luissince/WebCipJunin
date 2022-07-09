<?php
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$opcion = $_GET["opcion"];
$title = $opcion == "1" ? "RESUMEN DE INGRESOS" : "RESUMEN DE INGRESOS POR AGREMIADO";
$fechaIngreso = date("d-m-Y", strtotime($_GET["fechaInicial"])) . " al " . date("d-m-Y", strtotime($_GET["fechaFinal"]));
$fechaTitulo = date("d/m/Y", strtotime($_GET["fechaInicial"])) . " al " . date("d/m/Y", strtotime($_GET["fechaFinal"]));

$recibos = "RECIBOS DEL : - al -";

$totalCipJunin = 0;
$totalCipNacional = 0;

$result = IngresosAdo::ResumenIngresosPorFecha($opcion, $_GET["fechaInicial"], $_GET["fechaFinal"]);
if (!is_array($result)) {
    echo $result;
} else {
    if ($opcion == "1") {

        $resumen = $result[0];

        $recibos = "RECIBOS DEL:" . $result[1]->SerieMin . "-" . $result[1]->NumReciboMin . " al " . $result[1]->SerieMax . "-" . $result[1]->NumReciboMax;
        $html = '
        <html>
        <head>
        <style>
            body {
                font-family: Arial;
                font-size: 10pt;
            }
            p {	
                font-family: Arial;
            }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { 
                vertical-align: middle; 
            }
            table thead th {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table tbody td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table tfoot td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table thead td { 
                background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
        </style>
        </head>
        <body>

        <!--mpdf
        <htmlpageheader name="myheader">
            <table width="100%">
                <tr>
                    <td width="50%" style="color:#969696; ">
                        <span style="font-weight: bold; font-size: 9pt;">
                            Colegio de Ingenieros del Perú
                        </span>
                    </td>
                    <td width="50%" style="color:#969696;text-align: right;">
                        <span style="font-weight: bold; font-size: 9pt;">
                            Consejo Departamental de Junín
                        </span>
                    </td>
                </tr>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
                Pagin {PAGENO} de {nb}
            </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
        mpdf-->

        <table width="100%" style="font-family: serif;" cellpadding="10">
            <tr>
                <td width="15%" style="border: 0mm solid #888888;text-align: center;">
                    <img src="' . $rutaImage . '" style="width:80px;">
                    <div>
                        <p>CIP-JUNÍN</p>
                    </div>
                </td>
                <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
                    <span style="font-size: 14pt; color: black; font-family: sans;">
                        <b>' . $title . ' </b>
                    </span>
                    <br>
                    <span style="font-size: 10pt; color: black; font-family: sans;">
                        FECHA: ' . $fechaTitulo . ' 
                </span>
                </td>
            </tr>
        </table>
        <div style="text-align: right;font-size: 11pt;">
            ' . $recibos . '
        </div>
        <br />
        <table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <th rowspan="2">N°</th>
                    <th rowspan="2">Codigo</th>
                    <th rowspan="2">Concepto</th>
                    <th rowspan="2">Cant.</th>
                    <th colspan="3">Cip Junin</th>
                    <th colspan="3">Cip Nacional</th>
                </tr>
                <tr>
                    <th>Efectivo</th>
                    <th>Desposito</th>
                    <th>Tarjeta</th>
                    <th>Efectivo</th>
                    <th>Desposito</th>
                    <th>Tarjeta</th>
                </tr>
            </thead>
            <tbody>';
?>

            <?php
            $totalCipJuninEfectivo = 0;
            $totalCipNacionalEfectivo = 0;

            $totalCipJuninDeposito = 0;
            $totalCipNacionalDesposito = 0;

            $totalCipJuninTarjeta = 0;
            $totalCipNacionalTarjeta = 0;

            foreach ($resumen as $value) {
                $efectivoJunin = '';
                $efectivoNacional = '';

                $depositoJunin = '';
                $depositoNacional = '';

                $tarjetaJunin = '';
                $tarjetaNacional = '';

                if ($value["Tipo"] == 1) {
                    $efectivoJunin =  ($value["CIPJunin"] == 0 ? '' : number_format(round($value["CIPJunin"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));
                    $efectivoNacional = ($value["CIPNacional"] == 0 ? '' : number_format(round($value["CIPNacional"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));

                    $totalCipJuninEfectivo += $value["CIPJunin"];
                    $totalCipNacionalEfectivo += $value["CIPNacional"];
                } else if ($value["Tipo"] == 2) {
                    $depositoJunin =  ($value["CIPJunin"] == 0 ? '' : number_format(round($value["CIPJunin"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));
                    $depositoNacional = ($value["CIPNacional"] == 0 ? '' : number_format(round($value["CIPNacional"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));

                    $totalCipJuninDeposito += $value["CIPJunin"];
                    $totalCipNacionalDesposito += $value["CIPNacional"];
                } else {
                    $tarjetaJunin =  ($value["CIPJunin"] == 0 ? '' : number_format(round($value["CIPJunin"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));
                    $tarjetaNacional = ($value["CIPNacional"] == 0 ? '' : number_format(round($value["CIPNacional"], 2, PHP_ROUND_HALF_UP), 2, '.', ''));

                    $totalCipJuninTarjeta += $value["CIPJunin"];
                    $totalCipNacionalTarjeta += $value["CIPNacional"];
                }


                $html .= ' <tr>
                            <td align="center" rowspan="1">
                                ' . $value["Id"] . '     
                            </td>
                            <td rowspan="1">
                                ' . $value["Codigo"] . '      
                            </td>
                            <td rowspan="1">
                                ' . $value["Concepto"] . '       
                            </td>
                            <td align="center" rowspan="1">
                                ' . $value["Cantidad"] . '      
                            </td>
                            <td align="right">
                                ' . $efectivoJunin . '   
                            </td>
                            <td align="right">
                                ' . $depositoJunin . ' 
                            </td>
                            <td align="right">
                                ' . $tarjetaJunin . '
                            </td>
                            <td align="right">
                                ' . $efectivoNacional . '   
                            </td>
                            <td align="right">
                                ' . $depositoNacional . ' 
                            </td>
                            <td align="right">
                                ' . $tarjetaNacional . '
                            </td>
                        </tr>';
            }

            ?>
            <?php

            $html .= '</tbody>
            <tfoot>
                <tr>
                    <td align="center" colspan="4" style="border-left:1px solid white;border-bottom:1px solid white;"></td>
                    <td align="right">' . number_format(round($totalCipJuninEfectivo, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right">' . number_format(round($totalCipJuninDeposito, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right">' . number_format(round($totalCipJuninTarjeta, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right">' . number_format(round($totalCipNacionalEfectivo, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right">' . number_format(round($totalCipNacionalDesposito, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                    <td align="right">' . number_format(round($totalCipNacionalTarjeta, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</td>
                </tr>
            </tfoot>
        </table>
        <br>
        <div>
            <span style="font-size:10pt;font-weight:bold;">RESUMEN GENERAL</span>
        </div>
        <table class="items" width="30%" style="font-size: 9pt; border-collapse: collapse;" >
            <thead>        
                <tr>
                    <th align="left" style="padding:8pt;font-weight:normal;">EFECTIVO:</th>
                    <th align="right" style="padding:8pt;">' . number_format(round($totalCipJuninEfectivo + $totalCipNacionalEfectivo, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
                </tr>
                <tr>
                    <th align="left" style="padding:8pt;font-weight:normal;">DEPOSITO:</th>
                    <th align="right" style="padding:8pt;">' . number_format(round($totalCipJuninDeposito + $totalCipNacionalDesposito, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
                </tr>
                <tr>
                    <th align="left" style="padding:8pt;font-weight:normal;">TARJETA:</th>
                    <th align="right" style="padding:8pt;">' . number_format(round($totalCipJuninTarjeta + $totalCipNacionalTarjeta, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
                </tr>
                <tr>
                    <th align="left" style="padding:8pt;font-weight:normal;">TOTAL:</th>
                    <th align="right" style="padding:8pt;">' . number_format(round($totalCipJuninEfectivo + $totalCipNacionalEfectivo + $totalCipJuninDeposito + $totalCipNacionalDesposito + $totalCipJuninTarjeta + $totalCipNacionalTarjeta, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
                </tr>
            </thead>
        </table>
        </body>
        </html>
        ';
        } else {
            $resumen = $result[0];

            $html = '
        <html>
        <head>
        <style>
            body {
                font-family: Arial;
                font-size: 10pt;
            }
            p {	
                font-family: Arial;
            }
            table.items {
                border: 0.1mm solid #000000;
            }
            td { 
                vertical-align: middle; 
            }
            table thead th {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table tbody td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table tfoot td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
                border-top: 0.1mm solid #000000;
                border-bottom: 0.1mm solid #000000;
            }
            table thead td { 
                background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
                font-variant: small-caps;
            }
        </style>
        </head>
        <body>

        <!--mpdf
        <htmlpageheader name="myheader">
            <table width="100%">
                <tr>
                    <td width="50%" style="color:#969696; ">
                        <span style="font-weight: bold; font-size: 9pt;">
                            Colegio de Ingenieros del Perú
                        </span>
                    </td>
                    <td width="50%" style="color:#969696;text-align: right;">
                        <span style="font-weight: bold; font-size: 9pt;">
                            Consejo Departamental de Junín
                        </span>
                    </td>
                </tr>
            </table>
        </htmlpageheader>
        <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
                Pagin {PAGENO} de {nb}
            </div>
        </htmlpagefooter>
        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
        mpdf-->

        <table width="100%" style="font-family: serif;" cellpadding="10">
            <tr>
                <td width="15%" style="border: 0mm solid #888888;text-align: center;">
                    <img src="' . $rutaImage . '" style="width:80px;">
                    <div>
                        <p>CIP-JUNÍN</p>
                    </div>
                </td>
                <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
                    <span style="font-size: 14pt; color: black; font-family: sans;">
                        <b>' . $title . ' </b>
                    </span>
                    <br>
                    <span style="font-size: 10pt; color: black; font-family: sans;">
                        FECHA: ' . $fechaTitulo . ' 
                </span>
                </td>
            </tr>
        </table>     
        <br />
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <th width="5%" rowspan="1">N°</th>
                    <th width="10%" rowspan="1">CIP</th>
                    <th width="35%" rowspan="1">INGENIERO</th>
                    <th width="10%" rowspan="1">MONTO</th>
                </tr>        
            </thead>
            <tbody>'; ?>
    <?php
            $suma = 0;
            foreach ($resumen as $value) {
                $html .= ' 
                <tr>
                    <td>' . $value["Id"] . ' </td>
                    <td>' . $value["Cip"] . ' </td>
                    <td>' . $value["Persona"] . ' </td>
                    <td>' . number_format(round($value["Total"], 2, PHP_ROUND_HALF_UP), 2, '.', '') . ' </td>
                </tr> ';
                $suma += $value["Total"];
            }
    ?>
            <?php
            $html .= '</tbody>
        </table>
        <br>
        <div>
            <span style="font-size:10pt;font-weight:bold;">RESUMEN GENERAL</span>
        </div>
        <table class="items" width="30%" style="font-size: 9pt; border-collapse: collapse;" >
            <thead>        
                <tr>
                    <th align="left" style="padding:8pt;font-weight:normal;">SUMA TOTAL:</th>
                    <th align="right" style="padding:8pt;">' . number_format(round($suma, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
                </tr>                
            </thead>
        </table>
        </body>
        </html>
        ';
        }


        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 18,
            'margin_bottom' => 25,
            'margin_header' => 10,
            'margin_footer' => 10
        ]);

        $mpdf->SetProtection(array('print'));
        $mpdf->SetTitle("INTRANET CIP-JUNIN");
        $mpdf->SetAuthor("SysSoftIntegra");
        $mpdf->SetWatermarkText("");
        $mpdf->showWatermarkText = true;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->SetDisplayMode('fullpage');

        $mpdf->WriteHTML($html);

        $mpdf->Output("Reporte de Ingresos CIP-JUNIN del " . $fechaIngreso . ".pdf", 'I');
    }
