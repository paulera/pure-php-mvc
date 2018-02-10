<?php

class Request
{

    public static function referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function isHttps()
    {
        return isset($_SERVER['HTTPS']) && ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off";
    }

    public static function protocol()
    {
        if (self::isHttps()) {
            return 'https';
        }
        return 'http';
    }

    public static function host()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public static function script()
    {
        return $_SERVER['SCRIPT_NAME'];
    }

    public static function path()
    {
        if (isset($_SERVER["PATH_INFO"])) {
            return trim($_SERVER["PATH_INFO"], '/');
        }
        return '';
    }

    public static function query()
    {
        return $_SERVER['QUERY_STRING'];
    }

    public static function pageUrlForSeo()
    {
        // TODO: staticalize pageUrlForSeo
        return self::protocol() . '://' . self::host() . str_ireplace('/index.php', '', self::script()) . self::path();
    }

    public static function pathParts()
    {
        // TODO: staticalize pathParts
        
        $pathParts = array_filter(explode('/', self::path()), function($value) {
            return !empty($value);
        });
        return $pathParts;
        
    }
}