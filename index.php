<?php

use AppCirque\APP\Controllers\pagesControllers;
use AppCirque\core\ROUTES\routes;

require 'vendor/autoload.php';

session_start();

$page = ($_GET['page'] ?? 'home');

$_SESSION['pages'] = ($_SESSION['pages'] ?? pagesControllers::getInstance());

(new routes)->route($page, $_SESSION['pages']);






d($GLOBALS, $_SERVER);