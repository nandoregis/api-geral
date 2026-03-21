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

    /**
     *  Create : produtos
     */
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
        
        $sql = "UPDATE products SET reference = :reference, `name` = :name WHERE uuid = :uuid";

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

    public function delete(string $uuid) {}

    public function saleProducts() {}

    // ===============================================================================
    //    Movimentação de estoque, entrada e saida, tabela stock e stock_movements
    // ===============================================================================

    public function stockProductEntry() {}

    public function stockProductExit() {}

    // ==================================================================
    //        METODOS PARA TABELA SIZE, PRODUCT_VARIATIONS E COLORS
    // ==================================================================

    public function createSize( string $name ) : array
    {
        $uuid = UUID::v4();

        $sql = "INSERT INTO `sizes` (uuid, `name`, created_at)
            VALUES (:uuid, :name, NOW())";

        try {
            $stmt = parent::PrimayDB()->prepare($sql);

            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':name', $name);

            $stmt->execute();

            return ['uuid' => $uuid, 'name' => $name];

        } catch (\PDOException $e) 
        {
            error_log($e->getMessage());
            return [];
        }
    }
    
    public function createColors(string $name, string $color_hex) 
    {
        $uuid = UUID::v4();

        $sql = "INSERT INTO `colors` (uuid, `name`, color_hex, created_at)
            VALUES (:uuid, :name, :color_hex, NOW())";

        try {
            $stmt = parent::PrimayDB()->prepare($sql);

            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':name', $name);
            $stmt->bindValue(':color_hex', $color_hex);

            $stmt->execute();

            return ['uuid' => $uuid, 'name' => $name, 'color_hex' => $color_hex];

        } catch (\PDOException $e) 
        {
            error_log($e->getMessage());
            return [];
        }
    }

    public function createProductVariations() {}
    


}