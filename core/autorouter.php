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
 *   Case 2:
 *   example.com/index.php/abc/def
 *      Controller = AbcController
 *      function = def()
 *      --- If can't find, will try this:
 *          Subfolder = abc
 *          Controller = DefController
 *          function = index()
 *      
 *   Case 3:
 *   example.com/index.php/abc/def/ghi
 *      Subfolder = abc
 *      Controller = DefController
 *      function = ghi()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def
 *          Controller = GhiController
 *          function = index()
 *      
 *   Case 4:
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

$partsCount = count($pathParts);
foreach ([$partsCount - 2, $partsCount - 1] as $i) {
    
    // when reading URLs at root level ($partsCount == 0), ignore
    // the first cycle
    if ($i <= -2) continue;
    
    $methodName = "index";
    $controllerPrefix = "home";
    $path = "";
    
    // Resolves the controller name
    if ($i >= 0) {
        $controllerPrefix = $pathParts[$i];
    }
    $controllerClassName = str_replace(';','',ucwords($controllerPrefix.';controller',';'));
    
    // Resolves the method name
    if ( $i+1 < $partsCount) {
        $methodName = $pathParts[$i+1];
    }
    
    // Resolves the include path for the controller
    if ($i > 0) {            
        $pathArray = array_slice($pathParts, 0, $i);
        $path = implode(DS, $pathArray);
        $controllerPath = DIR_CONTROLLER.DS.$path;
    }
    
    $controllerFullPath = $controllerPath.DS.$controllerClassName.".php";
    
    if (is_dir($controllerPath)) {
        if (file_exists($controllerFullPath)) {
            include_once($controllerFullPath);
            if (class_exists($controllerClassName)) {
                $controller = new $controllerClassName();
            }
        }
    }
    
    if (isset($controller)) {
        break;
    }
}

if (isset($controller)) {
    $controller->$methodName();
}



            
       