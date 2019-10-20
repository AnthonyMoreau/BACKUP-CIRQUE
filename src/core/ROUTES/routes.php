<?php


namespace AppCirque\core\ROUTES;

use AppCirque\core\HTML\AppLinks;

class routes extends AppLinks
{

    private $routes;

    /**
     */
    public function __construct()
    {
        parent::__construct();
        $this->routes = require 'Config.php';
    }

    /**
     * @param $request_page
     * @param $instance
     * @param string $pathClass
     * @return void
     */
    public function route($request_page, $instance, $pathClass = 'AppCirque\APP\Controllers\\'): void
    {
        if ($request_page === 'Administration'){$request_page = 'admin';}
        $routes = $this->clean_link();
        $x = in_array($request_page, $routes, true);
        if($x){
            foreach($routes as $name){

                if($name === $request_page ){
                    // AMELIORER POUR GERER LA 404
                    $t = $instance;
                    $t->$name();

                }
            }
        } else {
            die('error 404');
        }
    }

//----------------------------------------------------------------------------------------------------

    /**
     * @return array
     *
     */
    private function clean_link(): array
    {
        $a = $this->get_routes();
        $c = [];
        foreach($a as $name){
            $b = self::clean_string_to_link($name);
            $c []= $b;
        }
        return $c;
    }

    /**
     * @return mixed
     */
    private function get_routes(){
        return $this->routes;
    }
}