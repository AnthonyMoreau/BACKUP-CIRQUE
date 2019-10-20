<?php


namespace AppCirque\core\PDO;
use PDO;

class MY_SQL_PDO
{
    /**
     * @var PDO
     */
    private static $pdo;

    public static function start(): PDO
    {
        if(self::$pdo === null){
            self::$pdo = new \PDO('mysql:dbname=AppCircus;host=127.0.0.1;charset=utf8','root', 'root', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$pdo;
    }
}