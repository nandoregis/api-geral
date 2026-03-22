<?php

require '../router.php';
use app\Core\Web;

$routes = new Web;


get('/', function () {

    http_response_code(200);

    echo json_encode([
        'name' => 'Portfolio API',
        'version' => 'v1.0.0',
        'status' => 'online',
        'environment' => 'development',
        'timestamp' => date('c')
    ]);
});

$routes->run();

any('/404', 'app/Pages/404.php');