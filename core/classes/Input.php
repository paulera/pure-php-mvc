<?php

class Input
{

    public static function explodePath()
    {
        $vars = array();
        if (isset($_SERVER['QUERY_STRING'])) {
            parse_str($_SERVER['QUERY_STRING'], $vars);
        }
        
        if (isset($_SERVER["PATH_INFO"])) {
            $path = trim($_SERVER["PATH_INFO"], '/');
            $pathParts = explode('/', $path);
        } else {
            $pathParts = array();
        }
        
        return $pathParts;
    }
    
}