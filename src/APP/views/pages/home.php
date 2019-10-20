<?php
// AFFICHAGE DU CONTENU DE LA HOME
use AppCirque\core\HELPERS\Finder;

if (isset($var)) : ?>

    <div class="home-container">

        <section class="introduction">
            <?= $var['Date'] ?>
            <div class="presentation">
                <h2>bienvenu</h2>
                <p>
                    L'école Tout un Cirque vous propose de découvrir ou d'approfondir plusieurs activités circassiennes :
                    l'acrobatie et les portés acrobatiques, l'équilibre sur objet, la voltige à cheval, la jonglerie, les
                    aériens et le  jeu d'acteur.
                </p>
                <p>
                    Cet enseignement est dispensé tout au long de l'année par des professionnels du cirque,
                    lors de cours hebdomadaires et pendant les stages en périodes de vacances.
                </p>
                <p>
                    L'association a pour volonté de s'adresser au plus grand nombre et de proposer une éducation artistique et corporelle,
                    basée sur la confiance en soi, l'esprit de groupe, la créativité et l'agilité...
                </p>
            </div>

        </section>

        <section class="headlines-container">
            <?php if ($var['articles'] !== null) : ?>


                <?php foreach ($var['articles'] as $article) : ?>

                    <?php $photo_path = Finder::Path_Finder('ajax', 'miniatures') .'/'.$article->images_path ; ?>

                    <?php $photos = (is_dir($photo_path)) ? scandir($photo_path) : []; ?>

                        <?php foreach ($photos as $photo) : ?>
                            <?php $photo = explode('.', $photo) ?>

                            <?php if ($photo[0] === 'mise_en_avant') : ?>
                            <div class="headline-card">
                                <p style="font-size: 70%; font-style: italic; padding: 10px; text-align: right">Posté le <?= html_entity_decode($article->date) ?></p>
                                <div class="headline-header">
                                    <?= "<img src=\"/src/ajax/miniatures/$article->images_path/$photo[0].$photo[1]\" alt=\"$article->title\">" ?>
                                    <h3><?= html_entity_decode($article->title) ?></h3>
                                </div>
                                <div class="headline-catchline">
                                    <p><?= html_entity_decode($article->headline) ?></p>
                                </div>
                                <div class="headline-footer">
                                    <div class="headline-link">
                                        <a href="<?= "index.php?page=show&path=$article->images_path" ?> ">Lire la suite</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach ?>

                <?php endforeach ?>

           <?php endif ?>
        </section>


    </div>

<?php endif;
