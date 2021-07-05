<?php


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

$data =  array(
    'card_number' => "5111111111111118",
    'cvv' => "039",
    'expiration_month' => "06",
    'expiration_year' => "2025",
    'email' => "richard@piedpiper.com"
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

    $data =  array(
        "amount" => "10000",
        "currency_code" => "PEN",
        "email" => "perrisd@piedpiper.com",
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
        print "bien";
    } else {
        print "Error al crear cobro, intente nuevamente porfavor.";
        // $result = (object)json_decode($resp);
        // var_dump($result);
    }

} else {
    print "Error al crear el token id, intente nuevamente porfavor.";
}
