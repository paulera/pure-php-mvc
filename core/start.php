<?php

if (file_exists(DIR_APP . DS . "includes.php")) {
    include_once DIR_APP . DS . "includes.php";
}

include_once DIR_CORE . DS . "autoloader.php";

// ----------------------------------------------------------------------
// including the routers will make the request to be processed by
// the right controller:

if (file_exists(DIR_APP . DS . "routes.php")) {
    include_once DIR_APP . DS . "routes.php";
}
require_once DIR_CORE . DS . "autorouter.php";

// ----------------------------------------------------------------------
// Route still not found. Maybe looking for a files relative to the root?

// TODO: implement the logic to go get files (this will work for assets and etc but must avoid directory traversal
$pathInfo = $_SERVER['PATH_INFO'];
$pathInfo = str_replace("..", "", $pathInfo);
$file = DIR_PUBLIC . $pathInfo;
if (file_exists($file)) {
    $mimeType = mime_content_type($file);
    header("Content-Type: ".$mimeType);
    readfile($file);
    die();
}

// If got this far without finding a route, it is a 404 Not Found.
View::error(404);