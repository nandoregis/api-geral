<?php

namespace app\Modules\Produtos\Controller;

use app\Controller\Controller;

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
        return parent::apiView(200, $this->getterProdutosController->all() );
    }

    public function getByUUID(object $req)
    {   
        return parent::apiView(200, $this->getterProdutosController->getByUUID( $req->input('uuid') ));
    }

    public function getByReference(object $req)
    {   
        return parent::apiView(200, $this->getterProdutosController->getByReference( $req->input('reference') ));
    }

    public function create(object $req) 
    {   
        $response = $this->setterProdutosController->create( $req->input('reference'), $req->input('name') );
        $code = isset($response['code']) ? $response['code'] : 201;
        return parent::apiView( $code , $response['message']);
    }


}