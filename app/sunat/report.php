<?php
set_time_limit(500);
define('_MPDF_PATH', '/lib');
require_once('lib/mpdf/vendor/autoload.php');
require_once("lib/phpqrcode/qrlib.php");
require_once '../../app/database/DataBaseConexion.php';

$cmdConcepto = Database::getInstance()->getDb()->prepare("SELECT i.idIngreso,convert(VARCHAR, CAST(i.Fecha AS DATE),103) AS Fecha,i.Serie,i.NumRecibo,
            p.CIP,p.idDNI,p.Apellidos,p.Nombres,sum(d.Monto) AS Total
            FROM Ingreso AS i INNER JOIN Persona AS p
            ON i.idDNI = p.idDNI
            INNER JOIN Detalle AS d 
            ON d.idIngreso = i.idIngreso
            GROUP BY i.idIngreso,i.Fecha,i.Serie,i.NumRecibo,
            p.CIP,p.idDNI,p.Apellidos,p.Nombres
            ORDER BY CAST(Fecha AS DATE) ASC
            offset 0 ROWS FETCH NEXT 10 ROWS only");
$cmdConcepto->execute();



$rutaImage = __DIR__ . "/../images/logologin.png";
$title = "INGRESOS";
$fechaIngreso = "DE LA FECHA: 11/02/2020";
$recibos = "RECIBOS DEL : B001-000001 al B001-000002";
$sumaTotal = 0;

    $html = '
<html>
<head>
<style>
body {
    font-family: sans-serif;
	font-size: 10pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
}
td { 
    vertical-align: top; 
}
.items th {
    border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
    border-top: 0.1mm solid #000000;
    border-bottom: 0.1mm solid #000000;
}
.items td {
	border-left: 0.1mm solid #000000;
    border-right: 0.1mm solid #000000;
    border-top: 0.1mm solid #000000;
    border-bottom: 0.1mm solid #000000;
}
table thead td { background-color: #EEEEEE;
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.cost {
	text-align: "." center;
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
        <td width="15%" style="border: 0mm solid #888888; ">
            <img src="' . $rutaImage . '" style="width:80px;">
        </td>
        <td width="85%" style="border: 0mm solid #888888;text-align: center;vertical-align: middle;">
            <span style="font-size: 15pt; color: black; font-family: sans;">
                <b>' . $title . ' </b>
            </span>
            <br>
            <span style="font-size: 10pt; color: black; font-family: sans;">
               
        </span>
        </td>
    </tr>
</table>
<div style="text-align: right">
    
</div>
<br />
<table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; " cellpadding="8">
    <thead>
        <tr>
            <th width="5%">N°</th>
            <th width="10%">Fecha</th>
            <th width="13%">Comprobante</th>
            <th width="25%">RUC/ Dni</th>
            <th width="35%">Cliente</th>
            <th width="10%" >Total</th>
        </tr>
    </thead>
    <tbody>
<!-- ITEMS HERE -->
' ?>

<?php
$count = 0;
while ($row = $cmdConcepto->fetch()) {
    // $count++;
    // array_push($arrayIngresos, array(
    //     "id"=>$count+$posicionPagina,
    //     "idIngreso" => $row["idIngreso"],
    //     "fecha" => $row["Fecha"],
    //     "serie" => $row["Serie"],
    //     "numRecibo" => $row["NumRecibo"],
    //     "cip" => $row["CIP"],
    //     "idDNI" => $row["idDNI"],
    //     "apellidos" => $row["Apellidos"],
    //     "nombres" => $row["Nombres"],
    //     "total" => $row["Total"],
    // ));
    $count++;
    $html .= '<tr>
    <td align="center">'.$count.'</td>
    <td align="center">'.$row["Fecha"].'</td>
    <td>'.$row["Serie"].'-'.$row["NumRecibo"].'</td>
    <td align="center">'.$row["idDNI"].'</td>
    <td align="center">'.$row["Nombres"].' '.$row["Apellidos"].'</td>
    <td align="right">'.number_format($row["Total"],2,".","").'</td>
</tr>';
$sumaTota+=$row["Total"];
}

$html .= '  
<!-- END ITEMS HERE -->
    </tbody>
    <!-- <tfoot>
        <tr>
            <td align="center"></td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
            <td align="right">0.00</td>
        </tr>
    </tfoot>!-->
</table>
<br>
<div>
    <span style="font-size:11pt;font-weight:bold;">RESUMEN GENERAL</span>
</div>
<table class="items" width="30%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>        
        <tr>
            <th align="left">EFECTIVO:</th>
            <th align="right">0.00</th>
        </tr>
        <tr>
            <th align="left">EN DEPOSITO</th>
            <th align="right">0.00</th>
        </tr>
        <tr>
            <th align="left">TOTAL</th>
            <th align="right">'.number_format($sumaTota,2,".","").'</th>
        </tr>
    </thead>
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
$mpdf->SetTitle("Acme Trading Co. - Invoice");
$mpdf->SetAuthor("Acme Trading Co.");
$mpdf->SetWatermarkText("");
$mpdf->showWatermarkText = true;
$mpdf->watermark_font = 'DejaVuSansCondensed';
$mpdf->watermarkTextAlpha = 0.1;
$mpdf->SetDisplayMode('fullpage');

$mpdf->WriteHTML($html);

$mpdf->Output();
