<?php

include_once('app/Config/config.vars.php');

$autoload = function ($class) {
    
    $class = $class . '.php';
    $class = __DIR__ . '/' . $class;

    $class = implode('/', explode('\\', $class));

    // echo $class;

    if( file_exists($class) ) {
        include_once($class);
    }

};

spl_autoload_register($autoload);

