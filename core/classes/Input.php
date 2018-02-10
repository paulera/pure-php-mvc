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
        } else {
            $path = '';
        }
        
        $pathParts = array();
        foreach (explode('/', $path) as $part) {
            if (!empty($part)) {
                $pathParts[] = $part;
            }
        }
        
        return $pathParts;
    }
    
}