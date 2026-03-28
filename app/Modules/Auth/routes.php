<?php

use app\Middleware\CacheMiddleware;
use app\Middleware\RedirectIfAuthenticatedMiddleware;
use app\Middleware\RedirectIfLogoutMiddleware;
use app\Modules\Auth\Controller\AuthController;

return [
    [
        'static' => 'v1/auth',
        'routes' => [
            [   
                "route" => "/",
                "controller" => new AuthController,
                "method" => "auth",
                "http" => ["POST"],
                "middlewares" => [
                    
                ],
                "active" => true
            ]
        ]
    ],
   

];
