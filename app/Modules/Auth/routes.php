<?php

use app\Middleware\CacheMiddleware;
use app\Middleware\RedirectIfAuthenticatedMiddleware;
use app\Middleware\RedirectIfLogoutMiddleware;
use app\Modules\Auth\Controller\AuthController;

return [
    [
        'static' => 'auth',
        'routes' => [
            [   
                "route" => "/",
                "controller" => new AuthController,
                "method" => "auth",
                "http" => ["POST"],
                "middlewares" => [
                    new CacheMiddleware, 
                ],
                "active" => true
            ],
            [   
                "route" => "/logout",
                "controller" => new AuthController,
                "method" => "logout",
                "http" => ["GET"],
                "middlewares" => [
                    new RedirectIfLogoutMiddleware
                ],
                "active" => true
            ]
        ]
    ],
   

];
