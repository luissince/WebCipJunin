<?php

namespace SysSoftIntegra\Src;

class Route
{
    public static function get($uri, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if ($_GET["type"] === $uri) {
                $body = $_GET;
                $callback($body);
            }
        }
    }

    public static function post($uri, $callback)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $body = json_decode(file_get_contents("php://input"), true);
            if ($body["type"] === $uri) {
                $callback($body);
            }
        }
    }
}
