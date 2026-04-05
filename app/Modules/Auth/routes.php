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
                    new RateLimitMiddleware(3,9)
                ],
                "active" => true
            ],
            [   
                "route" => "/me/{token}",
                "controller" => new AuthController,
                "method" => "me",
                "http" => ["PUT"],
                "middlewares" => [
                    new RateLimitMiddleware(3,9)
                ],
                "active" => true
            ],
           
        ]
    ],
   

];
