<?php

namespace app\Modules\Produtos\Controller;

use app\Controller\Controller;

class ProdutosController extends Controller
{

    #
    private $produtosController;
    public function __construct() 
    {
        parent::__construct();
        $this->produtosController = new GetterProdutosController;
    }

    #
    public function index()
    {   
        $response = $this->produtosController->all();
        return parent::apiView(200, $response);

    }

    public function getForUuid(object $req)
    {   
        $uuid = explode('/', $req->get_uri() );
        $uuid = end($uuid);

        return parent::apiView(200, $this->produtosController->getByUUID($uuid) );
    }


}