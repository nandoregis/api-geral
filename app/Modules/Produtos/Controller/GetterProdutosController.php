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

    //=======================================================
    //                                                      |
    //                    Tabelas : colors                  |
    //                                                      |
    //=======================================================

    public function getAllColors() 
    {
        return Response::success(200, "Todos as cores", $this->getterProdutosModel->getAllColors());
    }

    public function getColorByUUID(object $req) 
    {
        return Response::success(200, "Cor pego pelo UUID", $this->getterProdutosModel->getColorByUUID($req->input('uuid')));
    }

    public function checkNameColorWithDifferentUUID (string $uuid, string $name) 
    {
        return $this->getterProdutosModel->checkNameColorWithDifferentUUID($uuid, $name);
    }

    //=======================================================
    //                                                      |
    //                    Tabelas : sales                   |
    //                                                      |
    //=======================================================

    public function getAllSales() : array
    {
        return Response::success(200, "Todas as vendas", $this->getterProdutosModel->getAllSales());
    }

    public function getSaleByUUID(object $req) : array
    {
        return Response::success(200, "Venda pego pelo UUID", $this->getterProdutosModel->getSaleByUUID($req->input('uuid') ));
    }

    public function getSalesByUUIDUser(object $req) : array
    {
        return Response::success(200, "Venda pego pelo UUID do usuario", $this->getterProdutosModel->getSalesByUUIDUser($req->input('uuid_user') ));
    }

    public function getSaleItemsBySaleUUID(object $req)  : array
    {
        return Response::success(200, "Itens da venda pego pelo UUID da venda", $this->getterProdutosModel->getSaleItemsBySaleUUID($req->input('sale_uuid') )); 
    }
    
}