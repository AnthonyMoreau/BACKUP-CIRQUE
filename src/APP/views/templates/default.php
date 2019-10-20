<?php

use AppCirque\APP\Controllers\HeaderController;
use AppCirque\APP\Controllers\pagesControllers;
use AppCirque\APP\navigation\Navigation;
use AppCirque\core\HTML\AppLinks;


$page = ($_GET['page'] ?? 'home');

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= AppLinks::css(['style', 'test']) ?>
    <title><?= ucfirst(pagesControllers::$title) ?></title>
</head>
<body>

<?php
?>
    <header>
        <?php
        if(isset($header_templates) && $header_templates !== null){
            ?>
                <div class="header-<?= $header_templates ?>">
                <?php
                    $x = "Header$header_templates";
                    (new HeaderController)->$x();
                ?>
            </div>
            <?php
        }

        ?>
    </header>
        <?php

$nav_attr = [
    'class' => 'basic-drop-nav',
    'id' => 'user-navigation'
];
$navigation = new Navigation();
$navigation->navigation($page, 'page', $nav_attr);

?>

    <div class="site-content">
<?php
        if(isset($content)){echo $content;}

?>
    </div>
<?php
AppLinks::link_scripts(['/src/assets/js' => 'show'], $page, ['show']);
?>
</body>
</html>