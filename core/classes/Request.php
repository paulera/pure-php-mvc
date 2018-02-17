<?php
defined('IS_APP') || die();

class Request
{

    private static $_isHttps = null;
    
    private static $_path = null;

    private static $_pageUrlForSeo = null;

    private static $_pathParts = null;
    

    // Keep from creating new instances of this class
    private function __construct()
    {}

    public static function referer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public static function isHttps()
    {
        if (! isset(self::$_isHttps)) {
            self::$_isHttps = isset($_SERVER['HTTPS']) && ! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "off";
        }
        return self::$_isHttps;
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
        if (! isset(self::$_path)) {
            self::$_path = '/' . trim($_SERVER["PATH_INFO"], '/');
        }
        return self::$_path;
    }

    public static function query()
    {
        return $_SERVER['QUERY_STRING'];
    }

    public static function pageUrlForSeo()
    {
        if (! isset(self::$_pageUrlForSeo)) {
            self::$_pageUrlForSeo = self::protocol() . '://' . self::host() . str_ireplace('/index.php', '', self::script()) . self::path();
        }
        return self::$_pageUrlForSeo;
    }

    public static function pathParts()
    {
        if (! isset(self::$_pathParts)) {
            $path = trim(self::path(), '/');
            self::$_pathParts = array_filter(explode('/', $path), function ($value) {
                return ! empty($value);
            });
        }
        return self::$_pathParts;
    }
}