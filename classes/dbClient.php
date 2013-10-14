<?php

// the following code will make it so that the class directory is in your include_path  this allows the __autoload function to work.
 $cur = ini_get("include_path");

 $cur .= PATH_SEPARATOR.dirname(__FILE__);
  $cur .= PATH_SEPARATOR.dirname(dirname(__FILE__))."/config/";

ini_set("include_path", $cur);


// this will load any classes that are not found and are located in the  // /class/ folder.

/**
 * @param $class
 * 
 */
function __autoload($class) {
    include($class . '.php');
   

    // Check to see it the include defined the class
    if ( !class_exists($class, false) ) {
        trigger_error("Unable to load class $class", E_USER_ERROR);
    }

}
include('config.php');
