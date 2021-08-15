<?php
try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/WebCipJunin/app/controller/PersonaController.php?type=dataestado&cip=' . $_GET['cip']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $output = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($http_code == 200) {
        $object = (object)json_decode($output);
        echo $object->estado;
    } else {
        echo '0';
    }
    curl_close($ch);
} catch (Exception $e) {
    echo '0';
}
