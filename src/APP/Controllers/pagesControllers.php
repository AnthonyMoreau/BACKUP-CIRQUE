<?php


namespace AppCirque\APP\Controllers;

use AppCirque\APP\models\FormContact;
use AppCirque\APP\models\UserInscription;
use AppCirque\core\DATE\gestion_dates;
use AppCirque\core\HELPERS\Finder;
use AppCirque\core\HTML\AppLinks;
use AppCirque\core\PDO\MY_SQL_PDO;

class pagesControllers extends pages
{

    public static $title;


    public static function getInstance(): pagesControllers
    {
        return new self();
    }


    public function home(): void
    {
        self::$title = 'home';

        $pdo = MY_SQL_PDO::start();
        $req = $pdo->query("SELECT * FROM articles WHERE category='home' ORDER BY id DESC LIMIT 3");
        $articles = $req->fetchAll();

        $var = [
            'Gestion_form' => (new UserInscription)->UsersDefaultInscription(),
            'Date' => (new gestion_dates)->day_date_words(' '),
            'articles' => (!empty($articles) ? $articles : null)
        ];

        $this->render('home','default', compact('var'), 'Home');
    }

    public function news(): void
    {
        self::$title = 'news';

        $var = [
            'content' => 'Un Contenu'
        ];
        $this->render('news','default', compact('var'));
    }

    public function contact (): void
    {

        self::$title = 'Contact';
        $var = [
            'formulaire' => (new FormContact())->formContact(),
            'map' => AppLinks::display_link('Nous localiser', 'https://goo.gl/maps/WsXiT95zFaUCU9Ff7', true, [])
        ];

        $this->render('contact','default', compact('var'));

    }




    public function show(): void
    {
        $path = $_GET['path'];

        $pdo = MY_SQL_PDO::start();
        $req = $pdo->query("SELECT * FROM articles WHERE images_path='$path'");
        $article = $req->fetchAll();

        self::$title = $article[0]->title;

        $var = [
            'article' => $article[0],
            'photos_HQ' => scandir(Finder::Path_Finder('ajax',"HQ/$path")),
            'photos_thumbs' => scandir(Finder::Path_Finder('ajax',"miniatures/$path"))
        ];


        $this->render('show','default', compact('var'));
    }
}