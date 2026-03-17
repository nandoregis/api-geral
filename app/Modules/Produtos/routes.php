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
                "method" => "getByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    
                ],
                "active" => true
            ],
            [   
                "route" => "/reference/{reference}",
                "controller" => new ProdutosController,
                "method" => "getByReference",
                "http" => ["GET"],
                "middlewares" => [
                    
                ],
                "active" => true
            ]
        ]
    ]
];
