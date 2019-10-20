<?php


namespace AppCirque\core\PDO_MEMORY;

use AppCirque\core\EXCEPTION\CreateTablesMemoryException;
use PDOException;

class Create_Tables
{
    public function New_Table($table_name, $fields): ?int
    {
        try{
            return PDO_MEMORY::start()->exec("CREATE TABLE $table_name ( $fields ) ");
        } catch (PDOException $e){
            throw new CreateTablesMemoryException("CREATE : {$e->getMessage()}");
        }
    }
}