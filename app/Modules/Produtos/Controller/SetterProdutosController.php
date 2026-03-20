<?php

namespace app\Modules\Produtos\Controller;

use app\Core\HttpCode;
use app\Modules\Produtos\Model\GetterProdutosModel;
use app\Modules\Produtos\Model\SetterProdutosModel;
use app\Modules\Produtos\Validator\ProductValidator;

class SetterProdutosController
{
    private $productValidator;
    private $setterProdutosModel;
    private $getterProdutosModel;
    public function __construct() 
    {
       $this->setterProdutosModel = new SetterProdutosModel;
       $this->getterProdutosModel = new GetterProdutosModel;
       $this->productValidator = new ProductValidator;
    }

    public function create(object $req)
    {   
        
        $reference = $req->input('reference');
        $name = $req->input('name');
        
        $this->productValidator->validateReference($reference);
        $this->productValidator->validateName($name);

        if ($this->productValidator->hasErrors()) 
        {
            return [
                'status' => false,
                'code' => HttpCode::UNAUTHORIZED,
                'message' => $this->productValidator->getErrors()
            ];
        }

        if( $this->getterProdutosModel->getByReference($reference) ) 
        {
            return [
                'status' => false,
                'code' => HttpCode::CONFLICT,
                'message' => "Já existe um produto com essa referência"
            ];
        }


        return $this->setterProdutosModel->create($reference, $name);
    }

    public function update(object $req)
    { 
        // reference, name, : uuid
        $uuid = $req->input('uuid');
        $reference = $req->input('reference');
        $name = $req->input('name');
        
        $this->productValidator->validateReference($reference);
        $this->productValidator->validateName($name);

        if ($this->productValidator->hasErrors()) 
        {
            return [
                'status' => false,
                'code' => HttpCode::UNAUTHORIZED,
                'message' => $this->productValidator->getErrors()
            ];
        }

        if( $this->getterProdutosModel->getByReference($reference) ) 
        {
            return [
                'status' => false,
                'code' => HttpCode::CONFLICT,
                'message' => "Já existe um produto com essa referência"
            ];
        }
        

        return []; // retornar produto atualizado

    }


}