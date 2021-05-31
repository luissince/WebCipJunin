<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/ListarIngenierosAdo.php');
ini_set('max_execution_time', '300');
ini_set("pcre.backtrack_limit", "10000000");
ini_set('memory_limit', '-1');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN DE COLEGIADOS DEL CIP NACIONAL";

$getCodicion = $_GET['condicion'];
$condicion = $_GET['condicion'] = 'T' ? 'TRANSEUNTE' : $_GET['condicion'] = 'O' ? 'ORDINARIO' : $_GET['condicion'] = 'V' ? 'VITALICIO' : $_GET['condicion'] = 'R' ? 'RETIRADO' : 'FALLECIDO';

if ($_GET["opcion"] == 1) {
    $subtitle = "REPORTE GENERAL DE COLEGIADOS";
} else if ($_GET["opcion"] == 2){
    $subtitle = "REPORTE DE COLEGIADOS - CONDICIÓN ".$condicion;
} else if($_GET["opcion"] == 3){
    $subtitle = "REPORTE DE COLEGIADOS - CONDICIÓN ".$condicion." DE LA FECHA: ". date("d-m-Y", strtotime($_GET["fiColegiado"]))." al ".date("d-m-Y", strtotime($_GET["ffColegiado"]));
}

$data['condicion'] = $getCodicion;
$data['fiColegiado'] = $_GET['fiColegiado'];
$data['ffColegiado'] = $_GET['ffColegiado'];
$data['opcion'] = $_GET['opcion'];

$listarColegiados = ListarIngenierosAdo::allIngenieros($data);

if (!is_array($listarColegiados)) {
print $listarColegiados;
} else {
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
            <span style="font-size: 10pt; color: black; font-family: sans;">' . $subtitle . ' 
        </span>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>   
            <th width="10%" >N°</th>  
            <th width="10%" >DNI</th>        
            <th width="10%" >N° Cip</th>
            <th width="10%" >APELLIDOS</th>
            <th width="10%" >NOMBRES</th>
            <th width="10%" >CONDICION</th>
            <th width="10%" >FECHA COLEGIADO</th>
            <th width="10%" >CAPITULO</th>
            <th width="10%" >ESPECIALIDAD</th>

        </tr>
    </thead>
    <tbody>
    ';
?>
    <?php
    foreach ($listarColegiados as $value) {
        $html .= '
        <tr>            
            <td align="center">' . $value["Id"] . '</td>
            <td >' . $value["idDNI"] . '</td>
            <td >' . $value["CIP"] . '</td>       
            <td >' . $value["Apellidos"] . '</td>
            <td >' . $value["Nombres"] . '</td>     
            <td >' . $value["Condicion"] . '</td>
            <td  align="center">' . $value["FechaColegiado"] . '</td>
            <td >' . $value["Capitulo"] . '</td>
            <td >' . $value["Especialidad"] . '</td>
        </tr>';
    }

    ?>
    <?php

    $html .= '
    </tbody>
    
</table>
<br>
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
    $mpdf->SetTitle("CIPJUNIN");
    $mpdf->SetAuthor("SysSoftIntegra");
    $mpdf->SetWatermarkText("");
    $mpdf->showWatermarkText = true;
    $mpdf->watermark_font = 'DejaVuSansCondensed';
    $mpdf->watermarkTextAlpha = 0.1;
    $mpdf->SetDisplayMode('fullpage');

    $mpdf->WriteHTML($html);

    if ($_GET["opcion"] == 1) {
        $mpdf->Output("Reporte General De Colegiados.pdf",'I');
    } else if ($_GET["opcion"] == 2){
        $mpdf->Output("Reporte Colegiados - Condición_".$condicion.".pdf",'I');
    } else if($_GET["opcion"] == 3){
        $mpdf->Output("Reporte Colegiados - Condición_".$condicion." De La Fecha: ".date("d-m-Y", strtotime($_GET["fiColegiado"]))." al ".date("d-m-Y", strtotime($_GET["ffColegiado"])).".pdf",'I');
    }
}
