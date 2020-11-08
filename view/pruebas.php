<?php
date_default_timezone_set('America/Lima');
$fecha= "2019-12-25";
$dateTime = new DateTime('m/d/Y');

print $dateTime;
print '<br>';

$fechaactual = new DateTime() ;
$fecharegistro = new DateTime('12/24/2019');
$inicio = $fecharegistro->modify('+ 1 month') ;
$array = array();


while($inicio<=$fechaactual){   
    array_push($array,array(
        "mes"=>$inicio->format('m'),
        "monto"=>20,
        "anio"=>$inicio->format('Y')
    ));
    $inicio->modify('+ 1 month') ;

}

print_r($array);
