<?php

use AppCirque\APP\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

class pagesControllersTest extends TestCase{

    public function test_home(): void
    {
        //LE CHEMIN PROVOQUE UNE EXECPTION
        $this->expectException(RuntimeException::class);
        $x = new HomeController();
        $x->home();
    }

}