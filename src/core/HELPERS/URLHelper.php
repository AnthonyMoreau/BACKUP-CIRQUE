<?php


namespace AppCirque\core\HELPERS;


use AppCirque\APP\app\AppArray;
use AppCirque\core\HTML\AppLinks;

class URLHelper
{
    /**
     * Construit un lien avec ou sans get
     *
     *          Attention {chemin depuis l'index = '..', 'index'}
     *
     * @param $root_parent
     * @param $path
     * @param array $get
     * @return string
     */
    public static function make_Link($root_parent, $path, $get = [] ): string
    {
        $q = [];
        $links = Finder::Files_finder($root_parent, $path);
        $a = '';
        $count = 0;
        if (AppArray::array_get_type($get) === 'key'){
            foreach ($get as $key => $value){
                if(AppArray::array_get_type($value) === 'no_key'){
                    foreach ($value as $gets){
                        $q []= AppLinks::clean_string_to_link($gets);
                    }
                    if ($count !== 0){
                        $x = implode(', ', $q);
                        $a .= "&$key=$x";
                    } else {
                        $x = implode(', ', $q);
                        $a .= "$key=$x";
                    }
                }
                if(AppArray::array_get_type($value) === 'no_array'){
                    $value = AppLinks::clean_string_to_link($value);
                    if ($count !== 0){
                        $a .= "&$key=$value";
                    } else {
                        $a .= "$key=$value";
                    }
                }
                $count++;
            }
        }
        if(empty($get)){ return $links;}
        return "$links?$a";
    }

    /**
     * Retourne un lien externe.
     * @param $link
     * @return mixed
     */
    public static function link_ext($link){
        return $link;
    }
}