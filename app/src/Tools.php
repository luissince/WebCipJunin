<?php

namespace SysSoftIntegra\Src;

use Nullix\CryptoJsAes\CryptoJsAes;
use Dotenv\Dotenv;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

$dotenv = Dotenv::createImmutable(__DIR__ . './../../');
$dotenv->load();

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

    public static function encrypt($originalValue)
    {
        $password = $_ENV["CRYPTO_KEY"];
        $encrypted = CryptoJsAes::encrypt($originalValue, $password);
        return urlencode($encrypted);
    }

    public static function decrypt($encrypted)
    {
        $password = $_ENV["CRYPTO_KEY"];
        $decrypted = CryptoJsAes::decrypt(urldecode($encrypted), $password);
        return $decrypted;
    }

    /**
     * @param array|object $data
     * @param int $expired 
     * ejemplo (60) // Tiempo que va durar el token (60 segundos)
     * ejemplo (60*60*24) // Tiempo que va durar el token (1 día)
     * 
     * @return string Genera un token
     */
    public static function createToken($data, $expired)
    {
        $time = time();

        $token = array(
            "iat" => $time,
            "exp" => $time + $expired,
            "data" => $data
        );

        $jwt = JWT::encode($token, $_ENV["TOKEN_KEY"], 'HS256');

        return $jwt;
    }

     /**
     * @param string $jwt Token previamente generado
     * 
     * @return array|string Datos del token|expired|invalid|error
     */
    public static function verifyToken($jwt)
    {
        try {
            return JWT::decode($jwt, new Key($_ENV["TOKEN_KEY"], 'HS256'));
        } catch (ExpiredException $ex) {
            return "expired";
        } catch (SignatureInvalidException $ex) {
            return "invalid";
        } catch (Exception $ex) {
            return "error";
        }
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
