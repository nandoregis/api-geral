<?php

namespace app\Modules\Produtos\Controller;

use app\Modules\Produtos\Model\SetterProdutosModel;
use app\Modules\Produtos\Validator\ProductValidator;

class SetterProdutosController
{
    private $setterProdutosModel;
    private $productValidator;
    public function __construct() 
    {
       $this->setterProdutosModel = new SetterProdutosModel;
       $this->productValidator = new ProductValidator;
    }

    public function create(string $reference, string $name)
    {   
        
        $this->productValidator->validateReference($reference);
        $this->productValidator->validateName($name);

        if ($this->productValidator->hasErrors()) {
            return [
                'status' => false,
                'code' => 401,
                'message' => $this->productValidator->getErrors()
            ];
        }

        return $this->setterProdutosModel->create($reference, $name);
    }

}