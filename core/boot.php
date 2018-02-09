<?php 
/*
 * *************************************************************************
 * This file is the entry point for every request and it is where all
 * starts. It lives in the public folder, with othe publicly available stuff
 * such as javascripts, css files, and media.
 */
define('IS_APP', true); // flag to any further included file that the request
                        // came through the happy path (index.php). All other
                        // PHP files must have this as first line:
                        //
                        // <?php if (!defined('IS_APP')) die ('Nope.');

/*
 * First some directories will be checked and constants will be created to give
 * global access to application paths:
 *
 * DIR_PUBLIC: The public folder, where this INDEX.PHP file lives, plus CSS, JS
 * images and other resources that must be available publicly
 *
 * DIR_APP: application folder, where the site logic lives
 * -- DIR_MODEL: Models (read and write data)
 * -- DIR_VIEW: Views (the visible stuff)
 * -- DIR_CONTROLLER: Controllers (logic to deal with requests and call views)
 * -- DIR_LIB: Library (PHP Classes. The contents of this folder is not meant
 * to change across sites)
 *
 * DIR_VAR: Variable files (result from interaction with the site, not part of
 * it's logic)
 * -- DIR_LOG: log files
 *
 * About the files in application folder:
 *
 * config.sample.php - copy this file as config.php and set the defines
 * for the current environment. Btw, you might want to add this to your DEV
 * config.php file: error_reporting(E_ALL);
 *
 * waf.php - Web Application Firewall - check if there is anything suspicious
 * with the request before processing it.
 *
 * router.php - site routes. This is where the request is analysed and a
 * Controller function is chosen to handle it
 *
 */

// Set DS as DIRECTORY_SEPARATOR for a cleaner code
define('DS', DIRECTORY_SEPARATOR);

// Resolve folders. As the code logic lives outside the public folder,
// these must be well defined and made sure are accessible.

$__file__ = __FILE__; // just for compatibility, to be able to inspect this
                      // value using XDebug PHP extension

$DIR_CORE = dirname($__file__); // folder where this boot.php file is
$DIR_ROOT = realpath($DIR_CORE . DS . '..' . DS);
$DIR_PUBLIC = realpath($DIR_ROOT . DS . 'public');
$DIR_APP = realpath($DIR_ROOT . DS . 'application');
$DIR_MODEL = realpath($DIR_APP . DS . 'model');
$DIR_VIEW = realpath($DIR_APP . DS . 'view');
$DIR_CONTROLLER = realpath($DIR_APP . DS . 'controller');
$DIR_LIB = realpath($DIR_APP . DS . 'lib');

// make sure all paths were successfully resolved
if (! $DIR_ROOT)
    throw new Exception("Can't find the ROOT folder");
if (! $DIR_CORE)
    throw new Exception("Can't find the CORE folder");
if (! $DIR_APP)
    throw new Exception("Can't find the APPLICATION folder");
if (! $DIR_MODEL)
    throw new Exception("Can't find the MODEL folder.");
if (! $DIR_VIEW)
    throw new Exception("Can't find the VIEW folder.");
if (! $DIR_CONTROLLER)
    throw new Exception("Can't find the CONTROLLER folder.");
if (! $DIR_LIB)
    throw new Exception("Can't find the LIB folder.");

// VAR folder
$DIR_VAR = $DIR_ROOT . DS . 'var';
if (! is_dir($DIR_VAR))
    mkdir($DIR_VAR, 0700);
$DIR_VAR = realpath($DIR_VAR);
if (! $DIR_VAR)
    throw new Exception('Can\'t find (neither create) the VAR folder.');

// LOG folder
$DIR_LOG = $DIR_VAR . DS . 'logs';
if (! is_dir($DIR_LOG))
    mkdir($DIR_LOG, 0700);
$DIR_LOG = realpath($DIR_LOG);
if (! $DIR_LOG)
    throw new Exception('Can\'t find (neither create) the LOG folder.');

// Make sure LOG folder is writable
if (! is_writable($DIR_LOG))
    throw new Exception('LOG folder is not writable.');

define('DIR_PUBLIC', $DIR_PUBLIC);
define('DIR_ROOT', $DIR_ROOT);
define('DIR_CORE', $DIR_CORE);
define('DIR_APP', $DIR_APP);
define('DIR_MODEL', $DIR_MODEL);
define('DIR_CONTROLLER', $DIR_CONTROLLER);
define('DIR_VIEW', $DIR_VIEW);
define('DIR_LIB', $DIR_LIB);
define('DIR_VAR', $DIR_LIB);
define('DIR_LOG', $DIR_LIB);

$scriptName = $_SERVER['SCRIPT_NAME'];
if (substr($scriptName, -1) != '/') {
    $scriptName = $scriptName . '/';
}
define('SITE', $scriptName);

define('SITE_ROOT_URL', str_replace('/index.php/', '', $scriptName));

// Calls the WAF (Web Application Firewall) which will have a look at the RAW
// request and drop in case it find anything malicious.
// This file must be carefully written and tested because any exception in it
// means red alert.
// If the file runs and no Exception is raised, the request is safe at first
// glance.
// The WAF also performs throttling, so if a specific IP is abusing the server
// it will be blocked for a while.
try {
    require_once (DIR_CORE . DS . 'waf.php');
} catch (\Exception $e) {
    $file = $e->getFile();
    $lineNumber = $e->getLine();
    $message = $e->getMessage();
    $ip = '------------';
    
    $errTxt = 'Request rejected by WAF: ' . $message . ' (line ' . $lineNumber . ') BAD_IP: ' . $ip;
    
    error_log($errTxt);
    
    header('HTTP/1.1 400 Bad dog!');
    die(); // drops the request, not safe to go ahead
}

/*
 * Starts the application
 */
try {
    require_once DIR_APP . DS . 'config.php';
    require_once DIR_CORE . DS . 'start.php';
} catch (\Exception $ex) {
    
    View::error($ex->getCode(), array(
        "message" => get_class($ex) . ": " . $ex->getMessage(),
        "source" => $ex->getFile() . " (line " . $ex->getLine() . ")"
    ));
    
    // if there is a custom error file, include it. 
    if (View::exists("error.php")) {
        echo View::render("error.php", array( "exception" => $ex ));
    } else {
        throw $ex;
    }
}
die();

/* **************************************************************************
 * This is a Pure PHP MVC study by Paulo Amaral.
 * PSR-2 Coding Style Guide: http://www.php-fig.org/psr/psr-2/
 * Source: https://github.com/paulera/pure-php-mvc
 */
