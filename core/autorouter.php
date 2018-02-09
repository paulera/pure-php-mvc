<?php 

/***
 * This is the autorouter file. Here is the place where the requests not handled
 * by routes.php are analysed and the right Controller is chosen to handle it
 * and return a response. It is also the place where a Exception Handler is
 * assigned.
 * 
 * A request will be routed by default the following way, if the controllers
 * are made using the convention:
 * 
 *   Methods corresponding to controller actions must end with "Action" -
 *   camelCase
 * 
 *   Last element in the URL, converted to camelCase = function() to call
 *   Second last, converted to UpperCamelCase = Controller class name
 *   The rest = subfolder in the application/controller folder
 *   
 *   The default folder, if can't specify one, is application/controller/
 *   The default controller, if can't specify one, is HomeController
 *   The default function, if can't specify one, is indexAction()
 * 
 *   Case 0:
 *   example.com/index.php
 *      Controller = HomeController
 *      function = indexAction()
 * 
 *   Case 1:
 *   example.com/index.php/abc
 *      Controller = HomeController
 *      function = abcAction()
 *      --- If can't find, will try this:
 *          Controller = AbcController
 *          function = indexAction()
 *   
 *   Case 2:
 *   example.com/index.php/abc/def
 *      Controller = AbcController
 *      function = defAction()
 *      --- If can't find, will try this:
 *          Subfolder = abc
 *          Controller = DefController
 *          function = indexAction()
 *      
 *   Case 3:
 *   example.com/index.php/abc/def/ghi
 *      Subfolder = abc
 *      Controller = DefController
 *      function = ghiAction()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def
 *          Controller = GhiController
 *          function = indexAction()
 *      
 *   Case 4:
 *   example.com/index.php/abc/def/ghi/jkl
 *      Subfolder = abc/def/
 *      Controller = GhiController
 *      function = jklAction()
 *      --- If can't find, will try this:
 *          Subfolder = abc/def/ghi
 *          Controller = JklController
 *          function = indexAction()
 *   
 */

$parts = Input::explodePath();

$partsCount = count($parts);
foreach ([$partsCount - 2, $partsCount - 1] as $i) {
    
    // when reading URLs at root level ($partsCount == 0), ignore
    // the first cycle
    if ($i <= -2) continue;
    
    $methodName = "indexAction";
    $controllerPrefix = "home";
    $path = "";
    
    // Resolves the controller name
    if ($i >= 0) {
        $controllerPrefix = $parts[$i];
    }
    $controllerClassName = str_replace(';','',ucwords($controllerPrefix.';controller',';'));
    
    // Resolves the method name
    if ( $i+1 < $partsCount) {
        $methodName = $parts[$i+1].'Action';
    }
    
    // Resolves the include path for the controller
    $pathArray = array_slice($parts, 0, min([$i, 0]));
    $path = implode(DS, $pathArray);
    $controllerDir = DIR_CONTROLLER.(!empty($path)?DS.$path:'');
    
    $controllerFullPath = $controllerDir.DS.$controllerClassName.".php";
    
    if (is_dir($controllerDir)) {
        if (file_exists($controllerFullPath)) {
            include_once($controllerFullPath);
            if (class_exists($controllerClassName)) {
                $controller = new $controllerClassName();
                if (!method_exists($controller, $methodName)) {
                    $controller = null;
                }
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
