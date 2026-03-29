<?php

require '../router.php';
use app\Core\Web;
use app\Factory\Request;
use app\Middleware\RateLimitMiddleware;
use app\View\ApiView;

$routes = new Web;

get('/', function () {

    $rate = new RateLimitMiddleware(20,30);
    $rate->handle(new Request, function () {});

    $view = new ApiView();
    $view->setStatus(200)
    ->setData([
        'name' => 'Projetos portfolio API',
        'version' => API_VERSION,
        'status' => 'online',
        'environment' => ENVIRONMENT,
        'timestamp' => date('c')
    ])->send();

});

$routes->run();

any('/404', 'app/Pages/404.php');