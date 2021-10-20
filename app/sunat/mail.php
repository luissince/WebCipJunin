<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

define('_MPDF_PATH', '/lib');
require('./lib/mpdf/vendor/autoload.php');
require_once("./lib/phpqrcode/qrlib.php");
include_once('../model/IngresosAdo.php');
require __DIR__ . './../src/autoload.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use SysSoftIntegra\Src\NumberLleters;

//Load Composer's autoloader
require './lib/phpmail/vendor/autoload.php';

try {

    //datos traidos de ingresos
    $emailDestiny = $_POST["correodestino"];
    $idIngreso = $_POST["idIngreso"];

    $detalleventa = IngresosAdo::ObtenerIngresoXML($idIngreso);
    if (!is_array($detalleventa)) {
        print json_encode(array(
            "estado" => 0,
            "message" => "El mensaje no es un array",
        ));
    } else {
        if (!isset($detalleventa[3])) {
            print json_encode(array(
                "estado" => 0,
                "message" => "Hay con valores nulos en el registro de empresa, por favor corregir."
            ));
        } else {
            $ingreso = $detalleventa[0];
            $detalleIngreso = $detalleventa[1];
            $cuotas = $detalleventa[2];
            $empresa = $detalleventa[3];
            $totales = $detalleventa[4];

            $rutaImage = "../../view/images/logoemail.png";
            $nombre = $empresa->RazonSocial;
            $direccion = $empresa->Domicilio;
            $web = $empresa->PaginaWeb;
            $email = $empresa->Email;
            $telefono = "Tesorería " . $empresa->Telefono . " Anexo 202";
            $ruc = $empresa->NumeroDocumento;

            $gcl = new NumberLleters();

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
                <!--#########################Fin de la cabecera###################################--
                <!--#####este es el contenedor donde se encuentra toda la informacion correspondiente del cliente########-->
                <div class="container-info">
                    <div class="caja-two" >
                        <table  style="font-family: arial;" cellpadding="1" border="0">
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>' . $ingreso->NombreDocumento . '</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b> ' . $ingreso->NumeroDocumento . '</td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>' . $ingreso->TipoNombrePersona . '</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b>' . $ingreso->DatosPersona . '</td>
                            </tr>
                            <tr>
                                <td style="line-height: 0px;padding:2px 0px;"><b>Dirección</b></td>
                                <td style="line-height: 0px;padding:2px 0px;"><b>: </b>' . $ingreso->Direccion . ' </td>
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
                                if ($ingreso->CIP != "") {
                                    $html .= '<tr>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>Ref</b></td>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>:</b> N° Cip ' . $ingreso->CIP . ' - ING. ' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . '</td>
                                    </tr>  ';
                                    $html .= '<tr>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>Cap. - Especia.</b></td>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>:</b> ' . $ingreso->Capitulo . ' - ' . $ingreso->Especialidad . '</td>
                                    </tr>  ';
                                }
                            } else {
                                if ($ingreso->CIP != "") {
                                    $html .= '<tr>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>Cap. - Especia.</b></td>
                                    <td style="line-height: 0px;padding:2px 0px;"><b>:</b> ' . $ingreso->Capitulo . ' - ' . $ingreso->Especialidad . '</td>
                                    </tr>  ';
                                }
                            }
                            ?>
                            <?php
                            $html .= '</table>
                    </div>
                </div>
                <!--#####################Fin de la caja de informacion del cliente###################################--
                <!--##################### Inicio detalle de la compra ###################################-->
                <div class="detalle-compra" >
                    <table width="100%" style="font-family:Arial;font-size: 14px; border: none; border-collapse: collapse;" cellpadding="6">
                        <thead>
                            <tr>
                                <th width="10%" class="th-white">Ítem</td>                    
                                <th width="50%" class="th-dark">Concepto</td>
                                <th width="15%" class="th-dark">Cantidad</td>                    
                                <th width="15%" class="th-dark">P. Unitario</td>                         
                                <th width="15%" class="th-white">Importe</td>
                            </tr>
                        </thead>
                        <tbody>';
                            ?>
                            <?php foreach ($detalleIngreso as $value) {
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
                            }
                            $html .= '</tbody>
                    </table>
                        
                    <div style="font-style: italic;font-weight: bold;padding:5px 0px;">' . (isset($cuotas->Pago) ? 'CUOTAS: ' . $cuotas->Pago : '') . '</div>
                        
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

                            $fileName = $ingreso->Comprobante . " " . $ingreso->Serie . '-' . $ingreso->Numeracion;

                            $mpdf->SetProtection(array('print'));
                            $mpdf->SetTitle($fileName . " CIP-JUNIN");
                            $mpdf->SetAuthor("SysSoftIntegra");
                            $mpdf->SetWatermarkText(($ingreso->Estado === "C" ? "PAGADO" : "ANULADO"));   // anulada
                            $mpdf->showWatermarkText = true;
                            $mpdf->watermark_font = 'DejaVuSansCondensed';
                            $mpdf->watermarkTextAlpha = $ingreso->Estado === "C" ? 0.1 : 0.5;
                            $mpdf->SetDisplayMode('fullpage');
                            $mpdf->WriteHTML($html);
                            // Output a PDF file directly to the browser
                            $mpdf->Output($fileName . " CIP-JUNIN.pdf", 'F');

                            //Create an instance; passing `true` enables exceptions
                            $mail = new PHPMailer(true);

                            $fromname = "Tesorería Colegio de Ingenieros del Perú - CD Junín";
                            $fromEmail = "tesoreria@cip-junin.org.pe";



                            // Server settings
                            $mail->isSMTP();                                        //Send using SMTP
                            $mail->CharSet = 'UTF-8';                           //traer caracteres especiales
                            $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                            $mail->Host       = 'smtp.live.com';                     //Set the SMTP server to send through
                            $mail->SMTPAuth   = true; //"login";                    //Enable SMTP authentication
                            $mail->Username   = $fromEmail;                     //SMTP username
                            $mail->Password   = 'ingenieros_2021';                               //SMTP password
                            $mail->SMTPSecure = "TLS";            //Enable implicit TLS encryption
                            $mail->Port       = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`


                            //Recipients
                            $mail->setFrom($fromEmail, $fromname);
                            $mail->addAddress($emailDestiny);     //Add a recipient
                            $mail->AddEmbeddedImage($rutaImage, 'logoCip');
                            // $mail->addAddress('ellen@example.com');               //Name is optional
                            // $mail->addReplyTo('info@example.com', 'Information');
                            // $mail->addCC('cc@example.com');
                            // $mail->addBCC('bcc@example.com');    

                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML
                            $mail->Subject = ' EMISIÓN DEL COMPROBANTE: ' . $fileName;
                            $mail->Body = '<html>
                                <head>
                                    <meta charset="utf-8">
                                </head>
                                <body>
                                    <table style="background:#ECECEC; padding-top:25px;padding-bottom:25px;border-radius:20px;">
                                        <tr style="width:100%;">
                                            <td style="width:20%;"></td>
                                            <td style="width:60%; font-size:18px; font-weight:bold;text-align: center;"><img src="cid:logoCip"><h2> COLEGIO DE INGENIEROS DEL PERÚ</h2></td>
                                            <td style="width:20%;"></td>
                                        </tr>
                                        <tr style="width:100%;">
                                            <td style="width:20%;"></td>
                                            <td style="width:60%; font-size:18px; padding-left:15px;">Ingeniero(a): ' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . '</td>
                                            <td style="width:20%;"></td>
                                        </tr>
                                        <tr style="width:100%;">
                                            <td style="width:20%;"></td>
                                            <td style="width:60%; font-size:18px; ">Reciba nuestro más cordial saludo, se le escribe para informarle que el 
                                             comprobante emitido hacia su persona fue realizado con éxito. Adjuntamos dicho comprobante.</td>
                                            <td style="width:20%;"></td>
                                        </tr>
                                        <tr style="width:100%;">
                                            <td style="width:20%;"></td>
                                            <td style="width:60%; font-size:18px; ">Cualquier duda escribanos.</td>
                                            <td style="width:20%;"></td>
                                        </tr>
                                        <tr style="width:100%; padding-top: 20px;">
                                            <td style="width:20%;"></td>
                                            <td style="width:60%; font-size:18px;text-align: center; font-weight: bold;">Tesorería.</td>
                                            <td style="width:20%;"></td>
                                        </tr>
                                    </table>
                                </body>
                            </html>';

                            // $mail->Body    = 'Saludos Ingeniero(a): ' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . '</b> 
                            //                     Se le adjunta el comprobante emitido hacia su persona </b> Saludos Coordiales';
                            $mail->AltBody = 'Ingeniero(a): ' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . ' Reciba nuestro más cordial saludo, se le escribe para informarle que el 
                            comprobante emitido hacia su persona fue realizado con éxito. Adjuntamos dicho comprobante.';

                            //Attachments
                            $mail->addAttachment($fileName . " CIP-JUNIN.pdf");         //Add attachments
                            // $mail->addAttachment('./images/accept.svg');         //Add attachments
                            // $mail->addAttachment('./images/ayuda.png', 'imagen');    //Optional name

                            $mail->send();

                            // echo 'Message has been sent';
                            print json_encode(array(
                                "estado" => 1,
                                "message" => 'Su mensaje ha sido enviado con exito'
                            ));
                        }
                    }
                } catch (Exception $ex) {
                    //     // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    print json_encode(array(
                        "estado" => 0,
                        "message" => "El mensaje no pudo ser enviado. Mailer Error",
                        "error" => $ex->getMessage(),
                    ));
                } finally {
                    if (!is_null($fileName)) {
                        unlink($fileName . " CIP-JUNIN.pdf");
                    }
                }
