<?php
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE APORTACIONES AL CIP NACIONAL";
$subtitle = "DE LA FECHA: " . date("d-m-Y", strtotime($_GET["fechaInicial"])) . " al " . date("d-m-Y", strtotime($_GET["fechaFinal"]));;
$totalISSCIP = 0;
$totalSOCIALCIP = 0;

$data['FechaInicial'] = $_GET['fechaInicial'];
$data['FechaFinal'] = $_GET['fechaFinal'];
$data['Colegiado'] = $_GET['colegiado'];
$data['Opcion'] = $_GET['tipo'];

$resumen = IngresosAdo::ResumenAporteCIN($data);

if (!is_array($resumen)) {
    echo $resumen;
} else {

    $arrayresumen = array();

    foreach ($resumen as $value) {
        $fechaIni = new DateTime($value["FechaIni"]);
        $fechaFin = new DateTime($value["FechaFin"]);

        while ($fechaIni <= $fechaFin) {
            array_push($arrayresumen, array(
                "CIP" => $value["CIP"],
                "idIngreso" => $value["idIngreso"],
                "idDNI" => $value["idDNI"],
                "Condicion" => $value["Condicion"],
                "Ingeniero" => $value["Ingeniero"],
                "Especialidad" => $value["Especialidad"],
                "Capitulo" => $value["Capitulo"],
                "Year" => $fechaIni->format("Y"),

                "Concepto1" => $value["Concepto1"],
                "Monto1" => floatval($value["Monto1"]),
                "EneroX" => $fechaIni->format("m") == 1 ? floatval($value["Monto1"]) : 0,
                "FebreroX" => $fechaIni->format("m") == 2 ? floatval($value["Monto1"]) : 0,
                "MarzoX" => $fechaIni->format("m") == 3 ? floatval($value["Monto1"]) : 0,
                "AbrilX" => $fechaIni->format("m") == 4 ? floatval($value["Monto1"]) : 0,
                "MayoX" => $fechaIni->format("m") == 5 ? floatval($value["Monto1"]) : 0,
                "JunioX" => $fechaIni->format("m") == 6 ? floatval($value["Monto1"]) : 0,
                "JulioX" => $fechaIni->format("m") == 7 ? floatval($value["Monto1"]) : 0,
                "AgostoX" => $fechaIni->format("m") == 8 ? floatval($value["Monto1"]) : 0,
                "SetiembreX" => $fechaIni->format("m") == 9 ? floatval($value["Monto1"]) : 0,
                "OctubreX" => $fechaIni->format("m") == 10 ? floatval($value["Monto1"]) : 0,
                "NoviembreX" => $fechaIni->format("m") == 11 ? floatval($value["Monto1"]) : 0,
                "DiciembreX" => $fechaIni->format("m") == 12 ? floatval($value["Monto1"]) : 0,
                "SumaConcepto1" => floatval($value["Monto1"]),

                "Concepto2" => $value["Concepto2"],
                "Monto2" => floatval($value["Monto2"]),
                "EneroY" => $fechaIni->format("m") == 1 ? floatval($value["Monto2"]) : 0,
                "FebreroY" => $fechaIni->format("m") == 2 ? floatval($value["Monto2"]) : 0,
                "MarzoY" => $fechaIni->format("m") == 3 ? floatval($value["Monto2"]) : 0,
                "AbrilY" => $fechaIni->format("m") == 4 ? floatval($value["Monto2"]) : 0,
                "MayoY" => $fechaIni->format("m") == 5 ? floatval($value["Monto2"]) : 0,
                "JunioY" => $fechaIni->format("m") == 6 ? floatval($value["Monto2"]) : 0,
                "JulioY" => $fechaIni->format("m") == 7 ? floatval($value["Monto2"]) : 0,
                "AgostoY" => $fechaIni->format("m") == 8 ? floatval($value["Monto2"]) : 0,
                "SetiembreY" => $fechaIni->format("m") == 9 ? floatval($value["Monto2"]) : 0,
                "OctubreY" => $fechaIni->format("m") == 10 ? floatval($value["Monto2"]) : 0,
                "NoviembreY" => $fechaIni->format("m") == 11 ? floatval($value["Monto2"]) : 0,
                "DiciembreY" => $fechaIni->format("m") == 12 ? floatval($value["Monto2"]) : 0,
                "SumaConcepto2" => floatval($value["Monto2"]),

            ));
            $fechaIni->modify('+ 1 month');
        }
    }

    $arraynuevo = array();


    foreach ($arrayresumen as $value) {
        if (IngresosAdo::isValidate($arraynuevo, $value)) {
            for ($i = 0; $i < count($arraynuevo); $i++) {
                if ($arraynuevo[$i]["idDNI"] == $value["idDNI"] && $arraynuevo[$i]["Year"] == $value["Year"]) {
                    $arraynuevo[$i] = array(
                        "CIP" => $value["CIP"],
                        "idIngreso" => $value["idIngreso"],
                        "idDNI" => $value["idDNI"],
                        "Condicion" => $value["Condicion"],
                        "Ingeniero" => $value["Ingeniero"],
                        "Especialidad" => $value["Especialidad"],
                        "Capitulo" => $value["Capitulo"],
                        "Year" => $value["Year"],

                        "Concepto1" => $value["Concepto1"],
                        "Monto1" => $value["Monto1"] == 0 ? $arraynuevo[$i]["Monto1"] : $value["Monto1"],
                        "EneroX" =>  $value["EneroX"] == 0 ? $arraynuevo[$i]["EneroX"] : $value["EneroX"],
                        "FebreroX" =>  $value["FebreroX"] == 0 ? $arraynuevo[$i]["FebreroX"] : $value["FebreroX"],
                        "MarzoX" =>  $value["MarzoX"] == 0 ? $arraynuevo[$i]["MarzoX"] : $value["MarzoX"],
                        "AbrilX" =>  $value["AbrilX"] == 0 ? $arraynuevo[$i]["AbrilX"] : $value["AbrilX"],
                        "MayoX" =>  $value["MayoX"] == 0 ? $arraynuevo[$i]["MayoX"] : $value["MayoX"],
                        "JunioX" =>  $value["JunioX"] == 0 ? $arraynuevo[$i]["JunioX"] : $value["JunioX"],
                        "JulioX" =>  $value["JulioX"] == 0 ? $arraynuevo[$i]["JulioX"] : $value["JulioX"],
                        "AgostoX" =>  $value["AgostoX"] == 0 ? $arraynuevo[$i]["AgostoX"] : $value["AgostoX"],
                        "SetiembreX" =>  $value["SetiembreX"] == 0 ? $arraynuevo[$i]["SetiembreX"] : $value["SetiembreX"],
                        "OctubreX" => $value["OctubreX"] == 0 ? $arraynuevo[$i]["OctubreX"] : $value["OctubreX"],
                        "NoviembreX" => $value["NoviembreX"] == 0 ? $arraynuevo[$i]["NoviembreX"] : $value["NoviembreX"],
                        "DiciembreX" => $value["DiciembreX"] == 0 ? $arraynuevo[$i]["DiciembreX"] : $value["DiciembreX"],
                        "SumaConcepto1" => $arraynuevo[$i]["SumaConcepto1"] + $value["SumaConcepto1"],

                        "Concepto2" => $value["Concepto2"],
                        "Monto2" => $value["Monto2"] == 0 ? $arraynuevo[$i]["Monto2"]  : $value["Monto2"],
                        "EneroY" => $value["EneroY"] == 0 ? $arraynuevo[$i]["EneroY"] : $value["EneroY"],
                        "FebreroY" => $value["FebreroY"] == 0 ? $arraynuevo[$i]["FebreroY"] : $value["FebreroY"],
                        "MarzoY" => $value["MarzoY"] == 0 ? $arraynuevo[$i]["MarzoY"] : $value["MarzoY"],
                        "AbrilY" => $value["AbrilY"] == 0 ? $arraynuevo[$i]["AbrilY"] : $value["AbrilY"],
                        "MayoY" => $value["MayoY"] == 0 ? $arraynuevo[$i]["MayoY"] : $value["MayoY"],
                        "JunioY" => $value["JunioY"] == 0 ? $arraynuevo[$i]["JunioY"] : $value["JunioY"],
                        "JulioY" => $value["JulioY"] == 0 ? $arraynuevo[$i]["JulioY"] : $value["JulioY"],
                        "AgostoY" => $value["AgostoY"] == 0 ? $arraynuevo[$i]["AgostoY"] : $value["AgostoY"],
                        "SetiembreY" => $value["SetiembreY"] == 0 ? $arraynuevo[$i]["SetiembreY"] : $value["SetiembreY"],
                        "OctubreY" => $value["OctubreY"] == 0 ? $arraynuevo[$i]["OctubreY"] : $value["OctubreY"],
                        "NoviembreY" => $value["NoviembreY"] == 0 ? $arraynuevo[$i]["NoviembreY"] : $value["NoviembreY"],
                        "DiciembreY" => $value["DiciembreY"] == 0 ? $arraynuevo[$i]["DiciembreY"] : $value["DiciembreY"],
                        "SumaConcepto2" => $arraynuevo[$i]["SumaConcepto2"] + $value["SumaConcepto2"],
                    );
                    break;
                }
            }
        } else {
            array_push($arraynuevo, $value);
        }
    }



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
                ' . $subtitle . ' 
        </span>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>   
            <th width="3%" rowspan="2">N°</th>  
            <th width="7%" rowspan="2">Capítulo</th>        
            <th width="6%" rowspan="2">N° Cip</th>
            <th width="7%" rowspan="2">Condición</th>
            <th width="13%" rowspan="2">Ingeniero</th>
            <th width="4%" rowspan="2">Año</th>

            <th width="22%" colspan="13">Cuotas al ISS CIP</th>
            <th width="22%" colspan="13">Cuotas Sociales CIP</th>
            <th width="4%" rowspan="2">T.</th>
        </tr>
        <tr>
            <th>E</th>
            <th>F</th>
            <th>M</th>
            <th>A</th>
            <th>M</th>
            <th>J</th>
            <th>J</th>
            <th>A</th>
            <th>S</th>
            <th>O</th>
            <th>N</th>
            <th>D</th>
            <th>S1</th>

            <th>E</th>
            <th>F</th>
            <th>M</th>
            <th>A</th>
            <th>M</th>
            <th>J</th>
            <th>J</th>
            <th>A</th>
            <th>S</th>
            <th>O</th>
            <th>N</th>
            <th>D</th>
            <th>S2</th>
        </tr>
    </thead>
    <tbody>
    ';
?>
    <?php
    $count = 0;
    foreach ($arraynuevo as $value) {

        $totalISSCIP += $value["SumaConcepto1"];
        $totalSOCIALCIP += $value["SumaConcepto2"];

        switch ($value["Condicion"]) {
            case "V":
                $condicion = "VITALICIO";
                break;
            case "R":
                $condicion = "RETIRADO";
                break;
            case "F":
                $condicion = "FALLECIDO";
                break;
            case "T":
                $condicion = "TRANSEUNTE";
                break;
            default:
                $condicion = "ORDINARIO";
                break;
        }

        $count++;

        $html .= '
        <tr>            
             <td rowspan="1" align="center">' . $count . '</td>
             <td rowspan="1">' . $value["Capitulo"] . '</td>
             <td rowspan="1">' . $value["CIP"] . '</td>       
           <td rowspan="1">' . $condicion . '</td>     
           <td rowspan="1">' . $value["Ingeniero"] . '</td>
           <td rowspan="1" align="center">' . $value["Year"] . '</td>            
          <td>' . number_format(round($value["EneroX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
           <td>' . number_format(round($value["FebreroX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["MarzoX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
       <td>' . number_format(round($value["AbrilX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
           <td>' . number_format(round($value["MayoX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["JunioX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["JulioX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["AgostoX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["SetiembreX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["OctubreX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["NoviembreX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["DiciembreX"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["SumaConcepto1"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>

             <td>' . number_format(round($value["EneroY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["FebreroY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["MarzoY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["AbrilY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["MayoY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["JunioY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["JulioY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["AgostoY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>    
             <td>' . number_format(round($value["SetiembreY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["OctubreY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["NoviembreY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
            <td>' . number_format(round($value["DiciembreY"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
             <td>' . number_format(round($value["SumaConcepto2"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>

             <td>' . number_format(round($value["SumaConcepto1"] + $value["SumaConcepto2"], 2, PHP_ROUND_HALF_UP), 1, '.', '') . '</td>
         </tr>';
    }

    ?>
    <?php

    $html .= '
    </tbody>
    
</table>
<br>
<div>
    <span style="font-size:8pt;font-weight:bold;">RESUMEN GENERAL</span>
</div>
<table class="items" width="30%" style="font-size: 7pt; border-collapse: collapse;" >
    <thead>        
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Cuotas al ISS CIP:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalISSCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Cuotas Sociales CIP:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalSOCIALCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
        <tr>
            <th align="left" style="padding:8pt;font-weight:normal;">Resumen Total:</th>
            <th align="right" style="padding:8pt;">' . number_format(round($totalISSCIP + $totalSOCIALCIP, 2, PHP_ROUND_HALF_UP), 2, '.', '') . '</th>
        </tr>
    </thead>
</table>
</body>
</html>
';


    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10,
        'orientation' => 'L',
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

    $mpdf->Output();
}
