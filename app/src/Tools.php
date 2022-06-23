<?php


namespace SysSoftIntegra\Src;

use Exception;

class Tools
{

    public static function my_encrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    public static  function my_decrypt($data, $key)
    {
        try {
            $encryption_key = base64_decode($key);
            $array = explode(
                '::',
                base64_decode($data),
                2
            );
            if (isset($array[1])) {
                // return $array[1];
                list($encrypted_data, $iv) = $array;

                return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
            } else {
                throw new Exception("Token invalido");
            }
        } catch (Exception $ex) {
            return "error";
        }
    }
}
