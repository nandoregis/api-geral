<?php

namespace app\Model;

use app\Provider\DB;

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
}