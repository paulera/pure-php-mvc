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