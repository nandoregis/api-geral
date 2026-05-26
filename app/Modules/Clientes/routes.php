<?php

use app\Middleware\RateLimitMiddleware;
use app\Modules\Clientes\Controller\ClientesController;

return [
    [
        'static' => 'v1/clients',
        'routes' => [
            [   
                "route" => "/",
                "controller" => new ClientesController(),
                "method" => "getAll",
                "http" => ["GET"],
                "middlewares" => [
                    new RateLimitMiddleware(20,9)
                ],
                "active" => true
            ],
            [   
                "route" => "/{uuid}",
                "controller" => new ClientesController(),
                "method" => "getByUuid",
                "http" => ["GET"],
                "middlewares" => [
                    new RateLimitMiddleware(20,9)
                ],
                "active" => true
            ],
        ]
    ],

];
