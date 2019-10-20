<?php

use AppCirque\admin\Controllers\Admin_Controller;
use AppCirque\core\ROUTES\routes;

require '../../vendor/autoload.php';

session_start();

$_SESSION['adminInstance'] = ($_SESSION['adminInstance'] ?? Admin_Controller::getAdminInstance());

if (isset($_GET['admin'])) {

    if($_GET['admin'] === 'administration') {$page = 'admin';} else {$page = $_GET['admin'];}

} else {

    $page = 'login';

}


(new routes)->route($page, $_SESSION['adminInstance'],'AppCirque\admin\Controllers\\');

d($GLOBALS, $_SERVER);