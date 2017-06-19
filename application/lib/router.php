<?php 

/***
 * This is the router file. Here is the place where the request is analysed and
 * the right Controller is chosen to handle it and return a response. It is
 * also the place where a Exception Handler is assigned.
 * 
 * A request will be routed by default the following way, if the controllers
 * are made using the following convention:
 * 
 *   Last element in the URL, converted to camelCase = function() to call
 *   Second last, converted to UpperCamelCase = Controller class name
 *   The rest = subfolder in the application/controller folder
 *   
 *   The default folder, if can't specify one, is application/controller/
 *   The default controller, if can't specify one, is HomeController
 *   The default function, if can't specify one, is index()
 * 
 *   Case 0:
 *   example.com/index.php
 *      Controller = HomeController
 *      function = index()
 * 
 *   Case 1:
 *   example.com/index.php/abc
 *      Controller = HomeController
 *      function = abc()
 *      --- If can't find, will try this:
 *          Controller = AbcController
 *          function = index()
 *      
 *   example.com/index.php/abc/def
 *      Controller = AbcController
 *      function = def()
 *      --- If can't find, will try this:
 *          Subfolder = abc
 *          Controller = DefController
 *          function = index()
 *      
 *   example.com/index.php/abc/def/ghi
 *      Subfolder = abc
 *      Controller = DefController
 *      function = ghi()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def
 *          Controller = GhiController
 *          function = index()
 *      
 *   example.com/index.php/abc/def/ghi/jkl
 *      Subfolder = abc/def/
 *      Controller = GhiController
 *      function = jkl()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def/ghi
 *          Controller = JklController
 *          function = index()
 */

$vars = array();
parse_str($_SERVER['QUERY_STRING'], $vars);


if (isset($_SERVER["PATH_INFO"])) {
    $path = trim($_SERVER["PATH_INFO"], '/');
    $pathParts = explode('/', $path);
} else {
    $pathParts = array();
}

switch (count($pathParts)) {
    case 0:
        // calling HomeController, function index
        $controller = new HomeController();
        $controller->index($vars);
        break;
    
    case 1:
        // Using the path part as function name, in HomeController
        $controller = new HomeController();
        $part0 = $pathParts[0];
        if (method_exists($controller, $part0)) {
            $controller->$part0($vars);
        } else {
            // try $part0 as controller name and look for an index function
            $controllerName = str_replace(';','',ucwords($part0.';controller',';'));
            $controller = new $controllerName();
            $controllerName->index();
        }
        
}
