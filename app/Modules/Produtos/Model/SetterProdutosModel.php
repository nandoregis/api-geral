<?php

namespace app\Modules\Produtos\Model;

use app\Core\HttpCode;
use app\Core\UUID;
use app\Factory\Response;
use app\Model\Model;

class SetterProdutosModel extends Model
{   
    private $getterProdutosModel;
    public function __construct() 
    {
        parent::__construct();
        $this->getterProdutosModel = new GetterProdutosModel;
    }

    public function create(string $reference, string $name): array
    {         
        
        $uuid = UUID::v4();

        $sql = "INSERT INTO products (uuid, reference, `name`, created_at)
            VALUES (:uuid, :reference, :name, NOW())";

        try {
            $stmt = parent::PrimayDB()->prepare($sql);

            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':reference', $reference);
            $stmt->bindValue(':name', $name);

            $stmt->execute();

            return $this->getterProdutosModel->getByUUID($uuid);

        } catch (\PDOException $e) 
        {
            error_log($e->getMessage());
            return [];
        }
    }


    public function update(string $uuid, string $reference, string $name) : array
    {
        
        $sql = "UPDATE products SET reference = :reference, `name` = :`name` WHERE uuid = :uuid";

        try {
            $stmt = parent::PrimayDB()->prepare($sql);
            
            $stmt->bindValue(':reference', $reference);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':uuid', $uuid);

            $stmt->execute();
            
            return $this->getterProdutosModel->getByUUID($uuid);
            
        }catch (\PDOException $e) 
        {
            error_log($e->getMessage());
            return [];
        
        }


    }
    

}