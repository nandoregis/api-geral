<?php

namespace app\Modules\Clientes\Model;

use app\Model\Model;
use PDO;

class GetterClientesModel extends Model
{
    public function getAll()
    {
        return $this->fetchAll("SELECT uuid, `name`, last_name, cpf, cep, contact, email FROM clients ORDER BY  `name` ASC");
    }

    public function getByUuid(string $uuid)
    {
        return $this->fetchOne("SELECT uuid, `name`, last_name, cpf, cep, contact, email FROM clients WHERE uuid = :uuid", ['uuid' => $uuid]);
    }

    public function getByEmail(string $email)
    {
        return $this->fetchOne("SELECT uuid, `name`, last_name, cpf, cep, contact, email FROM clients WHERE email = :email", ['email' => $email]);
    }

    
    
}