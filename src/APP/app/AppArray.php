<?php


namespace AppCirque\APP\app;


class AppArray
{
    public static function array_get_type($array): string
    {
        if (!is_array($array)){return 'no_array';}
        if (array_key_exists('0', $array)){
            $x = 'no_key';
        } else {
            $x = 'key';
        }
        return $x;
    }

    /**
     * @return array
     */
    public function combine_TAB(): array
    {
        $x = func_get_args();
        $c = [];
        foreach ($x as $key){
            foreach ($key as $value){
                $c []= $value;
            }
        }
        return $c;
    }
}