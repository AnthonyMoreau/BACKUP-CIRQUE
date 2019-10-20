<?php


namespace AppCirque\APP\Controllers;


use AppCirque\core\CONTROLLERS\Controller;
use AppCirque\core\DATE\gestion_dates;

class pages extends Controller
{
    public static $title;

    
    public static function get_date(): string
    {
        return (new gestion_dates)->day_date_words();
    }
}