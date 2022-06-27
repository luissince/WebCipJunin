<?php


if (!isset($_GET["idDni"]) || $_GET["idDni"] == "") {
    echo "El parametro no contiene el valor esperado.";
    return;
}

require_once('lib/mpdf/vendor/autoload.php');
include_once('../model/PersonaAdo.php');

$rutaImage = __DIR__ . "/../../view/images/logologin.png";


$result = PersonaAdo::reporteColegiado($_GET["idDni"]);

if (!is_array($result)) {
    echo "El parametro ingresado no contiene el valor esperado.";
    echo $result;
    return;
}

$colegiado = $result[0];
$colegiatura = $result[2];
$aportaciones = $result[3];

$html = '
<html>
<head>
<style>
    body{
        font-family: "Helvetica Neue", Helvetica, Arial;
    }

    table thead th {
        padding: 5px;
        font-size: 13px;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }

    table tbody td {
        font-size: 13px;
        padding: 1mm 2mm;
        border-left: 0.1mm solid #000000;
        border-right: 0.1mm solid #000000;
        border-top: 0.1mm solid #000000;
        border-bottom: 0.1mm solid #000000;
    }

    .text-center{
        text-align: center;
    }

    .text-right{
        text-align: right;
    }
    
    .mt-2{
       padding: 1mm 1mm 1mm 0mm;
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
                <h3>RESUMEN DE INGRESOS </h3>                                               
                <p>COLEGIO DE INGENIEROS DEL PERÚ - CONSEJO DEPARTAMENTAL DE JUNÍN </p>   
            </td>
        </tr>
    </table>

    <h4>Resumen General</h4>
    
    <table border="0" cellspacing="0">
        <tr>
            <td class="mt-2">
                N° Cip
            </td>
            <td class="mt-2">
                : ' . $colegiado->CIP . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                N° Dni
            </td>
            <td class="mt-2">
                : ' . $colegiado->NumDoc . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                Nombres
            </td>
            <td class="mt-2">
                : ' . $colegiado->Nombres . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                Apellidos
            </td>
            <td class="mt-2">
                : ' . $colegiado->Apellidos . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                Genero
            </td>
            <td class="mt-2">
                : ' . $colegiado->Sexo . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                Fec. Nac.
            </td>
            <td class="mt-2">
                : ' . $colegiado->FechaNac . '
            </td>
        </tr>
        <tr>
            <td class="mt-2">
                Condición
            </td>
            <td class="mt-2">
                : ' . $colegiado->condicion . '
            </td>
        </tr>
    </table>

    <h4>Colegiatura</h4>

    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Fecha Incorporación</th>
                <th width="25%">Capitulo</th>
                <th width="25%">Especialidad</th>
            </tr>            
        </thead>
        <tbody>';
$count = 0;
foreach ($colegiatura as $value) {
    $count++;
    $html .= '
                    <tr>
                        <td class="text-center">' . $count . '</td>
                        <td class="text-center">' . $value->FechaColegiado . '</td>
                        <td class="text-center">' . $value->Capitulo . '</td>
                        <td class="text-center">' . $value->Especialidad . '</td>
                    </tr>
                    ';
}

$html .= '</tbody>
    </table>

    <h4>Resumen de Pagos</h4>
    
    <table width="100%" border="0" cellspacing="0">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Fecha de Pago</th>
                <th width="25%">Concepto</th>
                <th width="25%">Monto</th>
                <th width="25%">Observación</th>
            </tr>            
        </thead>
        <tbody>';
$count = 0;
foreach ($aportaciones as $value) {
    $count++;
    $html .= '<tr>
            <td class="text-center">' . $count . '</td>
            <td class="text-center">' . date("d/m/Y", strtotime($value->Fecha)) . '</td>
            <td>' . $value->TipoIngreso . '</td>
            <td class="text-right">' . number_format(round($value->Total, 2, PHP_ROUND_HALF_UP), 2, '.', '')  . '</td>
            <td>' . $value->Observacion . '</td>
            </tr>';
}

$html .= '</tbody>
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
