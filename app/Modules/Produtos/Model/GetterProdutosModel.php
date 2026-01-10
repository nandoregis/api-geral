<?php

namespace app\Modules\Produtos\Model;

use app\Model\Model;
use PDO;

class GetterProdutosModel extends Model
{


    public function __construct() 
    {
        parent::__construct();
    }


    public function getAll()
    {
        #===================================#
        #======| GET TODOS OS PRODUTOS =====#
        #===================================#
        $sql = "SELECT * FROM products";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute();

        $products = $stmt->fetch(PDO::FETCH_ASSOC);

        return $products ?: [];
        
    }
}