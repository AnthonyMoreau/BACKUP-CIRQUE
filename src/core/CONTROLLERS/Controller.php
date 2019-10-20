<?php


namespace AppCirque\core\CONTROLLERS;

use AppCirque\core\HELPERS\Finder;

class Controller
{
    private $viewPath;
    private $default_templates;

    protected function render($view, $template, $var = [],  $header = null, $root_parent = 'APP'): void
    {
        ob_start();
            extract($var, EXTR_OVERWRITE);
            require "{$this->getViews($root_parent)}$view.php";
        $content = ob_get_clean();
        $header_templates = $header;
        require "{$this->getTemplates($root_parent)}$template.php";

    }

    protected function getPOST($post = 'all')
    {
        if (($post === 'all') && !empty($_POST)) {return $_POST;}
        if (isset($_POST[$post]) && !empty($_POST[$post])){return $_POST[$post];}
        return null;
    }

    private function getViews($root_parent, $path = 'views/pages/'): string
    {
        $this->viewPath = Finder::Path_Finder($root_parent, $path);
        return $this->viewPath;
    }

    private function getTemplates($root_parent, $path = 'views/templates/'): string
    {
        $this->default_templates = Finder::Path_Finder($root_parent, $path);
        return $this->default_templates;
    }
}