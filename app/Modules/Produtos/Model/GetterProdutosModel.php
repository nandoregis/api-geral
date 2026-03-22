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

    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $sql = "SELECT uuid, reference, `name` FROM products LIMIT ? OFFSET ?";
        $stmt = parent::PrimayDB()->prepare($sql);

        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);

        $stmt->execute();

        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($products) {
            foreach ($products as &$product) {
                $product['variations'] = $this->getProductVariationsByUUID($product['uuid']);
            }
        }

        return $products?: [];
    }

    public function getByUUID(string $uuid) : array
    {   
        $sql = "SELECT uuid, reference, `name` FROM products WHERE uuid = ?";
        $product = $this->fetchOne($sql, [$uuid]);

        if($product) $product['variations'] = $this->getProductVariationsByUUID($product['uuid']);

        return $product ?: [];
    }

    public function getByReference(string $reference) : array
    {   
        $sql = "SELECT uuid, reference, `name` FROM products WHERE reference = ?";
        $product = $this->fetchOne($sql, [$reference]);
        
        if($product) $product['variations'] = $this->getProductVariationsByUUID($product['uuid']);

        return $product ?: [];
    }
    
    #
    public function checkReferenceWithDifferentUUID(string $uuid, string $reference) : bool
    {   
        $sql = "SELECT uuid, reference FROM products WHERE reference = ? AND uuid != ? LIMIT 1";
        $data = $this->fetchOne($sql, [$reference, $uuid]);
        return $data ? true : false;
    } 


    public function getProductVariationsByUUID(string $uuid) : array
    {
        $sql = "SELECT 
            pv.uuid,
            s.uuid AS size_uuid,
            c.uuid AS color_uuid,
            pv.barcode,
            pv.price,
            s.name AS size_name,
            c.name AS color_name,
            c.color_hex

        FROM product_variations pv

        LEFT JOIN sizes s 
            ON s.uuid = pv.size_uuid

        LEFT JOIN colors c 
            ON c.uuid = pv.color_uuid

        WHERE pv.product_uuid = ?";

        return $this->fetchAll($sql, [$uuid]);
    }

    public function getProductVariationByUUIDSizeandUUDColor(string $product_uuid, string $size_uuid, string $color_uuid) : array
    {
        $sql = "SELECT * FROM product_variations WHERE product_uuid = ? AND size_uuid = ? AND color_uuid = ?";
        return $this->fetchOne($sql, [$product_uuid, $size_uuid, $color_uuid]);
    }
    
    //=======================================================
    //                                                      |
    //                     Tabelas : sizes                  |
    //                                                      |
    //=======================================================

    public function getAllSizes() : array
    {
        $sql = "SELECT * FROM sizes";
        return $this->fetchAll($sql);
    }

    public function getSizeByUUID(string $uuid) : array
    {
        $sql = "SELECT * FROM sizes WHERE uuid = ?";
        return $this->fetchOne($sql, [$uuid]);
    }

    public function getSizeByName(string $name) : array
    {
        $sql = "SELECT * FROM sizes WHERE `name` = ?";
        return $this->fetchOne($sql, [$name]);
    }
    
    #
    public function checkNameSizeWithDifferentUUID(string $uuid, string $name) : bool
    {
        $sql = "SELECT uuid, `name` FROM sizes WHERE `name` = ? AND uuid != ? LIMIT 1";
        $data = $this->fetchOne($sql, [$name, $uuid]);
        return $data ? true : false;
    }

    //=======================================================
    //                                                      |
    //                    Tabelas : colors                  |
    //                                                      |
    //=======================================================

    public function getAllColors() : array
    {
        $sql = "SELECT * FROM colors";
        return $this->fetchAll($sql);
    }

    public function getColorByUUID(string $uuid) : array
    {
        $sql = "SELECT * FROM colors WHERE uuid = ?";
        return $this->fetchOne($sql, [$uuid]);
    }

    public function getColorByName(string $name) : array
    {
        $sql = "SELECT * FROM colors WHERE `name` = ?";
        return $this->fetchOne($sql, [$name]);
    }

    public function checkNameColorWithDifferentUUID(string $uuid, string $name) : bool
    {
        $sql = "SELECT uuid, `name` FROM colors WHERE `name` = ? AND uuid != ? LIMIT 1";
        $data = $this->fetchOne($sql, [$name, $uuid]);
        return $data ? true : false;
    }

    //=======================================================
    //                                                      |
    //                  METODOS SALE                        |
    //                                                      |
    //=======================================================

    public function getAllSales() : array
    {
        $sql = "SELECT * FROM sales";
        return $this->fetchAll($sql);
    }

    public function getSaleByUUID(string $uuid) : array
    {
        $sql = "SELECT * FROM sales WHERE uuid = ?";
        return $this->fetchOne($sql, [$uuid]);
    }

    public function getSalesByUUIDUser(string $uuid_user) : array
    {   
        $sql = "SELECT * FROM sales WHERE uuid_user = ?";
        return $this->fetchOne($sql, [$uuid_user]);
    }

    public function getSaleItemsBySaleUUID(string $sale_uuid) : array
    {
        $sql = "SELECT 
            si.uuid,
            si.sale_uuid,
            p.uuid AS product_uuid,
            pv.uuid AS variation_uuid,
            s.uuid AS size_uuid,
            c.uuid AS color_uuid,
            
            p.name AS product_name,
            s.name AS size_name,
            c.name AS color_name,
            c.color_hex,
            si.quantity,
            si.price

            FROM sale_items si

            INNER JOIN products p 
                ON p.uuid = si.product_uuid

            INNER JOIN product_variations pv 
                ON pv.uuid = si.variation_uuid

            INNER JOIN sizes s 
                ON s.uuid = pv.size_uuid

            INNER JOIN colors c 
                ON c.uuid = pv.color_uuid

            WHERE si.sale_uuid = ?
        ";

        return $this->fetchAll($sql, [$sale_uuid]);
    }

    public function getSaleItemsBySaleUUIDVariationUUID(string $sale_uuid, string $variation_uuid, float $price) : array
    {
        $sql = "SELECT * FROM sale_items WHERE sale_uuid = ? AND variation_uuid = ? AND price = ? LIMIT 1";
        return $this->fetchOne($sql, [$sale_uuid, $variation_uuid, $price]);
    }
      
    //=======================================================
    //                                                      |
    //                  METODOS AUXILIARES                  |
    //                                                      |
    //=======================================================

    private function fetchOne(string $sql, array $params): array
    {
        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    private function fetchAll(string $sql, array $params = []): array
    {
        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


}