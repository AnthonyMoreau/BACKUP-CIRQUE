<?php

use PHPUnit\Framework\TestCase;
use AppCirque\core\VALIDATE\validate;

require '../../vendor/autoload.php';

class ValidateTest extends TestCase
{

    public function validate(): validate
    {
        return new validate();
    }
    public function faker(): \Faker\Generator
    {
        return Faker\Factory::create('fr_FR');
    }



    public function test_names_validation(): void{
        $validate = $this->validate();
        $validate->names($this->faker()->name);
        $this->assertEmpty($validate->error);
    }
    public function test_names_no_validation(): void{
        $validate = $this->validate();
        $validate->names('anthony 01');
        $this->assertNotEmpty($validate->error);
    }


    public function test_speudo_validation(): void{
        $validate = $this->validate();
        $validate->pseudo($this->faker()->userName);
        $this->assertEmpty($validate->error);
    }
    public function test_speudo_no_validation(): void{
        $validate = $this->validate();
        $validate->pseudo('anthony?.:');
        $this->assertNotEmpty($validate->error);
    }


    public function test_email_validation(): void{
        $validate = $this->validate();
        $validate->email($this->faker()->email);
        $this->assertEmpty($validate->error);
    }
    public function test_email_no_validation(): void{
        $validate = $this->validate();
        $validate->email('test error');
        $this->assertNotEmpty($validate->error);
    }


    public function test_password_confirmed(): void{
        $validate = $this->validate();
        $validate->passwordConfirm('root', 'root');
        $this->assertEmpty($validate->error);
    }
    public function test_no_password_confirmed(): void{
        $validate = $this->validate();
        $validate->passwordConfirm($this->faker()->password, $this->faker()->password);
        $this->assertNotEmpty($validate->error);
    }


    public function test_valid_date(): void{
        $validate = $this->validate();
        $validate->date($this->faker()->dateTimeThisCentury->format('d m Y'));
        $this->assertEmpty($validate->error);
    }
    public function test_no_valide_date(): void{
        $validate = $this->validate();
        $validate->date('test error');
        $this->assertNotEmpty($validate->error);
    }


    public function test_valid_tel(): void{
        $validate = $this->validate();
        $validate->tel($this->faker()->phoneNumber);
        $this->assertEmpty($validate->error);
    }
    public function test_no_valide_tel(): void{
        $validate = $this->validate();
        $validate->tel('test error');
        $this->assertNotEmpty($validate->error);
    }

}