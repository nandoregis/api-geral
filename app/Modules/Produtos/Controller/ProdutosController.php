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

    //=========================================================================
    //
    //                                 PRODUCTS          
    //
    //=========================================================================

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
        $response = $this->getterProdutosController->getByUUID( $req->uri('uuid') );
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getByReference(object $req)
    {   
        $response = $this->getterProdutosController->getByReference( $req->uri('reference') );
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

    //=========================================================================
    //
    //                          product_variations          
    //
    //=========================================================================
    
    public function createProductVariations(object $req) {
        $response = $this->setterProdutosController->createProductVariations($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    //=========================================================================
    //
    //                                 SALES          
    //
    //=========================================================================

    public function getAllSales() 
    {
        $response = $this->getterProdutosController->getAllSales();
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getSaleByUUID(object $req) 
    {
        $response = $this->getterProdutosController->getSaleByUUID($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getSalesByUUIDUser(object $req) 
    {
        $response = $this->getterProdutosController->getSalesByUUIDUser($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getSaleItemsBySaleUUID(object $req) 
    {
        $response = $this->getterProdutosController->getSaleItemsBySaleUUID($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    // metodo POST
    public function newSale(object $req) 
    {
        $response = $this->setterProdutosController->newSale($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    public function addProductInSale(object $req)
    {
        $response = $this->setterProdutosController->addProductInSale($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    public function finishSale(object $req) 
    {
        $response = $this->setterProdutosController->finishSale($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }
    
    //=========================================================================
    //
    //                                 STOCK          
    //
    //=========================================================================


    public function stockProductIn(object $req) 
    {
       $response = $this->setterProdutosController->stockProductIn($req);
        return parent::apiView(     
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    public function stockProductOut(object $req) 
    {
        $response = $this->setterProdutosController->stockProductOut($req);
        return parent::apiView( 
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    //=========================================================================
    //
    //                                 SIZES          
    //
    //=========================================================================
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

    public function createSize(object $req) 
    {
        $response = $this->setterProdutosController->createSize($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        ); 
    }

    public function updateSize(object $req) {}

    public function deleteSize(object $req) {}

    //=================================================================================================
    //
    //                                          COLORS          
    //
    //=================================================================================================

    public function getAllColors() {
        $response = $this->getterProdutosController->getAllColors();
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function getColorByUUID(object $req) {
        $response = $this->getterProdutosController->getColorByUUID($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::OK),
            $response
        );
    }

    public function createColors(object $req) {
        $response = $this->setterProdutosController->createColors($req);
        return parent::apiView(
            Validation::hasCode( Validation::arrayHasKey($response, 'code'), HttpCode::CREATED),
            $response
        );
    }

    public function updateColors(object $req) {}

    public function deleteColors(object $req) {}



}