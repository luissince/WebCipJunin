<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use SysSoftIntegra\Pdf\PdfIngreso;
use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../src/autoload.php';

try {
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

            $rutaImage = "../../view/images/logologin.png";
            $nombre = $empresa->RazonSocial;
            $direccion = $empresa->Domicilio;
            $web = $empresa->PaginaWeb;
            $email = $empresa->Email;
            $telefono = "Tesorería " . $empresa->Telefono . " Anexo 202";
            $ruc = $empresa->NumeroDocumento;

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

            $fileName = $ingreso->Comprobante . " " . $ingreso->Serie . '-' . $ingreso->Numeracion;

            $contenidoXml = $ingreso->Xmlgenerado;

            if ($contenidoXml != "") {
                $documentXml = fopen($fileName . ' CIP-JUNIN.xml', 'a');
                fwrite($documentXml, $contenidoXml);
                fclose($documentXml);
            }

            $mpdf = PdfIngreso::createPdf($rutaImage, $nombre, $direccion, $telefono, $email, $web, $ruc, $ingreso, $detalleIngreso, $cuotas, $totales, $textoCodBar);
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
            $mail->Host       = 'smtp-mail.outlook.com.';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true; //"login";                    //Enable SMTP authentication
            $mail->Username   = $fromEmail;                     //SMTP username
            $mail->Password   = 'Soporte2022';                               //SMTP password
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
                                            <td style="width:60%; font-size:18px; font-weight:bold;text-align: center;">
                                                <img width ="100" src="cid:logoCip">
                                                <h2> COLEGIO DE INGENIEROS DEL PERÚ</h2>
                                            </td>
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

            $mail->AltBody = 'Ingeniero(a): ' . $ingreso->Apellidos . ' ' . $ingreso->Nombres . ' Reciba nuestro más cordial saludo, se le escribe para informarle que el 
                            comprobante emitido hacia su persona fue realizado con éxito. Adjuntamos dicho comprobante.';

            //Attachments
            $mail->addAttachment($fileName . " CIP-JUNIN.pdf");

            if ($contenidoXml != "") {
                $mail->addAttachment($fileName . " CIP-JUNIN.xml");
            }
            $mail->send();

            print json_encode(array(
                "estado" => 1,
                "message" => 'Su mensaje ha sido enviado con exito'
            ));
        }
    }
} catch (Exception $ex) {
    print json_encode(array(
        "estado" => 0,
        "message" => "El mensaje no pudo ser enviado. Mailer Error",
        "error" => $ex->getMessage(),
    ));
} finally {
    if (!is_null($fileName)) {
        if (is_file($fileName . " CIP-JUNIN.pdf") && file_exists($fileName . " CIP-JUNIN.pdf")) {
            unlink($fileName . " CIP-JUNIN.pdf");
        }
        if (is_file($fileName . " CIP-JUNIN.xml") && file_exists($fileName . " CIP-JUNIN.xml")) {
            unlink($fileName . " CIP-JUNIN.xml");
        }
    }
}
