<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Content-Type: application/json; charset=UTF-8');
date_default_timezone_set('America/Lima');

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

$body = json_decode(file_get_contents("php://input"), true);
$fechaactual = new DateTime('now');
$yearinicio = substr($fechaactual->format("Y"), 0, 2);

$data =  array(
    'card_number' => $body["card_number"],
    'cvv' => $body["cvv"],
    'expiration_month' => $body["expiration_month"],
    'expiration_year' => $yearinicio . $body["expiration_year"],
    'email' => $body["email"],
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


    /*
10 = 10 00
100 = 100 00
*/
    // Creando Cargo a una tarjeta

    // $porcetaje = 4.20 / 100; //0.042
    // $monto = floatval($body["monto"]) + 2;
    // $igv = 18;
    // $comision = $monto * $porcetaje; //4.20
    // $igv = $comision * ($igv / 100); //0.756
    // $total = round($monto + $comision + $igv, 0, PHP_ROUND_HALF_UP) * 100;
    $total = floatval($body["monto"]) * 100;

    /*
240 s
240.46 d
0.46
*/


    $data =  array(
        "amount" => $total,
        "currency_code" => "PEN",
        "email" => $body["email"],
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
        print json_encode(
            array(
                "estado" => 1,
                "data" => "Se registro correctamente el pago.",
                "result" => (object)json_decode($resp)
            )
        );
    } else {
        print json_encode(
            array(
                "estado" => 0,
                "message" => "Error en procesar el pago, intente nuevamente en un par de minutos.",
                "error" => (object)json_decode($resp)
            )
        );
        // $result = (object)json_decode($resp);
        // var_dump($result);
    }
} else {
    $result = (object)json_decode($resp);
    print json_encode(
        array(
            "estado" => 0,
            "message" => "Error al crear el token id, intente nuevamente porfavor.",
            "error" => $result
        )
    );
}
