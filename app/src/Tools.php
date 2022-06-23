<?php


namespace SysSoftIntegra\Src;

use Exception;

class Tools
{

    public static function my_encrypt($encrypt, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $encrypted = openssl_encrypt($encrypt, 'AES-256-CBC', $key, 0, $iv);
        return strtr(base64_encode($encrypted . "::" . $iv), '+/=', '._-');
    }

    public static  function my_decrypt($encrypted, $key)
    {
        $explote = explode(
            '::',
            base64_decode(strtr($encrypted, '._-', '+/=')),
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
}
