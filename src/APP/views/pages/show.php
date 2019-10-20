<?php
// AFFICHAGE D'UN ARTICLE

use AppCirque\core\HELPERS\Finder;

if (isset($var)) :

    $photos_thumbs = $var['photos_thumbs'];
    $photos_HQ = $var['photos_HQ'];
    $path = $var['article']->images_path;
    $alt = $var['article']->title;

    ?>

<div class="show-article">

    <div class="show-header">
        <h2 style="background-color: lightcoral"><?= html_entity_decode($var['article']->title) ?></h2>
        <div class="show-headline">
            <?php
            foreach ($photos_HQ as $photo) {
                $photo = explode('.', $photo);
                if($photo[0] === 'mise_en_avant') {
                    ?>
                    <img src="/src/ajax/HQ/<?= $path.'/'.$photo[0]. '.' . $photo[1]?>" alt="<?= $alt ?>">
                    <?php
                }
            }
            ?>
            <p style="background-color: #4e8b6a">

                <?= html_entity_decode($var['article']->headline) ?>

            </p>
        </div>
    </div>



    <div style="background-color: violet;">

        <?= html_entity_decode($var['article']->content) ?>

    </div>


    <div class="show-gallery" style="background-color: #333333">

        <?php
        foreach ($photos_thumbs as $photo) {
            if($photo !== '..' && $photo !== '.') {
                $photo_ = explode('.', (string)$photo);
                if ($photo_[0] !== 'mise_en_avant'){
                    ?>
                    <img src="/src/ajax/miniatures/<?= $path.'/'.$photo_[0].'.'. $photo_[1]?>" alt="<?= $alt ?>">
                    <?php
                }
            }
        }
        ?>

    </div>









</div>

<?php endif ?>


