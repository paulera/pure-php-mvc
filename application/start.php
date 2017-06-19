<?php

// include_once DIR_LIB.DS.'core_includes.php';

include_once DIR_LIB . DS . "autoloader.php";

// including the router will make the request to be processed by
// the right controller:
require_once DIR_LIB . DS . "router.php";

//bullshit ?
// /**
//  * Set an array of PHP files and folder to NOT be automatically included.
//  * Edit the file for examples.
//  */
// $dontInclude[] = array();
// include "file_exclusions.php";

// /**
//  * Recursively include all libraries. This function is declared as a variable
//  * to prevent access from other files, as this is a core functionality.
//  * adapted from https://gist.githubusercontent.com/pwenzel/3438784/raw/a2f1a97a664cdab1310f08df517a24a927bf3e70/require_all_helper.php
//  */
// $functionRequireAll = function ($f, $dir, $depth = 0) {
    
//     // don't let dig deeper than this limit:
//     if ($depth > 10) {
//         return;
//     }
    
//     // require all PHP files
//     $scan = glob("$dir/*");
//     foreach ($scan as $path) {
        
//         if (preg_match('/\.php$/', $path)) {
//             foreach ($dontInclude as $di) {
//                 if (fnmatch($di, $path)) {
//                     // This path is meant to be skipped
//                     // TODO: test the file exclusion.
//                     continue;
//                 }
//             }
//             require_once $path;
//         } else if (is_dir($path)) {
//             foreach ($dontInclude as $di) {
//                 if (fnmatch($di, $path)) {
//                     // This path is meant to be skipped
//                     // TODO: test the directory exclusion.
//                     continue;
//                 }
//             }
//             // TODO: improve closure call (ref https://stackoverflow.com/questions/7877970/is-it-possible-to-reference-an-anonymous-function-from-within-itself-in-php)
//             $f($f, $path, $depth + 1);
//         }
//     }
// };

// $functionRequireAll($functionRequireAll, DIR_LIB);
// unset($functionRequireAll);