<?php

namespace app\Modules\Produtos\Controller;

use app\Modules\Produtos\Model\GetterProdutosModel;

class GetterProdutosController
{
    private $getterProdutosModel;
    public function __construct() 
    {
       $this->getterProdutosModel = new GetterProdutosModel;
    }

    public function all()
    {
        return $this->getterProdutosModel->getAll();
    }

    public function getByUUID(String $uuid)
    {
        return $this->getterProdutosModel->getByUUID($uuid);
    }

}