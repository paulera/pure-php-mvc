<?php

/**
 * This is the user custom routes file.
 * Router::getPathParts() will give access to the path structure, to be
 * analysed.
 * If you decide to use any particular controller for a particular route, 
 * make sure to finish with a die() statement to avoid the request from
 * being processed by autorouter.php too (refer to start.php to understand
 * how these files are called).
 */

$parts = Input::explodePath();

// If the route is /blog/...., take over the autorouter
if ($parts[0] == "blog") {
    // this request has to be handled by the BlogController, lets it's
    // "route" function to do the work
    $blogController = new BlogController();
    $blogController->route();
    die();
}