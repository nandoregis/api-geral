<?php

require '../router.php';
use app\Core\Web;

$routes = new Web;


get('/', function () use($routes) {
    
   


});

$routes->run();

any('/404', 'app/Pages/404.php');