<?php


namespace AppCirque\core\HELPERS;
use RuntimeException;

class Finder
{
    /**
     * require un fichier
     * @param $root_parent
     * @param $path
     * @param bool $once
     */
    public static function Required_finder($root_parent, $path, $once = false): void
    {
        $x = scandir(Paths_Helper::ROOT_PATH().'src');

        foreach ($x as $paths) {
            if (!is_dir("src/$root_parent")){
                throw new RuntimeException(Paths_Helper::ROOT_PATH() . 'src/' . $root_parent . ' non trouvé');
            }
            if ($root_parent === $paths){
                if(!file_exists("src/$root_parent/$path.php")){
                    throw new RuntimeException(Paths_Helper::ROOT_PATH() . 'src/' . $root_parent. '/' . $path . '.php non trouvé');
                }
                if(!$once){
                    require Paths_Helper::ROOT_PATH().'src/'."$root_parent/$path.php";} else {require_once Paths_Helper::ROOT_PATH().'src/'."$root_parent/$path.php";}
            }
        }
    }

    /**
     * retourne le lien complet d'un fichier
     * @param $root_parent
     * @param $path
     * @return string
     */
    public static function Files_finder($root_parent, $path): string
    {
        if (!is_dir(Paths_Helper::ROOT_PATH() ."src/$root_parent")){
            throw new RuntimeException(Paths_Helper::ROOT_PATH() . 'src/' . $root_parent . ' non trouvé');
        }
        return 'src/' . "$root_parent/$path.php";
    }

    /**
     * retrouve un chemin et le retourne
     * @param $root_parent
     * @param $path
     * @return string
     */
    public static function Path_Finder($root_parent, $path): string
    {
        $x = Paths_Helper::get_All_paths();

        $z = '';

        foreach ($x as $paths) {
            if (!is_dir(Paths_Helper::ROOT_PATH() .'src/' . (string)$root_parent)){
                throw new RuntimeException('Dossier parent non trouvé');
            }
            if(!is_dir(Paths_Helper::ROOT_PATH() .'src/' . "$root_parent/$path")){
                throw new RuntimeException("Le chemin $root_parent/$path n'existe pas");
            }
            if ($root_parent === $paths) {
                $z = Paths_Helper::ROOT_PATH() . 'src/' . "$root_parent/$path/";
            }
        }
        return $z;
    }
}