

<?php use AppCirque\core\HELPERS\URLHelper;

if (isset($_SESSION['removearticles'])){echo $_SESSION['removearticles'];}
unset($_SESSION['removearticles']);


if (isset($var)) : ?>




<?php foreach ($var['articles'] as $article) : ?>


    <div class="title">
        <h2 style="font-size: 18px; font-weight: bold"><?= $article->title ?></h2>
    </div>
    <div class="content">
        <p><?= substr($article->content, 0, 30) ?></p>
    </div>
        <div class="links">
            <a href="<?= URLHelper::make_Link('..', 'index', ['admin' => 'modify', 'path' => $article->images_path]) ?>">Modifier</a>
            <form action="/src/ajax/delete_articles.php" method="POST">
                <button type="submit" name="delete" value="<?= $article->images_path ?>">Supprimer l'article</button>
            </form>
        </div>


<?php endforeach ; ?>




<?php endif; ?>
