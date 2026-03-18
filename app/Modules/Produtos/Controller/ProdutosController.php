<?php

namespace app\Modules\Produtos\Controller;

use app\Controller\Controller;

class ProdutosController extends Controller
{

    
    private $produtosController;
    public function __construct() 
    {
        parent::__construct();
        $this->produtosController = new GetterProdutosController;
    }

    public function index()
    {   
        $response = $this->produtosController->all();
        return parent::apiView(200, $response);

    }

    public function getByUUID(object $req)
    {   
        return parent::apiView(200, $this->produtosController->getByUUID( $req->input('uuid') ));
    }

    public function getByReference(object $req)
    {   
        return parent::apiView(200, $this->produtosController->getByReference( $req->input('reference') ));
    }

    public function create(object $req) 
    {
        return parent::apiView(201, $req->input('reference'), $req->input('name') );
    }



}