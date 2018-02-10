<?php
defined('IS_APP') || die();

/**
 * The autoloader function is called every time a class is instantiated
 * but have not been included in the code. Controllers are included by
 * application/routes.php or core/autorouter.php
 */
spl_autoload_register(function ($class_name) {
    
    // Try to load the requested class from the library folder.
    $try = DIR_LIB . DS . $class_name . '.php';
    foreach ([
        DIR_LIB . DS . $class_name . '.php',
        DIR_CORE . DS . 'classes' . DS . $class_name . '.php',
        DIR_MODEL . DS . $class_name . '.php'
    ] as $try) {
        if (file_exists($try)) {
            include $try;
            break;
        }
    }
});
