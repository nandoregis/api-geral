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

    public function getUserForUUID(String $uuid) : Array | null 
    {

        $sql = "
            SELECT 
                uuid,
                name,
                hash_password
            FROM users
            WHERE uuid = :uuid
            LIMIT 1
        ";

        $stmt = parent::usersDB()->prepare($sql);
        $stmt->bindValue(':uuid', $uuid);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: [];
    }

    public function getForUsername(String $username) : Array 
    {

        $sql = "
            SELECT 
                uuid,
                name,
                hash_password,
                `key`
            FROM users
            WHERE username = :username
            LIMIT 1
        ";

        $stmt = parent::usersDB()->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: [];
    }


}