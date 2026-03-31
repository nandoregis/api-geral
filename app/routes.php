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
        'timestamp' => date('c'),
        "author" => "Luís Fernando",
        "github" => 'https://github.com/nandoregis',
        "project" => 'https://github.com/nandoregis/api-geral'
    ])->send();

});

$routes->run();

any('/404', function() { 
    $view = new ApiView();
    $view->setStatus(404)
    ->setData([
        'error' => true,
        'message' => "Not found"
    ])->send();

});