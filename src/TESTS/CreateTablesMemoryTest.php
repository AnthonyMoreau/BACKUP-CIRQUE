<?php

use PHPUnit\Framework\TestCase;
use AppCirque\core\EXCEPTION\CreateTablesMemoryException;
use AppCirque\core\PDO_MEMORY\Create_Tables;

require '../../vendor/autoload.php';

class CreateTablesMemoryTest extends TestCase {

    public function testCreateTables (): void
    {
        $this->assertEquals(0, (new Create_Tables)->New_Table('other', 'names TEXT'));
    }
    public function testCreateTablesWithException (): void
    {
        $this->expectException(CreateTablesMemoryException::class);
        (new Create_Tables)->New_Table('', 'names TEXT');
    }

}