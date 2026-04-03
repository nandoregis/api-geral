<?php

use app\Middleware\RateLimitMiddleware;
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
                    new RateLimitMiddleware(5,10)
                ],
                "active" => true
            ],
            [   
                "route" => "/me/{token}",
                "controller" => new AuthController,
                "method" => "me",
                "http" => ["PUT"],
                "middlewares" => [
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
           
        ]
    ],
   

];
