<?php

namespace Utils\Classes;

/**
 * Simple wrapper for HTTP-request
 * Class Request
 * @package Utils\Classes
 */
class Request
{
    public static function getParams()
    {
        return $_REQUEST;
    }

    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getFullUrl()
    {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function getRequestUriParts()
    {
        $uriParts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        return $uriParts;
    }
}