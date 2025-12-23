<?php

use app\Modules\Produtos\Controller\ProdutosController;

return [
    [
        'static' => 'v1/produtos',
        'routes' => [
            [   
                "route" => "/",
                "controller" => new ProdutosController,
                "method" => "index",
                "http" => ["GET"],
                "middlewares" => [
                    
                ],
                "active" => true
            ],
            [   
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getForUuid",
                "http" => ["GET"],
                "middlewares" => [
                    
                ],
                "active" => true
            ]
        ]
    ]
];
