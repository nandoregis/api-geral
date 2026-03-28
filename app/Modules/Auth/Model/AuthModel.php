<?php

namespace app\Modules\Auth\Model;

use app\Model\Model;
use PDO;

class AuthModel extends Model
{

    public function __construct() 
    {

        parent::__construct();

    }

    public function getByUUID(String $uuid) : array
    {

        $sql = "SELECT 
                    uuid,
                    `name`,
                    hash_password
            FROM users
            WHERE uuid = :uuid
            LIMIT 1
        ";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: [];
    }

    public function getByEmail(string $email) : array 
    {

        $sql = "SELECT 
                    uuid,
                    `name`,
                    hash_password
            FROM users
            WHERE email = :email
            LIMIT 1
        ";

        $stmt = parent::PrimayDB()->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: [];
    }


}