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
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED), 
            $response);
    }

    public function update(object $req) 
    {   

        $response = $this->setterProdutosController->update($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    

}