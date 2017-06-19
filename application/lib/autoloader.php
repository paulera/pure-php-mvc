<?php

/**
 * The autoloader function is called every time a class is instantiated
 * but have not been included in the code.
 */

spl_autoload_register(function ($class_name) {
    
    // Try to load the requested class from the library folder.
    if (file_exists(DIR_LIB.DS.$class_name . '.php')) {
        include DIR_LIB.DS.$class_name . '.php';
    }
    
    // Try to load the requested class from the controllers folder
    else if (file_exists(DIR_CONTROLLER.DS.$class_name . '.php')) {
        include DIR_CONTROLLER.DS.$class_name . '.php';
    }
    
    // Try to load the requested class from the models folder
    else if (file_exists(DIR_MODEL.DS.$class_name . '.php')) {
        include DIR_MODEL.DS.$class_name . '.php';
    }
    
});
