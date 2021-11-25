<?php

define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
include_once('../model/PersonaAdo.php');
include_once('../model/CapituloAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";
$title = "RESUMEN GLOBAL";
$fechaIngreso = "Fecha: " . date('d/m/Y');

$total_cap_esp = CapituloAdo::getAllCountCapAndEsp();
$total_condicion = PersonaAdo::getCountConditionPerson();

if (!is_array($total_cap_esp) && !is_array($total_condicion)) {
    echo json_encode($total_cap_esp);
    echo json_encode($total_condicion);
} else {
    $html = '
<html>
<head>
<style>
    body{
        font-family: "Helvetica Neue", Helvetica, Arial;
    }

    table thead th {
        padding: 5px;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }

    table tbody td {
        padding: 5px;
        font-size: 12px;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
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

    <table width="100%" border="0" cellspacing="0">
        <tr>
            <td width="15%" style="text-align: center;">
                <img src="' . $rutaImage . '" style="width:80px;">                        
            </td>
            <td width="75%" style="text-align: center;">               
                    <h3>' . $title . ' </h3>                                          
                    <h5>' . $fechaIngreso . '</h5>     
            </td>
        </tr>

        <tr>
            <td width="15%" style="text-align: center;padding-top:10px;">
                <h5>CIP-JUNÍN</h5>                                       
            </td>
        </tr>
    </table>
 
    <h4>Resumen de Especialidades y Capitulos</h4>
    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr style="background: #cccccc;">
                <th width="5%" rowspan="1">N°</th>
                <th width="75%" rowspan="1">Descripción</th>
                <th width="10%" rowspan="1">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">1</td>
                <td>Total de especialidades</td>
                <td>' . $total_cap_esp["Especialidad"] . '</td>
            </tr>
            <tr>
                <td align="center">2</td>
                <td>Total de capitulos</td>
                <td>' . $total_cap_esp["Capitulo"] . '</td>
            </tr>
        </tbody>
    </table>  

    <h4>Resumen de Colegiados</h4>
    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr style="background: #cccccc;">
                <th width="5%" rowspan="1">N°</th>
                <th width="75%" rowspan="1">Descripción</th>
                <th width="10%" rowspan="1">Cantidad</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Total de personas registradas</td>
                <td>' . $total_condicion["Personas"] . '</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Total en condicion de Ordinarios</td>
                <td>' . $total_condicion["Ordinario"] . '</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Total en condicion de Transeuntes</td>
                <td>' . $total_condicion["Transeunte"] . '</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Total en condicion de Fallecidos</td>
                <td>' . $total_condicion["Fallecido"] . '</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Total en condicion de Retirados</td>
                <td>' . $total_condicion["Retirado"] . '</td>
            </tr>
            <tr>
                <td>6</td>
                <td>Total en condicion de Vitalicios</td>
                <td>' . $total_condicion["Vitalicio"] . '</td>
            </tr>
        </tbody>
    </table>

    <h4>Resumen de Colegiaturas</h4>
    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr style="background: #cccccc;">
                <th width="5%" rowspan="1">N°</th>
                <th width="75%" rowspan="1">Descripción</th>
                <th width="10%" rowspan="1">Cantidad</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Total personas con Colegiatura</td>
                <td>' . $total_condicion["Colegiados"] . '</td>
            </tr>       
            <tr>
                <td>2</td>
                <td>Total personas sin Colegiatura</td>
                <td>' . $total_condicion["SinColegiatura"] . '</td>
            </tr>      
        </tbody>
    </table>

    <h4>Resumen Cuotas y Habilidad</h4>
    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr style="background: #cccccc;">
                <th width="5%" rowspan="1">N°</th>
                <th width="75%" rowspan="1">Descripción</th>
                <th width="10%" rowspan="1">Cantidad</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>Total personas con Cuotas</td>
                <td>' . $total_condicion["ConCuotas"] . '</td>
            </tr>   
            <tr>
                <td>2</td>
                <td>Total personas sin Cuotas</td>
                <td>' . $total_condicion["SinCuotas"] . '</td>
            </tr>   
            <tr>
                <td>3</td>
                <td>Total de Habilitados</td>
                <td>' . $total_condicion["Habilitados"] . '</td>
            </tr> 
            <tr>
                <td>4</td>
                <td>Total de Inhabilitados</td>
                <td>' . $total_condicion["Inbilitados"] . '</td>
            </tr> 
        </tbody>
    </table>

</body>
</html>
';

    $mpdf = new \Mpdf\Mpdf([
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 18,
        'margin_bottom' => 25,
        'margin_header' => 10,
        'margin_footer' => 10
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
    $mpdf->Output();
}
