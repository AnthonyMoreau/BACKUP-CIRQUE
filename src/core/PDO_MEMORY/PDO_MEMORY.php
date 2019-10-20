<?php


namespace AppCirque\core\PDO_MEMORY;

use PDO;

class PDO_MEMORY
{
    /**
     * @var PDO
     */
    private static $pdo;

    public static function start(): PDO
    {
        if(self::$pdo === null){
            self::$pdo = new \PDO('sqlite::memory:','admin', 'plop', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }
        return self::$pdo;
    }
}