<?php

use app\Modules\Produtos\Controller\ProdutosController;

return [
    [
        'static' => 'v1/produtos',
        'routes' => [
            [   
                "route" => "/",
                "controller" => new ProdutosController,
                "method" => "getAll",
                "http" => ["GET"],
                "middlewares" => [],
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
            ],
            [   
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "create",
                "http" => ["POST"],
                "middlewares" => [
                    
                ],
                "active" => true
            ],
            [   
                "route" => "/u/update",
                "controller" => new ProdutosController,
                "method" => "update",
                "http" => ["POST"],
                "middlewares" => [
                    
                ],
                "active" => true
            ]
        ]
    ],
    [
        'static' => 'v1/sizes',
        'routes' => [
            [
                "route" => "/",
                "controller" => new ProdutosController,
                "method" => "getAllSizes",
                "http" => ["GET"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getSizeByUUID",
                "http" => ["GET"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "createSize",
                "http" => ["POST"],
                "middlewares" => [],
                "active" => true
            ]
        ]

    ],
    [
        'static' => 'v1/colors',
        'routes' => [
            [
                "route" => "/",
                "controller" => new ProdutosController,
                "method" => "getAllColors",
                "http" => ["GET"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getColorByUUID",
                "http" => ["GET"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "createColors",
                "http" => ["POST"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/u/update",
                "controller" => new ProdutosController,
                "method" => "updateColors",
                "http" => ["POST"],
                "middlewares" => [],
                "active" => true
            ],
            [
                "route" => "/d/delete",
                "controller" => new ProdutosController,
                "method" => "deleteColors",
                "http" => ["POST"],
                "middlewares" => [],
                "active" => true
            ]
        ]
    ]
];
