<?php

use AppCirque\admin\Controllers\Admin;
use AppCirque\admin\Controllers\Admin_Controller;
use AppCirque\APP\navigation\Navigation;
use AppCirque\core\HELPERS\Finder;
use AppCirque\core\HTML\AppLinks;
$page = ($_GET['admin'] ?? 'login');
$navigation = new Navigation();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= AppLinks::css(['style', 'test'], '../assets/styles/') ?>
    <title><?= ucfirst(Admin::$title) ?></title>
</head>
<body>

<?php

$nav_attr = [
    'class' => 'basic-drop-nav',
    'id' => 'admin'
];

$navigation->navigation($page, 'admin', $nav_attr);

?>
<div class="admin-content">
    <?php

        if(isset($content)){echo $content;}

    ?>
</div>


<?php
AppLinks::link_scripts(['../assets/js' => 'drop-zone'], $page, ['addarticle', 'modify']);
AppLinks::link_scripts(['../assets/js' => 'text_edit'], $page, ['addarticle', 'modify']);
?>
</body>
</html>
