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

    public function getByUUID(string $uuid)
    {
        return $this->getterProdutosModel->getByUUID($uuid);
    }

    public function getByReference(string $reference)
    {
        return $this->getterProdutosModel->getByReference($reference);
    }

    //check Reference with Different UUID
    public function checkReferenceWithDifferentUUID(string $uuid, string $reference)
    {
        return $this->getterProdutosModel->checkReferenceWithDifferentUUID($uuid, $reference);
    }
    

}