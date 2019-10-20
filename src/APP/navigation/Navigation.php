<?php


namespace AppCirque\APP\navigation;

use AppCirque\core\HELPERS\URLHelper;
use AppCirque\core\HTML\AppLinks;
use AppCirque\core\HTML\HTML;
use RuntimeException;

class Navigation extends HTML
{

    public $config;

    public function __construct()
    {
        if ($_SERVER['PHP_SELF'] === '/src/admin/index.php'){
            $this->config = require 'ConfigAdmin.php';
        } else {
            $this->config = require 'Config.php';
        }
    }


    public function get_config(){
        return $this->config;
    }


    /**
     * créer un menu avec possible dropdown
     * @param $active
     * @param string $get
     * @param array $attr
     * @param string $dropdown
     * @param string $drop_downbtn
     * @param string $dropdown_content
     */
    public function navigation($active, $get = 'page', $attr = ['class' => 'navbar'], $dropdown = 'dropdown', $drop_downbtn = 'dropbtn', $dropdown_content = 'dropdown-content'): void
    {
     $tab_link = $this->get_config();

        echo $this->open_tag('div', $attr);
        foreach($tab_link as $key => $value){
            if(empty($value)){
                if($active === AppLinks::clean_string_to_link($key)){
                    AppLinks::nav_link($key, URLHelper::make_link('..', 'index', [ $get => $key]),false,['class' => 'active']);
                } else {
                    AppLinks::nav_link($key, URLHelper::make_link('..', 'index', [ $get => $key]));
                }

            } else {

                $this->make_dropdown($value, $key, $active, $dropdown, $drop_downbtn, $dropdown_content);
            }
        }
        echo $this->close_tag('div');
    }

    /**
     * @param $value
     * @param $key
     * @param $active
     * @param $dropdown
     * @param $drop_downbtn
     * @param $dropdown_content
     * @return void
     * @throws RuntimeException
     */
    private function make_dropdown($value, $key, $active, $dropdown, $drop_downbtn, $dropdown_content): void
    {
        $x = '';
        foreach ($value as $keys){
            if($active === AppLinks::clean_string_to_link($keys)){
                $x = 'button-active';
            }
        }
        echo $this->open_tag('div', ['class' => 'droper']);
        echo $this->open_tag('div', ['class' => "$dropdown $x"]);
        echo $this->open_tag('button', ['class' => $drop_downbtn]);
        echo $key.'&nbsp;';
        echo $this->close_tag('button');
        echo $this->open_tag('div', ['class' => "$dropdown_content display-none"]);

        foreach ($value as $link){
            $link_with_key = false;
            try{
                $link_with_key = $this->analyse_tab_to_value($link);
            } catch (RuntimeException $e){

            }
            // POSSIBLE CACA :)
            if($link_with_key){

                foreach ($link as $tab_sub_menu => $key_sub){

                    echo $this->Open_tag('div', ['class' => 'sub-menu']);

                    echo $this->Open_tag('button', ['class' => 'sub-button']);
                    echo $tab_sub_menu;
                    echo $this->close_tag('button');
                    echo $this->open_tag('div', ['class' => 'sub-content']);
                    foreach ($key_sub as $link_sub){
                        $href = URLHelper::make_Link('..', 'index', ['page' => $link_sub]);
                        AppLinks::nav_link($link_sub, $href);
                    }
                    echo $this->close_tag('div');
                    echo $this->close_tag('div');
                }
            } else if($active === AppLinks::clean_string_to_link($link)){
                AppLinks::nav_link($link, URLHelper::make_Link('..', 'index', ['page' => $link]), false, ['class' => 'active']);
            } else {
                AppLinks::nav_link($link, URLHelper::make_Link('..', 'index', ['page' => $link]));
            }
        }
        echo $this->Close_Tag('div');
        echo $this->Close_Tag('div');
        echo $this->Close_Tag('div');
    }

    /**
     * @param $tab
     * @return bool
     * @throws RuntimeException
     */
    private function analyse_tab_to_value($tab): bool
    {
        $t = false;

        if(!is_array($tab)) {

            throw new RuntimeException('la variable attendu doit être un tableau');

        }

        foreach ($tab as $key => $value){

            if(!is_array($value)) {

                throw new RuntimeException('la variable doit contenir une clés');

            }

            $t = true;
        }
        return $t;
    }

}