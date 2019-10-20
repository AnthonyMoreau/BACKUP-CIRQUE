<?php


namespace AppCirque\core\VALIDATE;

class validate
{
    public $matche;
    public $error = [];
    public $REGEX;

    public function __construct()
    {
        $this->REGEX = require 'regex.php';
    }

    public function names($name): void
    {
        if($this->PregMatch($name, $this->REGEX['NAMES'])){$this->error ['name']= 'Votre nom est invalide';}
    }

    public function firstName($name): void
    {
        if($this->PregMatch($name, $this->REGEX['NAMES'])){$this->error ['firstName']= 'Votre prénom est invalide';}
    }


    public function pseudo($pseudo): void
    {
        if($this->PregMatch($pseudo, $this->REGEX['PSEUDO'])){$this->error ['pseudo']= 'Votre speudo est invalide';}
    }

    public function email($email): void
    {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $this->error ['email']= 'Votre email est invalide';
        }
    }

    public function passwordConfirm($password, $password_confirm): void
    {
        if($password !== $password_confirm){
            $this->error ['password_confirm']= 'Vos mots de passes sont différents';
        }
    }

    public function date($date): void
    {
        foreach ($this->REGEX['DATE_SEPARATOR'] as $separator){
            $x = explode($separator, $date);
            foreach ($x as $first_test){
                if((int) $first_test === 0){
                    $this->error ['gestiondates']= 'La gestiondates n\'est pas bonne';
                    break;
                }
            }
            if (is_array($x) && count($x) === 3 ){
                if((int)$x[0] < 1 || (int)$x[0] > 31){
                    $this->error ['day_date']= 'Le jour est invalide';
                }
                if((int)$x[1] < 1 || (int)$x[1] > 12){
                    $this->error ['month_date']= 'Le mois est invalide';
                }
                if((int)$x[2] < 1900 || (int)$x[2] > 2100){
                    $this->error ['year_date']= 'L\'année est invalide';
                }
            }
            if (is_array($x) && (count($x) === 2 || count($x) > 4)){
                $this->error ['gestiondates']= 'La gestiondates est invalide';
                break;
            }

        }
    }

    public function tel($tel): void
    {
        preg_match($this->REGEX['TEL'], $tel, $matches);
        if (isset($matches[0]) && $matches[0] !== $tel){
            $this->error []= 'Votre tel est invalide';
        }
        if(!isset($matches[0])){
            $this->error []= 'Votre tel est invalide';
        }
    }

//.................................................................................\\

    private function PregMatch($value, $pattern): bool{

        $x = explode(' ', $value);

        if(is_array($x)){
            $t = [];
            foreach ($x as $key => $values){
                if($values !== ''){
                    $t []= $values;
                }
            }
            $value = implode('-', $t);
        }
        preg_match($pattern, $value, $matches);
        $this->matche = ucfirst($matches[0]);
        return $matches[0] !== $value || !isset($matches[0]);
    }
}