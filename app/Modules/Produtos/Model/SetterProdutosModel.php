<?php

namespace app\Modules\Produtos\Model;

use app\Core\HttpCode;
use app\Core\UUID;
use app\Factory\Response;
use app\Model\Model;
use app\Service\BarcodeGenerator;

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
    public function create(string $reference, string $name, array $variations): array
    {         
        
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        $uuid = UUID::v4();

        $sql = "INSERT INTO products (uuid, reference, `name`, created_at)
            VALUES (:uuid, :reference, :name, NOW())";

        try {

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':reference', $reference);
            $stmt->bindValue(':name', $name);

            $stmt->execute();

            $this->createProductVariations($pdo, $uuid, $variations);

            $pdo->commit();

            return $this->getterProdutosModel->getByUUID($uuid);

        } catch (\PDOException $e) 
        {
            error_log($e->getMessage());
            $pdo->rollBack();
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

    // metodo auxiliar de criação do produto.
    private function createProductVariations($pdo, string $product_uuid, array $variations): bool
    {
            $sql = "INSERT INTO product_variations
                    (uuid, product_uuid, size_uuid, color_uuid, barcode, price, created_at)
                    VALUES (:uuid, :product_uuid, :size_uuid, :color_uuid, :barcode, :price, NOW())";

            $stmt = $pdo->prepare($sql);

            foreach ($variations as $variation) {

                $uuid = UUID::v4();
                $barcode = BarcodeGenerator::generateEAN13WithPrefix();

                $stmt->execute([
                    ':uuid' => $uuid,
                    ':product_uuid' => $product_uuid,
                    ':size_uuid' => $variation['size_uuid'],
                    ':color_uuid' => $variation['color_uuid'],
                    ':barcode' => $barcode,
                    ':price' => $variation['price'] ?? 0
                ]);
            }

        return true;
    }

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


}