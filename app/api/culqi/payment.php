<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');

use SysSoftIntegra\Model\IngresosAdo;

require __DIR__ . './../../src/autoload.php';

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

    //producción
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer pk_live_1a97fceff3c6af2b'
    );
    // $headers = array(
    //     'Content-Type: application/json',
    //     'Authorization: Bearer pk_test_26dcfdea67bea7fa'
    // );
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

        //producción
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer sk_live_a5979cee8160335b'
        );
        // $headers = array(
        //     'Content-Type: application/json',
        //     'Authorization: Bearer sk_test_77dae825c0fe1175'
        // );
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
            print json_encode(IngresosAdo::payment($request));
        } else {
            print json_encode([
                "state" => 0,
                "message" => ((object)json_decode($resp))->merchant_message
            ]);
        }
    } else {
        print json_encode([
            "state" => 0,
            "message" => "Error al crear el token id, intente nuevamente porfavor."
        ]);
    }
} catch (Exception $ex) {
    print json_encode(
        array(
            "state" => 0,
            "message" => "Error de conexión, intente nuevamente en un parte de minutos.",
            "error" => $ex->getMessage()
        )
    );
}
