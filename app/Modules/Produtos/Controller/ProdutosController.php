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

    public function getAll()
    {   
        $response = $this->getterProdutosController->all();
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getByUUID(object $req)
    {   
        $response = $this->getterProdutosController->getByUUID( $req->input('uuid') );
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getByReference(object $req)
    {   
        $response = $this->getterProdutosController->getByReference( $req->input('reference') );
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function create(object $req) 
    {   
        $response = $this->setterProdutosController->create($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED), 
            $response
        );
    }

    public function update(object $req) 
    {   

        $response = $this->setterProdutosController->update($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function delete(object $req) {}

    //==========================================================================

    public function saleProducts() {}

    public function stockProductEntry() {}

    public function stockProductExit() {}

    //==========================================================================

    public function getAllSizes()
    {
        $response = $this->getterProdutosController->getAllSizes();
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getSizeByUUID(object $req) 
    {
        $response = $this->getterProdutosController->getSizeByUUID($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

}