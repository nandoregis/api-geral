<?php

namespace app\Modules\Produtos\Controller;

use app\Controller\Controller;
use app\Core\HttpCode;
use app\Core\Validation;

class ProdutosController extends Controller
{

    
    private $getterProdutosController;
    private $setterProdutosController;

    public function __construct() 
    {
        parent::__construct();
        $this->getterProdutosController = new GetterProdutosController;
        $this->setterProdutosController = new SetterProdutosController;
    }

    public function index()
    {   
        return parent::apiView(HttpCode::OK, $this->getterProdutosController->all() );
    }

    public function getByUUID(object $req)
    {   
        return parent::apiView(HttpCode::OK, $this->getterProdutosController->getByUUID( $req->input('uuid') ));
    }

    public function getByReference(object $req)
    {   
        return parent::apiView(HttpCode::OK, $this->getterProdutosController->getByReference( $req->input('reference') ));
    }

    public function create(object $req) 
    {   
        $response = $this->setterProdutosController->create($req);
        $code = Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED);
        return parent::apiView( $code , $response);
    }


}