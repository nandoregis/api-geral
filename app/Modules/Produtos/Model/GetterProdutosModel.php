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
        $sql = "SELECT * FROM products LIMIT ? OFFSET ?";
        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute([$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getByUUID(string $uuid) : array
    {   
        $sql = "SELECT * FROM products WHERE uuid = ?";
        return $this->fetchOne($sql, [$uuid]);
    }

    public function getByReference(string $reference) : array
    {   
        $sql = "SELECT * FROM products WHERE reference = ?";
        return $this->fetchOne($sql, [$reference]);
    }
    
    #
    public function checkReferenceWithDifferentUUID(string $uuid, string $reference) : bool
    {   
        $sql = "SELECT uuid, reference FROM products WHERE reference = ? AND uuid != ? LIMIT 1";
        $data = $this->fetchOne($sql, [$reference, $uuid]);
        return $data ? true : false;
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
        $sql = "SELECT * FROM sale_items WHERE sale_uuid = ?";
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