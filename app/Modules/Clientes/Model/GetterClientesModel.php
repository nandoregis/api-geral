<?php

namespace app\Modules\Clientes\Model;

use app\Model\Model;
use PDO;

class GetterClientesModel extends Model
{
    public function getall()
    {
        return $this->fetchAll("SELECT * FROM clientes ORDER BY  `name` ASC");
    }

    public function getByUuid(string $uuid)
    {
        return $this->fetchOne("SELECT * FROM clientes WHERE uuid = :uuid", ['uuid' => $uuid]);
    }

    public function getByEmail(string $email)
    {
        return $this->fetchOne("SELECT * FROM clientes WHERE email = :email", ['email' => $email]);
    }

    
    
}