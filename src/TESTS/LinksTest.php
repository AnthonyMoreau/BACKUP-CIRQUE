<?php
require '../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use AppCirque\core\HTML\AppLinks;
use AppCirque\core\EXCEPTION\LinksException;

class LinksTest extends TestCase
{
    public function test_css_file_exist(): void
    {
        //LE CHEMIN PROVOQUE UNE EXECPTION
        $this->expectException(RuntimeException::class);
        $this->assertEquals('<link rel="stylesheet" href="/src/assets/styles/style.css">', AppLinks::css('style'));
    }

    public function test_css_file_no_exist_with_exception(): void
    {
        $this->expectException(LinksException::class);
        AppLinks::css('styles01');
    }
}