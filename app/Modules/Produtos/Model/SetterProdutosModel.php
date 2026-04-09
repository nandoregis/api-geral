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

            $this->createProductVariations( $uuid, $variations, $pdo);

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
    
    //=========================================================================
    //                          product_variations          
    //=========================================================================

    public function createProductVariations(string $product_uuid, array $variations, $pdo = null ): array
    {   
        if(!$pdo) $pdo = parent::PrimayDB();
        
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

        return $this->getterProdutosModel->getProductVariationsByUUID($product_uuid);
    }

    public function updatePriceProductVariation(string $product_uuid, array $variations)
    {
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        $sql = "UPDATE product_variations SET price = :price WHERE product_uuid = :product_uuid AND uuid = :uuid";

        try {
            $stmt = $pdo->prepare($sql);

            foreach ($variations as $key => $value) 
            {
                $uuid = $value['uuid'];
                $price = $value['price'];

                $stmt->bindValue(':price', $price);
                $stmt->bindValue(':product_uuid', $product_uuid);
                $stmt->bindValue(':uuid', $uuid);

                $stmt->execute();

            }

            return $this->getterProdutosModel->getProductVariationsByUUID($product_uuid);

        } catch (\PDOException $e) {
            error_log($e->getMessage());
            return [];
        
        }
    }
    
    // ==================================================================
    //                          SALE 
    //===================================================================

    public function newSale(string $user_uuid) : array
    {
        $uuid = UUID::v4();

        $sql = "INSERT INTO sales (uuid, user_uuid, total,`status`, payment, created_at)
            VALUES (:uuid, :user_uuid, :total, :status, :payment, NOW())";

        try {

            $stmt = parent::PrimayDB()->prepare($sql);
            
            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':user_uuid', $user_uuid);
            $stmt->bindValue(':status', 0);
            $stmt->bindValue(':payment', "pendente");
            $stmt->bindValue(':total', 0.0);

            $stmt->execute();

            return ['uuid' => $uuid, 'payment' => 'pendente', 'status' => 0, 'total' => 0];

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    
    }

    public function addProductsInSale(string $sale_uuid, string $product_uuid, array $variations) : array
    {
      
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        $sql = "INSERT INTO sale_items (uuid, sale_uuid, product_uuid, variation_uuid, quantity, price, created_at)
            VALUES (:uuid, :sale_uuid, :product_uuid, :variation_uuid, :quantity, :price, NOW())";

        try {

            $stmt = $pdo->prepare($sql);

            foreach ($variations as $key => $value) 
            {   
                $uuid = UUID::v4();
                $sale_uuid = $sale_uuid;
                $product_uuid = $product_uuid;
                $variation_uuid = $value['variation_uuid'];
                $quantity = $value['quantity'];
                $price = $value['price'];

                $stmt->bindValue(':uuid', $uuid);
                $stmt->bindValue(':sale_uuid', $sale_uuid);
                $stmt->bindValue(':product_uuid', $product_uuid);
                $stmt->bindValue(':variation_uuid', $variation_uuid);
                $stmt->bindValue(':quantity', $quantity);
                $stmt->bindValue(':price', $price);

                $stmt->execute();
            }

            $pdo->commit();

            return $variations;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            $pdo->rollBack();
            return [];
        }
    }

    public function updateProductsInSale(string $sale_uuid, array $variations)
    {
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        $sql = "UPDATE sale_items SET 
        quantity = :quantity, 
        price = :price 
        WHERE sale_uuid = :sale_uuid 
        AND variation_uuid = :variation_uuid 
        AND price = :price
        ";

        try {
            $stmt = $pdo->prepare($sql);

            foreach ($variations as $key => $value) {

                $stmt->bindValue(':quantity', $value['quantity']);
                $stmt->bindValue(':price', $value['price']);
                $stmt->bindValue(':sale_uuid', $sale_uuid);
                $stmt->bindValue(':variation_uuid', $value['variation_uuid']);
                $stmt->bindValue(':price', $value['price']);
                
                $stmt->execute();
            }

            $pdo->commit();

            return $variations;

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return []; 
        }
    }

    public function updateProductInSale(string $uuid, int $quantity, float $price) : array
    {
        $sql = "UPDATE sale_items SET quantity = :quantity, price = :price WHERE uuid = :uuid";

        try {
            $stmt = parent::PrimayDB()->prepare($sql);

            $stmt->bindValue(':quantity', $quantity);
            $stmt->bindValue(':price', $price);
            $stmt->bindValue(':uuid', $uuid);

            $stmt->execute();

            return ['uuid' => $uuid, 'quantity' => $quantity, 'price' => $price];

        } catch (\Exception $e) {
            error_log($e->getMessage());
            return []; 
        }
    }

    public function finishSale(string $uuid) : array
    {
        
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        $sql = "UPDATE sales SET total = :total, `status` = :status, payment = :payment WHERE uuid = :uuid";

        try {

            $saleVariations = $this->getterProdutosModel->getSaleItemsBySaleUUID($uuid);
            $total = 0;
            
            foreach ($saleVariations as $key => $value) 
            {
                $product_uuid = $value['product_uuid'];
                $total = $total + ($value['quantity'] * $value['price']);

                $this->stockProductExit($product_uuid, $value['variation_uuid'], $value['quantity'], $pdo);
                $this->stockMovements($product_uuid,$value['variation_uuid'],'out',$value['quantity'],'Saída manual no estoque', $pdo);
            }
       
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':uuid', $uuid);
            $stmt->bindValue(':total', $total);
            $stmt->bindValue(':status', 1);
            $stmt->bindValue(':payment', "dinheiro");
            
            $stmt->execute();

            $pdo->commit();

            return $this->getterProdutosModel->getSaleByUUID($uuid);

        } catch (\Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return []; 
        }
    }
    

    // ===============================================================================
    //    Movimentação de estoque, entrada e saida, tabela stock e stock_movements
    // ===============================================================================

    public function entryVariationsProductInStock(string $product_uuid, array $variation) 
    {
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        try {
            
            foreach ($variation as $key => $value) 
            {
                $variation_uuid = $value['uuid'];
                $quantity = $value['quantity'];

                $existProductVariation = $this->getterProdutosModel->getStockByVariationUUID($variation_uuid);

                if(!empty($existProductVariation)) {
                    $this->stockProductUpdateEntry($product_uuid, $variation_uuid, $quantity, $pdo);
                } else {
                    $this->stockProductInsertEntry($product_uuid, $variation_uuid, $quantity, $pdo);
                }

            }
            
            $pdo->commit();

            return $this->getterProdutosModel->getStockByProductUUID($product_uuid);

        } catch (\Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return []; 
        }

    }

    public function exitVariationsProductInStock(string $product_uuid, array $variation) 
    {
        $pdo = parent::PrimayDB();
        $pdo->beginTransaction();

        try {
            
            foreach ($variation as $key => $value) 
            {
                $variation_uuid = $value['uuid'];
                $quantity = $value['quantity'];

                $this->stockProductExit($product_uuid, $variation_uuid, $quantity, $pdo);
                $this->stockMovements($product_uuid,$variation_uuid,'out',$quantity,'Saída manual no estoque', $pdo);

            }
            
            $pdo->commit();

            return $this->getterProdutosModel->getStockByProductUUID($product_uuid);

        } catch (\Exception $e) {
            $pdo->rollBack();
            error_log($e->getMessage());
            return []; 
        }

    }

    private function stockProductInsertEntry(string $product_uuid, string $variation_uuid, int $quantity, $pdo = null)
    {
        if(!$pdo) $pdo = parent::PrimayDB();

        $sql = "INSERT INTO stock (uuid, product_uuid, variation_uuid, quantity, updated_at)
            VALUES (:uuid, :product_uuid, :variation_uuid, :quantity, NOW())";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':uuid', UUID::v4());
        $stmt->bindValue(':product_uuid', $product_uuid);
        $stmt->bindValue(':variation_uuid', $variation_uuid);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->execute();

        $this->stockMovements($product_uuid,$variation_uuid,'in',$quantity,'Entrada manual no estoque', $pdo);

        return ['uuid' => $variation_uuid, 'quantity' => $quantity];
    }

    private function stockProductUpdateEntry(string $product_uuid, string $variation_uuid, int $quantity, $pdo = null) : array
    {   
        if(!$pdo) $pdo = parent::PrimayDB();
        
        $sql = "UPDATE stock 
                SET quantity = COALESCE(quantity, 0) + :quantity,
                    updated_at = NOW()
                WHERE product_uuid = :product_uuid AND variation_uuid = :variation_uuid";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->bindValue(':product_uuid', $product_uuid);
        $stmt->bindValue(':variation_uuid', $variation_uuid);
        $stmt->execute();

        $this->stockMovements($product_uuid,$variation_uuid,'in',$quantity,'Entrada manual no estoque', $pdo);

        return ['uuid' => $variation_uuid, 'quantity' => $quantity];
    
    }

    private function stockProductExit(string $product_uuid, string $variation_uuid, int $quantity, $pdo = null )  : array
    {
        if(!$pdo) $pdo = parent::PrimayDB();

        $sql = "UPDATE stock SET quantity = quantity - :quantity WHERE variation_uuid = :variation_uuid AND quantity >= :quantity";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->bindValue(':variation_uuid', $variation_uuid);
        $stmt->execute();

        return ['product_uuid' => $product_uuid, 'variation_uuid' => $variation_uuid, 'quantity' => $quantity];
            
    }

    private function stockMovements(string $product_uuid, string $variation_uuid, string $type, int $quantity, string $reason, $pdo = null) : array
    {   

        $uuid = UUID::v4();
        
        $sql = "INSERT INTO stock_movements (uuid, product_uuid, variation_uuid,`type`, quantity, reason, created_at)
            VALUES (:uuid, :product_uuid, :variation_uuid, :type, :quantity, :reason, NOW())";

        if(!$pdo) $pdo = parent::PrimayDB();

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->bindValue(':product_uuid', $product_uuid);
        $stmt->bindValue(':variation_uuid', $variation_uuid);
        $stmt->bindValue(':type',$type);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->bindValue(':reason', $reason);
        $stmt->execute();

        return ['uuid' => $uuid, 'product_uuid' => $product_uuid, 'variation_uuid' => $variation_uuid, 'type' => $type, 'quantity' => $quantity, 'reason' => $reason];
    }

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