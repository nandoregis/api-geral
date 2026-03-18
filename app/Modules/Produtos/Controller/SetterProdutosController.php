<?php

namespace app\Modules\Produtos\Controller;

use app\Modules\Produtos\Model\SetterProdutosModel;

class SetterProdutosController
{
    private $setterProdutosModel;
    public function __construct() 
    {
       $this->setterProdutosModel = new SetterProdutosModel;
    }

    public function create(string $reference, string $name)
    {   
        if(empty($reference) || empty($name)) 
        {
            return [
                'error' => true,
                'message' => 'Dados inválidos'
            ];
        }
        
        return $this->setterProdutosModel->create($reference, $name);
    }

}