<?php

use AppCirque\core\PDO_MEMORY\PDO_MEMORY;
use PHPUnit\Framework\TestCase;
use AppCirque\core\PDO_MEMORY\Create_Tables;
use AppCirque\APP\users\UsersLogins;
use AppCirque\core\VALIDATE\validate;

require '../../vendor/autoload.php';

class UsersLoginsTest extends TestCase{

    public function table($table): void
    {
        $create = new Create_Tables();
        $create->New_Table($table, 'name TEXT, email TEXT, password TEXT');
        PDO_MEMORY::start()->exec("INSERT INTO nico (name, email, password) VALUES ('nico', 'plop@dev.com', 'motdepasse')");
    }

    public function test_getValidate(): void
    {
        $x = new validate();
        $q = new UsersLogins($x);
        $this->assertIsObject($q);
    }

    public function test_getValidateWithEXECPTION(): void
    {
        $this->expectException(RuntimeException::class);
        $x = 0;
        new UsersLogins($x);

    }

    public function test_session_Auth(): void
    {
        $this->table('nico');
        $posts = [
            'name' => 'nico',
            'email' => 'plop@dev.com',
            'password' => 'motdepasse',
            'confirm_password' => 'motdepasse'
        ];
        $validate = new validate();

        $validate->names($posts['name']);
        $validate->email($posts['email']);
        $validate->passwordConfirm($posts['password'], $posts['confirm_password']);

        $usersLogins = new UsersLogins($validate);
        $this->assertTrue($usersLogins->session_Auth($posts, 'nico'));
    }

    public function test_session_No_Auth(): void
    {
        $this->table('pascal');
        $posts = [
            'name' => 'julien',
            'email' => 'jul@dev.com',
            'password' => 'motdepasse',
            'confirm_password' => 'motdepasse'
        ];
        $validate = new validate();

        $validate->names($posts['name']);
        $validate->email($posts['email']);
        $validate->passwordConfirm($posts['password'], $posts['confirm_password']);

        $usersLogins = new UsersLogins($validate);
        $this->assertFalse($usersLogins->session_Auth($posts, 'pascal'));
    }
}