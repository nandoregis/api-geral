<?php

namespace app\Modules\Clientes\Model;

use app\Model\Model;
use PDO;

class GetterClientesModel extends Model
{
    public function getall()
    {
        $sql = "SELECT * FROM clientes ORDER BY  `name` ASC";
        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUuid()
    {

    }

    public function getByEmail()
    {

    }
    
}