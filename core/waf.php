<?php
defined('IS_APP') || die();

/*
 * *************************************************************************
 *
 * WAF - Web Application Firewall
 *
 * This file MUST NOT have any dependency. It MUST work on it's own, being
 * able to identify any suspicious element in the request and throw an
 * Exception in case there is any problem. This Exception SHOULD be handled by
 * an external try..catch like so:
 *
 * try {
 *
 * require_once ('waf.php');
 *
 * } catch (\Exception $e) {
 *
 * // ... code to log the issue
 * header("HTTP/1.1 400 Bad dog!");
 * die();
 *
 * }
 *
 */

// Check if $_GET and $_POST are all right
checkArray($_GET, "\$_GET");
checkArray($_POST, "\$_POST");

/**
 * *
 * Check an array and it's elements for overlenght/malicious requests
 *
 * @param Array $array
 *            $_GET or $_POST
 * @param String $name
 *            "$_GET" or "$_POST", used to print error messages for
 *            debug purposes
 * @throws Exception Array item rejected
 */
function checkArray($array, $name)
{
    // We don't want to do a foreach before making sure the array isn't too
    // large
    if (count($array) > 50) {
        throw new Exception($name . " is too large.");
    }
    
    foreach ($array as $key => $value) {
        if (strlen($key) > 50) {
            throw new Exception("Passing a bad key in " . $name . ".");
        }
        if (is_array($value)) {
            if (count($value) > 50) {
                throw new Exception($name . "[" . $key . "] is too large.");
            }
        } else {
            if (strlen($value) > 100) {
                throw new Exception("Bad value passed in " . $name . ".");
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "CONNECT") {
    throw new Exception("Trying to CONNECT.");
}

// waf test -- you can force to fail passing ?fail=1
if (isset($_GET['fail']) && $_GET['fail'] == 1) {
    throw new Exception("Failing by purpose.");
}