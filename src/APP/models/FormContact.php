<?php


namespace AppCirque\APP\models;

use AppCirque\core\HTML\form;
use AppCirque\core\PDO_MEMORY\Create_Tables;
use AppCirque\core\PDO_MEMORY\PDO_MEMORY;
use AppCirque\core\VALIDATE\validate;

class FormContact extends AppModel
{
    public $validate;
    public $Form;
    public $color = [];

    public function __construct()
    {
        //injection à l'américaine
        $this->validate = new validate();
        $this->Form = new form();
        $this->color = [
            'success' => '#B4DCD1',
            'errors' => '#FC999C'
        ];
    }

    public function formContact () {

        $firstname = $this->getPOST('firstnames');
        $name = $this->getPOST('names');
        $objet = $this->getPOST('objet');
        $emails = $this->getPOST('email');
        $message = $this->getPOST('message');

        if ($this->getPOST() !== null){

            $this->validate->firstName($firstname);
            $this->validate->names($name);
            $this->validate->email($emails);

            if (empty($this->validate->error)) {

                $create = new Create_Tables();
                $create->New_Table('messages', 'firstNames TEXT, names TEXT, emails TEXT, object TEXT, message TEXT');

                PDO_MEMORY::start()->exec("INSERT INTO messages (firstnames, names, emails, object, message) VALUES ('$firstname', '$name', '$emails', '$objet', '$message')");

                $this->validate->error ['success']= 'Votre message a bien été envoyé';

            } else {

                $this->validate->error ['errors']= 'Il y a des erreures dans le formulaire';
            }
        }

        ob_start();
        $this->Form->open_form('index.php?page=contact');
            echo $this->Form->input('firstnames', 'text', 'Prénom', true, ['placeholder' => 'ex : Camille']);
                ?>
                <div class="errors" style="font-style: italic; color: #FC999C">
                    <?php if (!empty($this->validate->error['firstName'])) {echo $this->validate->error['firstName'];} ?>
                </div>
                <br>
                <?php
            echo $this->Form->input('names', 'text', 'Nom', true, ['placeholder' => 'ex : Dupont']);
                ?>
                <div class="errors" style="font-style: italic; color: #FC999C">
                    <?php if (!empty($this->validate->error['name'])) {echo $this->validate->error['name'];} ?>
                </div>
                <br>
                <?php
            echo $this->Form->input('emails', 'email', 'Email', true, ['placeholder' => 'ex : dupont@gmail.fr']);
                ?>
                <div class="errors" style="font-style: italic; color: #FC999C">
                    <?php if (!empty($this->validate->error['email'])) {echo $this->validate->error['email'];} ?>
                </div>
                <br>
                <?php
            echo $this->Form->input('objet', 'text', 'Objet', true, ['placeholder' => 'ex : renseignements']);
            echo $this->Form->text_area('message', 'Message', true, ['placeholder' => 'ex : votre message...', 'maxlength' => 300], 20, 60 );
            echo $this->Form->submit('envoyer');
                $this->Form->close_form();
                ?>
                <div class="success" style="font-style: italic; color: <?= $this->color['success'] ?>">
                    <?php if (!empty($this->validate->error['success'])) {echo $this->validate->error['success'];} ?>
                </div>
                <br>
                <?php
                ?>
                <div class="success" style="font-style: italic; color: <?= $this->color['errors'] ?>">
                    <?php if (!empty($this->validate->error['errors'])) {echo $this->validate->error['errors'];} ?>
                </div>
                <br>
                <?php
                return ob_get_clean();
    }
}