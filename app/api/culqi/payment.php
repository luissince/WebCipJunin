<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');

require '../../database/DataBaseConexion.php';

// $body = json_decode(file_get_contents("php://input"), true);
// $postdata = http_build_query(
//     array(               
//         'card_number' => "4111111111111111",
//         'cvv' => "123",
//         'expiration_month' => "09",
//         'expiration_year' => "2025",
//         'email' => "richard@piedpiper.com"
//     )
// );
// $opts = array(
//     'http' =>
//     array(
//         'method'  => 'POST',
//         'header'  => ['Content-Type: application/json','Authorization: Bearer pk_test_69979cc0fa24d426'],
//         'content' => $postdata
//     )
// );

// $context  = stream_context_create($opts);
// $data = file_get_contents('https://secure.culqi.com/v2/tokens', false, $context);
// $manage = json_decode($data);
// print json_encode($manage);

try {
    $body = json_decode(file_get_contents("php://input"), true);

    $fechaactual = new DateTime('now');
    $yearinicio = substr($fechaactual->format("Y"), 0, 2);

    $request = (object)$body;

    $data =  array(
        'card_number' => $request->card_number,
        'cvv' => $request->cvv,
        'expiration_month' => $request->expiration_month,
        'expiration_year' => $yearinicio . $request->expiration_year,
        'email' => $request->email,
    );

    $data_string = json_encode($data);

    $url = "https://secure.culqi.com/v2/tokens";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer pk_test_69979cc0fa24d426'
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);

    $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_code == 201) {
        $result = (object)json_decode($resp);

        $total = floatval($request->monto) * 100;

        $data =  array(
            "amount" => $total,
            "currency_code" => "PEN",
            "email" => $request->email,
            "source_id" =>  $result->id
        );

        $data_string = json_encode($data);

        $url = "https://api.culqi.com/v2/charges";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer sk_test_6d00f5f32b58adea'
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);

        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_code == 201) {

            try {
                Database::getInstance()->getDb()->beginTransaction();

                $codigoSerieNumeracion = Database::getInstance()->getDb()->prepare("SELECT dbo.Fc_Serie_Numero(?)");
                $codigoSerieNumeracion->bindParam(1, $body["idTipoDocumento"], PDO::PARAM_STR);
                $codigoSerieNumeracion->execute();
                $serie_numeracion = explode("-", $codigoSerieNumeracion->fetchColumn());

                $idEmpresa = null;

                if ($request->empresa != null) {
                    $empresa = Database::getInstance()->getDb()->prepare("SELECT * FROM EmpresaPersona WHERE NumeroRuc = ?");
                    $empresa->execute(array($request->empresa["numero"]));
                    $resultEmpresa = $empresa->fetchObject();

                    if ($resultEmpresa) {
                        $idEmpresa = $resultEmpresa->IdEmpresa;
                    } else {
                        $empresa = Database::getInstance()->getDb()->prepare("INSERT INTO EmpresaPersona(NumeroRuc,Nombre,Direccion,Telefono,PaginaWeb,Email)VALUES(?,?,?,'','','')");
                        $empresa->execute(array(
                            $request->empresa["numero"],
                            $request->empresa["cliente"],
                            is_null($request->empresa["direccion"]) ? "" : $request->empresa["direccion"],
                        ));

                        $idEmpresa = Database::getInstance()->getDb()->lastInsertId();
                    }
                }

                $cmdIngreso = Database::getInstance()->getDb()->prepare("INSERT INTO Ingreso(
                idDni,
                idEmpresaPersona,
                TipoComprobante,
                Serie,
                NumRecibo,
                Fecha,
                Hora,
                idUsuario,
                Estado,
                Deposito,
                Observacion,
                Tipo,
                idBanco,
                NumOperacion
                )VALUES(?,?,?,?,?,GETDATE(),GETDATE(),?,?,0,?,?,?,?)");
                $cmdIngreso->execute(array(
                    $request->idPersona,
                    $idEmpresa,
                    $request->idTipoDocumento,
                    $serie_numeracion[0],
                    $serie_numeracion[1],
                    $request->idUsuario,
                    $request->estado,
                    is_null($request->descripcion) ? "" : is_null($request->descripcion),
                    $request->tipo,
                    $request->idBanco,
                    is_null($request->numOperacion) ? "" : $request->numOperacion
                ));

                $idIngreso = Database::getInstance()->getDb()->lastInsertId();

                if ($request->estadoCuotas == true) {
                    $cmdCuota = Database::getInstance()->getDb()->prepare("INSERT INTO Cuota(idIngreso,FechaIni,FechaFin) VALUES(?,?,?)");
                    $cmdCuota->execute(array(
                        $idIngreso,
                        $request->cuotasInicio,
                        $request->cuotasFin
                    ));
                }

                if ($request->estadoCertificadoHabilidad == true) {
                    if ($request->estadoCuotas == true) {
                        $resultPago = $request->cuotasFin;
                    } else {
                        $cmdUltimoPago = Database::getInstance()->getDb()->prepare("SELECT 
                CAST(ISNULL(ul.FechaUltimaCuota, c.FechaColegiado) AS DATE) AS UltimoPago     
                FROM Persona AS p INNER JOIN Colegiatura AS c
                ON p.idDNI = c.idDNI AND c.Principal = 1
                LEFT OUTER JOIN ULTIMACuota AS ul
                ON p.idDNI = ul.idDNI
                WHERE p.idDNI = ?");
                        $cmdUltimoPago->execute(array($request->idPersona));
                        $resultUltimoPago = $cmdUltimoPago->fetchObject();

                        if (!$resultUltimoPago) {
                            throw new Exception("Erro en obtener la fecha del ultimo pago.");
                        }
                        $resultPago = $resultUltimoPago->UltimoPago;
                    }

                    $cmdIngeniero = Database::getInstance()->getDb()->prepare("SELECT Condicion FROM Persona WHERE idDNI = ?");
                    $cmdIngeniero->execute(array($request->idPersona));
                    $resultIngeniero = $cmdIngeniero->fetchObject();

                    $date = new DateTime($resultPago);
                    if ($resultIngeniero->Condicion == "V") {
                        $date->modify('+9 month');
                        $date->modify('last day of this month');
                    } else if ($resultIngeniero->Condicion == "T") {
                        $fechanow = new DateTime('now');
                        $date =  $fechanow;
                        $date->modify('+3 month');
                        $date->modify('last day of this month');
                    } else {
                        $date->modify('+3 month');
                        $date->modify('last day of this month');
                    }
                    $ultimoPago = $date->format('Y-m-d');

                    $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT * FROM CorrelativoCERT WHERE TipoCert = 1");
                    $cmdCorrelativo->execute();
                    if (!$cmdCorrelativo->fetch()) {
                        $resultCorrelativo = 1;
                    } else {
                        $cmdCorrelativo = Database::getInstance()->getDb()->prepare("SELECT MAX(Numero)+1  FROM CorrelativoCERT WHERE TipoCert = 1");
                        $cmdCorrelativo->execute();
                        $resultCorrelativo = $cmdCorrelativo->fetchColumn();
                    }

                    $cmdCertHabilidad = Database::getInstance()->getDb()->prepare("INSERT INTO CERTHabilidad(idIUsuario,idColegiatura,Numero,Asunto,Entidad,Lugar,Fecha,HastaFecha,Anulado,idIngreso) VALUES(?,?,?,?,?,?,GETDATE(),?,?,?)");
                    $cmdCertHabilidad->execute(array(
                        $request->idUsuario,
                        $request->objectCertificadoHabilidad["idEspecialidad"],
                        $resultCorrelativo,
                        $request->objectCertificadoHabilidad["asunto"],
                        $request->objectCertificadoHabilidad["entidad"],
                        $request->objectCertificadoHabilidad["lugar"],
                        $ultimoPago,
                        $request->objectCertificadoHabilidad["anulado"],
                        $idIngreso
                    ));

                    $cmdCorrelativo = Database::getInstance()->getDb()->prepare("INSERT INTO CorrelativoCERT(TipoCert,Numero) VALUES(1,?)");
                    $cmdCorrelativo->execute(array($resultCorrelativo));
                }

                foreach ($request->ingresos as $value) {
                    $cmdDetalle = Database::getInstance()->getDb()->prepare("INSERT INTO Detalle(
            idIngreso,
            idConcepto,
            Cantidad,
            Monto
            )VALUES(?,?,?,?)");
                    $cmdDetalle->execute(array(
                        $idIngreso,
                        $value['idConcepto'],
                        $value['cantidad'],
                        $value['monto'],
                    ));
                }

                Database::getInstance()->getDb()->commit();
                print json_encode([
                    "status" => 1,
                    "message" => "Se registro correctamente el pago."
                ]);
            } catch (PDOException $ex) {
                Database::getInstance()->getDb()->rollBack();
                print json_encode([
                    'status' => 0,
                    'message' => $ex->getMessage(),
                ]);
            } catch (Exception $ex) {
                Database::getInstance()->getDb()->rollBack();
                print json_encode([
                    'status' => 0,
                    'message' => $ex->getMessage(),
                ]);
            }
        } else {
            print json_encode([
                "status" => 0,
                "message" => ((object)json_decode($resp))->merchant_message
            ]);
        }
    } else {
        print json_encode([
            "status" => 0,
            "message" => "Error al crear el token id, intente nuevamente porfavor."
        ]);
    }
} catch (Exception $ex) {
    print json_encode(
        array(
            "status" => 0,
            "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
        )
    );
}
