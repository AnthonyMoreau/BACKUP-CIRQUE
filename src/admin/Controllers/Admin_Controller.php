<?php


namespace AppCirque\admin\Controllers;


use AppCirque\core\HELPERS\Finder;
use AppCirque\core\HELPERS\URLHelper;
use AppCirque\core\HTML\AppLinks;
use AppCirque\core\VALIDATE\validate;

class Admin_Controller extends Admin
{
    public $initroute = '/';

    /**
     * affiche les formulaire dans l'administration
     */
    public $forms;

    public $name;
    public $email;
    public $password;

    public $errors;

    public $Auth;

    public $session;

    
    public static function getAdminInstance(): Admin_Controller
    {
        return new self();
    }



    public function login(): void
    {

        if (!empty($this->getPOST('deco'))){$this->errors = 'vous êtes deconnecté'; $this->Auth = null;}

        if ($this->Auth === true){header('Location: index.php?admin=admin');}

        self::$title = 'login';


        $this->CreateAdminTables('admins');
        $this->CreateAdmin();

        $this->name = $this->getPOST('name');
        $this->email = $this->getPOST('email');
        $this->password = $this->getPOST('password');

        /**
         * Formulaire de connection
         */
        $this->forms = $this->AuthAdminForm();

        if ($this->name !== null && $this->email !== null){

            $validate = new validate();
            $validate->names($this->name);
            $validate->email($this->email);

            $this->errors = $validate->error;

            if (empty($this->errors) && !empty($this->AuthAdmin($this->name, $this->email, $this->password))) {
                $this->Auth = true;
                header('Location: index.php?admin=admin');
            } else {
                $this->errors = 'Connection impossible';
            }

        }

       $var = [
            'home' => $this->initroute.URLHelper::make_Link('..', 'index', ['page' => 'home']),
            'admin' => $this->initroute.URLHelper::make_Link('admin', 'index', ['admin' => 'admin']),
            'errors' => $this->errors
        ];

        $this->render('login', 'default', compact('var'),'admin', 'admin');
        $this->errors = '';
    }

    public function admin(): void
    {
        self::$title = 'administration';

        if ($this->Auth !== true){$this->errors = 'access interdit'; header('Location: index.php?admin=login');}

        $articles = $this->initroute.URLHelper::make_Link('admin', 'index', ['admin' => 'AddArticle']);
        $events = $this->initroute.URLHelper::make_Link('admin', 'index', ['admin' => 'AddEvents']);
        $modifyArticles = $this->initroute.URLHelper::make_Link('admin', 'index', ['admin' => 'ModifyArticle']);

        $var = [
            'deconnect' => '<form method="post" action="index.php?admin=login"><input type="submit" name="deco" value="déconnexion"></form>',
            'AddArticle' => AppLinks::display_link('Ajouter un article', $articles),
            'modifyArticles' => AppLinks::display_link('Modifier ou supprimer un article', $modifyArticles),
            'addEvent' => AppLinks::display_link('Ajouter un évènement', $events)
        ];

        $this->render('admin', 'default', compact('var'),'admin', 'admin');
    }

    public function AddArticle(): void
    {

        $this->session = $_SESSION['addarticles'] ?? null;

        self::$title = 'Ajouter un article';

        if ($this->Auth !== true){$this->errors = 'access interdit'; header('Location: index.php?admin=login');}

        /**
         * Formulaire d'ajout d'article
         */
        $this->forms = $this->AddArticlesForm();

        $var = [

        ];

        $this->render('AddArticle', 'default', compact('var'),'admin', 'admin');

        unset($_SESSION['addarticles']);
        $this->session= null;
    }

    public function AddEvents(): void
    {

        $this->session = $_SESSION['addEvent'] ?? null;

        self::$title = 'Ajouter un Evenement';

        if ($this->Auth !== true){$this->errors = 'access interdit'; header('Location: index.php?admin=login');}

        /**
         * Formulaire d'ajout d'article
         */
        $this->forms = $this->AddEventsForm();

        $var = [

        ];

        $this->render('Addevents', 'default', compact('var'),'admin', 'admin');

        unset($_SESSION['addEvent']);
        $this->session= null;
    }

    public function modifyarticle(): void
    {

        $var = [
            'articles' => $this->GetAllArticles()
        ];

        $this->render('modifyArticles', 'default', compact('var'),'admin', 'admin');
    }

    public function modify(): void
    {
        $path = $_GET['path'];

        $_path = Finder::Path_Finder('ajax', 'miniatures').'/'.$path;
        $photo = (is_dir($_path)) ? scandir($_path) : null;

        $var = [
            'article' => $this->GetOneArticles($path),
            'scan' => $photo,

        ];

        $this->forms = $this->AddArticlesForm($path, $photo);

        $this->render('modify', 'default', compact('var'),'admin', 'admin');
    }
}