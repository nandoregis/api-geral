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


}