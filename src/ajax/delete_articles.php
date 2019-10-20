<?php

require '../../vendor/autoload.php';

use AppCirque\core\HELPERS\Finder;use AppCirque\core\PDO\MY_SQL_PDO;


session_start();


if (!empty($_POST['delete'])) {

    $_SESSION['path_article'] = $_POST['delete'];

    $path_article = $_SESSION['path_article'];

    $pdo = MY_SQL_PDO::start();
    $req = $pdo->query("SELECT * from articles WHERE images_path= '$path_article'");
    $result = $req->fetchAll();
    $article = $result[0]

    ?>

        <section class="headlines-container">

            <?php $photo_path = Finder::Path_Finder('ajax', 'miniatures') .'/'.$article->images_path ; ?>

            <?php $photos = (is_dir($photo_path)) ? scandir($photo_path) : []; ?>

            <?php foreach ($photos as $photo) : ?>
                <?php $photo = explode('.', $photo) ?>

                <?php if ($photo[0] === 'mise_en_avant') : ?>
                    <div class="headline-card">
                        <div class="headline-header">
                            <?= "<img src=\"/src/ajax/miniatures/$article->images_path/$photo[0].$photo[1]\" alt=\"$article->title\">" ?>
                            <h3><?= $article->title ?></h3>
                        </div>
                        <div class="headline-catchline">
                            <p><?= $article->headline ?></p>
                        </div>
                        <div class="headline-footer">
                            <form action="/src/ajax/delete_articles.php" method="POST">
                                <button type="submit" name="confirm_delete" value="<?= $article->images_path ?>">Supprimer l'article</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach ?>
        </section>
    <?php

}

if (!empty($_POST['confirm_delete'])){

    function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
}

    $path_article = $_SESSION['path_article'];

    $pdo = MY_SQL_PDO::start();
    $pdo->exec("DELETE FROM articles WHERE images_path= '$path_article'");
    removeDirectory(Finder::Path_Finder('ajax', "miniatures/$path_article"));
    removeDirectory(Finder::Path_Finder('ajax', "HQ/$path_article"));


    $_SESSION['removearticles'] = 'Votre article a été supprimé';


    header('location: /src/admin/index.php?admin=modifyarticle');
}