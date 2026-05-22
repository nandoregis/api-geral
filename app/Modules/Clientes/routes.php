<?php

use app\Middleware\RateLimitMiddleware;

return [
    [
        'static' => 'v1/clientes',
        'routes' => [
            [   
                "route" => "/",
                "controller" => null,
                "method" => "",
                "http" => ["GET"],
                "middlewares" => [
                    new RateLimitMiddleware(20,9)
                ],
                "active" => true
            ],
        ]
    ],

];
