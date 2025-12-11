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

    protected function mysql_conn()
    {
        return $this->database->mysql();
    }
}