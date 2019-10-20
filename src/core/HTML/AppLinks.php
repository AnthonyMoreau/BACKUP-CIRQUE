<?php


namespace AppCirque\core\HTML;


use AppCirque\core\HELPERS\Paths_Helper;
use RuntimeException;

class AppLinks extends HTML
{
    private $get_utf8;

    public function __construct()
    {
        $this->get_utf8 = require 'config_utf8.php';
    }

    public function get_UTF_config(): array
    {
        return $this->get_utf8;
    }

    public static function css($tab, $parent = 'src/assets/styles') : string
    {
        $x = '';
        if (is_string($tab))
        {
            if(!file_exists("$parent/$tab.css")){
                throw new RuntimeException ("Le fichier $parent/$tab.css n'existe pas");
            }
            $x = "<link rel=\"stylesheet\" href=\"$parent$tab.css\">";
        }
        if(is_array($tab)){
            foreach ($tab as $link){
                if(!file_exists("$parent/$link.css")){
                    throw new RuntimeException ("Le fichier $parent/$link.css n'existe pas");
                }
                $x .= "<link rel=\"stylesheet\" href=\"$parent/$link.css\">";
            }
        }
        return $x;
    }

    /**
     * lier les scripts cdn ou locaux
     * @param $tab_scripts
     * @param $pages
     * @param $links
     */
    public static function link_scripts($tab_scripts, $pages, $links): void
    {

        foreach($tab_scripts as $path => $scripts) {
            foreach ($links as $link){
                if($link === self::clean_string_to_link($pages))
                {
                    if ($path === 'CDN') {
                    ?>
                    <script src="<?= (string)$scripts ?>"></script>
                    <?php
                } else {
                    ?>
                    <script src="<?= "$path/$scripts.js" ?>"></script>
                    <?php
                }
                }
            }
        }
    }

    /**
     * formate un text pour un lien
     * @param $text
     * @return string
     */
    public static function clean_string_to_link($text): string
    {
        if(!is_string($text)){
            throw new \RuntimeException("la variable doit etre de type 'string'");
        }
        return strtolower(preg_replace(array_keys((new AppLinks)->get_UTF_config()), array_values((new AppLinks)->get_UTF_config()), $text));
    }

    /**
     * Affiche un liens et son nom avec ou sans target
     * @param $content
     * @param $href
     * @param bool $target_blank
     * @param array $attr
     * @return void
     */
    public static function nav_link($content, $href, $target_blank = false, $attr = []) :void
    {

        ?>
            <a href="<?= $href ?>" title="<?= $content ?>" <?= (new HTML)->Set_Attributes($attr) ?> <?php if($target_blank) {echo "target='_blank'";}?> ><?= $content ?></a>
        <?php

    }

    /**
     * Affiche un liens et son nom avec ou sans target
     * @param $content
     * @param $href
     * @param bool $target_blank
     * @param array $attr
     * @return false|string
     */
    public static function display_link($content, $href, $target_blank = false, $attr = [])
    {
        ob_start();
            ?>
                <a href="<?= $href ?>" title="<?= $content ?>" <?= (new HTML)->Set_Attributes($attr) ?> <?php if($target_blank) {echo "target='_blank'";}?> ><?= $content ?></a>
            <?php
        return ob_get_clean();
    }
}