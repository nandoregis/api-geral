<?php

namespace app\Model;

use app\Provider\DB;
use PDO;

class Model

{   
    private $database;
    public function __construct() 
    {
        $this->database = new DB;
    }

    protected function usersDB()
    {
        return $this->database->users();
    }

    protected function PrimayDB()
    {
        return $this->database->db();
    }

    protected function fetchOne(string $sql, array $params): array
    {
        $stmt = $this->PrimayDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->PrimayDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
}