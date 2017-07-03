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

// If got this far without finding a route, it is a 404 Not Found.
http_response_code(404);
View::error404();