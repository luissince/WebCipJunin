<?php

namespace SysSoftIntegra\Src;

class Tools
{

    public static function formatNumber($numeracion, $length = 6)
    {
        return strlen($numeracion) > $length ? $numeracion : substr(str_repeat(0, $length) . $numeracion, -$length);
    }

    public static function my_encrypt($encrypt, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $encrypted = openssl_encrypt($encrypt, 'AES-256-CBC', $key, 0, $iv);
        return rawurlencode(str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($encrypted . "::" . $iv)));
    }

    public static  function my_decrypt($encrypted, $key)
    {
        $explote = explode(
            '::',
            base64_decode(str_replace(['-', '_'], ['+', '/'], rawurldecode($encrypted))),
            2
        );

        if (count($explote) <= 0) {
            return "error";
        }

        if (!isset($explote[0])) {
            return "error";
        }

        if (!isset($explote[1])) {
            return "error";
        }

        list($encrypt, $iv) = $explote;
        return openssl_decrypt($encrypt, 'AES-256-CBC', $key, 0, $iv);
    }

    public static function printErrorJson($data)
    {
        header('Content-Type: application/json; charset=UTF-8');
        print json_encode($data);
        exit();
    }

    /**
     * @param int $month
     *
     * @return string
     */
    public static function MonthName(int $month)
    {
        $months =  ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre", "Diciembre"];
        return $months[$month - 1];
    }
}
