<?php

/**
 * Set an array of PHP files and folder to NOT be automatically included.
 * Edit the file for examples.
 */
$dontInclude[] = array();
include "file_exclusions.php";

/**
 * Recursively include all libraries
 * adapted from https://gist.githubusercontent.com/pwenzel/3438784/raw/a2f1a97a664cdab1310f08df517a24a927bf3e70/require_all_helper.php
 */
$functionRequireAll = function ($f, $dir, $depth = 0) {
    
    // don't let dig deeper than this limit:
    if ($depth > 10) {
        return;
    }
    
    // require all PHP files
    $scan = glob("$dir/*");
    foreach ($scan as $path) {
        
        if (preg_match('/\.php$/', $path)) {
            foreach ($dontInclude as $di) {
                if (fnmatch($di, $path)) {
                    // This path is meant to be skipped
                    // TODO: test the file exclusion.
                    continue;
                }
            }
            require_once $path;
        } else if (is_dir($path)) {
            foreach ($dontInclude as $di) {
                if (fnmatch($di, $path)) {
                    // This path is meant to be skipped
                    // TODO: test the directory exclusion.
                    continue;
                }
            }
            $f($f, $path, $depth + 1);
        }
    }
};

foreach ([
    // DIR_MODEL,          // uncomment to include all - performance impact
    // DIR_VIEW,           // uncomment to include all - performance impact
    // DIR_CONTROLLER,     // uncomment to include all - performance impact
    DIR_LIB
] as $dir) {
    $functionRequireAll($functionRequireAll, $dir);
}

unset($functionRequireAll);

require_once DIR_APP . DS . "router.php";