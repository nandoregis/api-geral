<?php
namespace app\Provider;

use Exception;
use PDO;

class DB
{
    private static $pdo;
    private static $pdoAuth;

    public function db()
    {
        try {
            if (!self::$pdo) {
                $dsn = "mysql:host=" . \HOST . ";dbname=" . \DBNAME . ";charset=utf8mb4";
                self::$pdo = new PDO($dsn, \ROOT, \PASSWORD);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die('Erro de conexão com banco principal');
        }

        return self::$pdo;
    }

    public function users()
    {
        try {
            if (!self::$pdoAuth) {
                $dsn = "mysql:host=" . \HOST_AUTH . ";dbname=" . \DBNAME_AUTH . ";charset=utf8mb4";
                self::$pdoAuth = new PDO($dsn, \ROOT_AUTH, \PASSWORD_AUTH);
                self::$pdoAuth->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdoAuth->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            die('Erro de conexão com banco de usuários');
        }

        return self::$pdoAuth;
    }
}
