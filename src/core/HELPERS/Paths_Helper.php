<?php


namespace AppCirque\core\HELPERS;

use AppCirque\APP\app\AppArray;
use RuntimeException;

class Paths_Helper
{
    public $config;

    public function __construct()
    {
        $this->config = require 'Config.php';
    }

    /**
     * recupere le chemin du site en static
     * @return string
     */
    public static function ROOT_PATH(): string
    {
        return (new Paths_Helper)->get_config_path();
    }

    /**
     * recupere la config.php['root_path'] et initialise le chemin du site.
     * @return string
     */
    public function get_config_path(): string
    {
        $a = explode('/', $this->config['root_path']);
        $b = '';
        foreach ($a as $value){
            $b .= "$value/";
            if ($value === 'AppCirque'){break;}
        }
        return $b;
    }

    /**
     * Retourne un tableau de chemins depuis 'src'
     * @return array|false
     */
    public static function get_All_paths(){
        return scandir(self::ROOT_PATH(). 'src');
    }
}

