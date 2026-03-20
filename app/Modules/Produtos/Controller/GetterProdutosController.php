<?php

namespace app\Modules\Produtos\Controller;

use app\Factory\Response;
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
        return Response::success(200, "Todos os produtos", $this->getterProdutosModel->getAll());
    }

    public function getByUUID(string $uuid)
    {
        return Response::success(200, "Produto pego pelo UUID", $this->getterProdutosModel->getByUUID($uuid));
    }

    public function getByReference(string $reference)
    {
        return Response::success(200, "Produto pego pela referencia", $this->getterProdutosModel->getByReference($reference));
    }

    /**
     *  ### Verifica se referencia existe em que o uuid do produto seja diferente.
     */
    public function checkReferenceWithDifferentUUID(string $uuid, string $reference)
    {
        return $this->getterProdutosModel->checkReferenceWithDifferentUUID($uuid, $reference);
    }


    //=====================================================================================

    public function getAllSizes() : array
    {
        return Response::success(200, "Todas os tamanhos", $this->getterProdutosModel->getAllSizes());
    }

    public function getSizeByUUID(object $req) : array
    {
        return Response::success(200, "Tamanho pego pelo UUID", $this->getterProdutosModel->getSizeByUUID($req->input('uuid')));
    }

    public function checkNameSizeWithDifferentUUID(string $uuid, string $name)
    {
        return $this->getterProdutosModel->checkNameSizeWithDifferentUUID($uuid, $name);
    }


    
    
}