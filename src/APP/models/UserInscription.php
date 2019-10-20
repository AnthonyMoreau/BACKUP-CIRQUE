<?php


namespace AppCirque\APP\models;


use AppCirque\core\HTML\form;
use AppCirque\core\PDO_MEMORY\Create_Tables;
use AppCirque\core\PDO_MEMORY\PDO_MEMORY;
use AppCirque\core\VALIDATE\validate;

class UserInscription extends AppModel
{
    public $instance_validate;
    public $FORM;

    public function __construct()
    {
        $this->instance_validate = new validate();
        $this->FORM = new form();
    }

    /**
     * @return false|string
     */
    public function UsersDefaultInscription()
    {
        $create = new Create_Tables();
        $create->New_Table('users', 'usernames TEXT, emails TEXT, passwords TEXT');

        if (!empty($_POST)) {
            $usernames = $_POST['usernames'];
            $emails = $_POST['emails'];
            $passwords = $_POST['password'];
            $passwords_check = $_POST['password_confirm'];

            $this->instance_validate->names($usernames);
            $this->instance_validate->email($emails);
            $this->instance_validate->passwordConfirm($passwords, $passwords_check);

            if (empty($this->instance_validate->error)) {
                $passwords = password_hash($passwords, PASSWORD_DEFAULT);
                PDO_MEMORY::start()->exec("INSERT INTO users (usernames, emails, passwords) VALUES ('$usernames', '$emails', '$passwords')");

                $this->instance_validate->error ['success']= 'Bravo pour votre inscription';

            } else {

                $this->instance_validate->error ['errors']= 'Il y a des erreures dans le formulaire';
            }
        }
        ob_start();
        //CORRECTIF A FAIRE AU NIVEAU DES EMPTY ERRORS...
            $this->FORM->open_form('index.php?page=home');
                $this->FORM->input('usernames', 'text', 'usernames', true);
                    ?>
                    <div class="errors" style="font-style: italic; color: #FC999C">
                       <?php if (!empty($this->instance_validate->error['name'])) {echo $this->instance_validate->error['name'];} ?>
                    </div>
                    <br>
                    <?php
                $this->FORM->input( 'emails', 'email', 'email', true);
                    ?>
                    <div class="errors" style="font-style: italic; color: #FC999C">
                        <?php if (!empty($this->instance_validate->error['email'])) {echo $this->instance_validate->error['email'];} ?>
                    </div>
                    <br>
                    <?php
                $this->FORM->input('password', 'password', 'password', true);
                $this->FORM->input( 'password_confirm', 'password', 'confirmer password', true);
                    ?>
                    <div class="errors" style="font-style: italic; color: #FC999C">
                        <?php if (!empty($this->instance_validate->error['password_confirm'])) {echo $this->instance_validate->error['password_confirm'];} ?>
                    </div>
                    <br>
                    <?php
                $this->FORM->submit('envoyer');
            $this->FORM->close_form();
                    ?>
                    <div class="success" style="font-style: italic; color: #B4DCD1">
                        <?php if (!empty($this->instance_validate->error['success'])) {echo $this->instance_validate->error['success'];} ?>
                    </div>
                    <br>
                    <?php
                    ?>
                    <div class="success" style="font-style: italic; color: #FC999C">
                        <?php if (!empty($this->instance_validate->error['errors'])) {echo $this->instance_validate->error['errors'];} ?>
                    </div>
                    <br>
                    <?php
        return ob_get_clean();
    }
}