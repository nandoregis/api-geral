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
                    new RateLimitMiddleware(6,60)
                ],
                "active" => true
            ],
           
        ]
    ],
   

];
