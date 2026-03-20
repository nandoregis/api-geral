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

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $products ?: [];
        
    }

    public function getByUUID(string $uuid) : array
    {   

        $sql = "SELECT * FROM products WHERE uuid = ?";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute([$uuid]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: [];
    }

    public function getByReference(string $reference) : array
    {   

        $sql = "SELECT * FROM products WHERE reference = ?";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute([$reference]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: [];
    }
    
    public function checkReferenceWithDifferentUUID(string $uuid, string $reference) : bool
    {   

        $sql = "SELECT uuid, reference FROM products WHERE reference = ? AND uuid != ? LIMIT 1";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute([$reference, $uuid]);

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ? true : false;

    }   
}