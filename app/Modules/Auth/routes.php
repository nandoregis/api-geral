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
                    new RateLimitMiddleware(3, 10)
                ],
                "active" => true
            ],
            [   
                "route" => "/me",
                "controller" => new AuthController,
                "method" => "token",
                "http" => ["GET"],
                "middlewares" => [
                    new RateLimitMiddleware(3, 10)
                ],
                "active" => true
            ],
        ]
    ],
   

];
