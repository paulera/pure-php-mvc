<?php
defined('IS_APP') || die();

include_once DIR_CORE . DS . "Utils.php";
include_once DIR_CORE . DS . "autoloader.php";

Env::config($config);

if (file_exists(DIR_APP . DS . "includes.php")) {
    include_once DIR_APP . DS . "includes.php";
}

// ----------------------------------------------------------------------
// including the routers will make the request to be processed by
// the right controller:

if (file_exists(DIR_APP . DS . "routes.php")) {
    include_once DIR_APP . DS . "routes.php";
}
require_once DIR_CORE . DS . "autorouter.php";

// ----------------------------------------------------------------------
// Route still not found. Maybe looking for a file relative to the public folder?

$pathInfo = $_SERVER['PATH_INFO'];
$pathInfo = Utils::sanitize($pathInfo, 'path');
$file = DIR_PUBLIC . DS . $pathInfo;
if (file_exists($file)) {
    
    $mimeType = Utils::mime_content_type_2($file);
    
    header("Content-Type: " . $mimeType);
    readfile($file);
    die();
}

// If got this far without finding a route, it is a 404 Not Found.
View::error(404);