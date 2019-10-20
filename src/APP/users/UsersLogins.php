<?php


namespace AppCirque\APP\users;

use AppCirque\core\PDO_MEMORY\PDO_MEMORY;

class UsersLogins
{
    private $instance_validate;

    public function __construct($instance_validate)
    {
        if(is_object($instance_validate)){
            $this->instance_validate = $instance_validate;
        } else {
            throw new \RuntimeException('INSTANCE N\'EST PAS UN OBJET');
        }
    }

    public function get_errors(): array
    {
        return $this->instance_validate->error;

    }

    public function Auth($posts, $table): array
    {
        $x = [];
        if(empty($this->get_errors())){
            $name = $posts['name'];
            $email = $posts['email'];
            $password = $posts['password'];

            $x = PDO_MEMORY::start()->query("SELECT name, email, password FROM $table WHERE name='$name' AND email='$email' AND password='$password'")->fetchAll();
        }
        return $x;
    }

    public function session_Auth($posts, $table): bool
    {
        $auth = false;
        if(!empty($this->Auth($posts, $table))){
            $auth = true;
        } else {
            $this->instance_validate->error []= 'L\'authentification a echoué';
        }
        return $auth;
    }
}

echo 'user login';