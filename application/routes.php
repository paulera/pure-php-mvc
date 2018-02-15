<?php
defined('IS_APP') || die();

/**
 * This is the user custom routes file.
 * 
 * Here you can parse routes using Request::path() or Request::pathParts() and
 * perform some action (e.g. View::render(), include, call a controller
 * function, etc). MAKE SURE to call die().
 *
 * If the execution doesn't die in this file, the request will be handled by
 * the autorouter (refer to run.php to see how these files are called).
 *  
 */

// For route '/blog'
if (strtolower(substr(Request::path(), 0, 5 )) === "/blog") {
    $blogController = new BlogController();
    if ($blogController->handle()) {
        die();
    }
}

$pageController = new PageController();
if ($pageController->handle()) {
    die();
}
