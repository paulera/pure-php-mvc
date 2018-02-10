<?php


class Env
{
    
    private static $_config = array();
    
    private static $_web = null;
    private static $_base = null;
    
    /**
     * Read/set configuration. 
     * @param array $config Returns the config array. Stores (only once) if
     * array is passed as param - boot.php does it).
     * @return array Configuration array 
     */
    public static function config($config = null) {
        if (isset($config)) {
            if (isset(self::$_config) && count(self::$_config)) {
                Utils::log('Configuration already set.');
            } else if (!is_array($config)) {
                Utils::log('Configuration must be an array.');
            } else {
                self::$_config = $config;
            }
        }
        return self::$_config;
    }
    
    
    public static function web() {
        if (!isset(self::$_web)) {
            self::$_web = 'http://'.self::$_config['static_url'];
        }
        return self::$_web;
    }
    
    public static function base() {
        if (!isset(self::$_base)) {
            self::$_base = 'http://'.self::$_config['base_url'];
        }
        return self::$_base;
    }
}