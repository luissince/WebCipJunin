<?php

$body = json_decode(file_get_contents("php://input"), true);
$postdata = http_build_query(
    array(
        'idDni' => $_GET["idDni"],
    )
);
$opts = array(
    'http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-Type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);
$data = file_get_contents('http://localhost:5000/api/informacion', false, $context);
$manage = json_decode($data);
print json_encode($manage);
