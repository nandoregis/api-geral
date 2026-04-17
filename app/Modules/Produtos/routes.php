<?php

use app\Middleware\ApiKeyMiddleware;
use app\Middleware\AuthMiddleware;
use app\Middleware\RateLimitMiddleware;
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
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,5)
                ],
                "active" => true
            ],
            [   
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware, 
                    // new ApiKeyMiddleware,
                    new RateLimitMiddleware(100,5)
                ],
                "active" => true
            ],
            [   
                "route" => "/reference/{reference}",
                "controller" => new ProdutosController,
                "method" => "getByReference",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                     new RateLimitMiddleware(50,20)  
                ],
                "active" => true
            ],
            [   
                "route" => "/reference/search/{term}",
                "controller" => new ProdutosController,
                "method" => "searchByReference",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,5)
                ],
                "active" => true
            ],
            [   
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "create",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                     new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [   
                "route" => "/u/update/{uuid}",
                "controller" => new ProdutosController,
                "method" => "update",
                "http" => ["PUT"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                       new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            
        ]
    ],
    [
        'static' => 'v1/product-variations',
        'routes' => [
            [   
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getProductVariationsByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                       new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [   
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "createProductVariations",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                       new RateLimitMiddleware(50,10)
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
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getSizeByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "createSize",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                       new RateLimitMiddleware(100,10)
                ],
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
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getColorByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "createColors",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/u/update/{uuid}",
                "controller" => new ProdutosController,
                "method" => "updateColors",
                "http" => ["PUT"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                   new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/d/delete",
                "controller" => new ProdutosController,
                "method" => "deleteColors",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ]
        ]
    ],
    [
        'static' => 'v1/stock',
        'routes' => [
            [
                "route" => "/in",
                "controller" => new ProdutosController,
                "method" => "stockProductIn",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/out",
                "controller" => new ProdutosController,
                "method" => "stockProductOut",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ]
        ]
            
    ],
    [
        'static' => 'v1/sales',
        'routes' => [
            [
                "route" => "/",
                "controller" => new ProdutosController,
                "method" => "getAllSales",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(100,10)
                ],
                "active" => true
            ],
            [
                "route" => "/{uuid}",
                "controller" => new ProdutosController,
                "method" => "getSaleByUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                   new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/users/{uuid_user}",
                "controller" => new ProdutosController,
                "method" => "getSaleByUUIDUser",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/items/{sale_uuid}",
                "controller" => new ProdutosController,
                "method" => "getSaleItemsBySaleUUID",
                "http" => ["GET"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/c/create",
                "controller" => new ProdutosController,
                "method" => "newSale",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/finish/{uuid}",
                "controller" => new ProdutosController,
                "method" => "finishSale",
                "http" => ["PUT"],
                "middlewares" => [
                    // new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/itens/c/create",
                "controller" => new ProdutosController,
                "method" => "addProductInSale",
                "http" => ["POST"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
            [
                "route" => "/itens/d/delete/{variation_uuid}",
                "controller" => new ProdutosController,
                "method" => "deleteProductInSale",
                "http" => ["DELETE"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ],
                [
                "route" => "/itens/all/d/delete/sale/{sale_uuid}",
                "controller" => new ProdutosController,
                "method" => "deleteAllProductsInSale",
                "http" => ["DELETE"],
                "middlewares" => [
                    new AuthMiddleware,
                    // new ApiKeyMiddleware, 
                    new RateLimitMiddleware(50,10)
                ],
                "active" => true
            ]
        ]
    ]
];
