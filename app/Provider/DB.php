<?php

namespace app\Provider;

use Exception;
use PDO;

class DB

{
    private static $pdo;

    public function mysql() 
    {   

        try {
            
            if(!self::$pdo) 
            {
                $dsn = "mysql:host=".HOST.";dbname=".DBNAME.";charset=utf8mb4";
                self::$pdo = new PDO($dsn, ROOT, PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
            }

        } catch(Exception $e) {
            die('Erro de conexão com banco de dados!');
        }

        return self::$pdo;
    }

    
}