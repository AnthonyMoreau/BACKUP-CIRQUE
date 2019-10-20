<?php


namespace AppCirque\admin\Controllers;
use AppCirque\core\CONTROLLERS\Controller;
use AppCirque\core\DATE\gestion_dates;
use AppCirque\core\EXCEPTION\CreateTablesMemoryException;
use AppCirque\core\HTML\form;
use AppCirque\core\PDO\MY_SQL_PDO;
use AppCirque\core\PDO_MEMORY\Create_Tables;
use AppCirque\core\PDO_MEMORY\PDO_MEMORY;

class Admin extends Controller
{

    public static $title;

    /**
     * @var form
     */
    private $form;


    protected function AuthAdminForm(){
        ob_start();
        $this->form = new form();
            $this->form->open_form('index.php?admin=login', 'admin-login-form');
                echo $this->form->input('name','text','Identifiant :', 'true', '');
                echo '<br>';
                echo $this->form->input('email', 'email','Email :');
                echo '<br>';
                echo $this->form->input('password', 'password','Mot de passe :');
                echo '<br>';
                echo $this->form->submit('Valider', ['id' => 'admin-login-submit']);
            $this->form->close_form();
        $this->form = ob_get_clean();
        return $this->form;

    }

    protected function AddArticlesForm($path = null, $photos = null){

        $title = '';
        $headline = '';
        $content = '';

        if ($path !== null){

            $article = MY_SQL_PDO::start()->query("SELECT * FROM articles WHERE images_path='$path'")->fetchAll();
            $title = $article[0]->title ?? '';
            $headline = $article[0]->headline ?? '';
            $content = $article[0]->content ?? '';

        }

        $this->form = new form();
        $t = $path ?? $this->RandomGet();

        ob_start();

        $phtitle = "Le titre de l'article";
        $phheadline = "un bref résumé pour la page d'accueil, si vide, un extrait sera généré automatiquement";

        echo '<div class="new-article">';

        echo '<h1 class="new-article-title">Ajouter un nouvel article</h1>';

        $this->form->open_form("../ajax/processing_add_articles.php?ID={$t}", 'add-article', 'POST', "multipart/form-data");
        echo '<div class="text-input">';
        echo '<div class="article-meta">';
        echo $this->form->text_area('title', 'Titre', $title, true, ['placeholder' => $phtitle], 1, 100);
        echo $this->form->text_area('headline', 'Accroche', $headline, false, ['placeholder' => $phheadline], 4, 100);
        if ($path === null){
            echo $this->form->input('headline-pic', 'file', 'Image de mise en avant');
        }
        echo '</div>';
        echo '<div class="article-content">';
        ?>
        <div class="toolbox">
            <span>&#9997;</span>
            <button id="add-strong" type="button">Mot-clef</button>
            <button id="add-h2" type="button">Titre</button>
            <button id="add-p" type="button">Paragraphe</button>
            <button id="font-big" type="button">Plus grand</button>
            <button id="font-small" type="button">Plus petit</button>
            <button id="add-link" type="button">Lien</button>
            <button id="add-video" type="button">Video</button>
            <button id="center" type="button">Center</button>
            <input type="color" id="color" name="color" value="#f6b73c">
            <label for="color">choisissez une couleur</label>
            <button id="cancel-add" type="button">annuler</button>
        </div>
        <div class="posted-on">posté le <?= (new gestion_dates)->day_date_words(' ') ?></div>
        <?php

        echo $this->form->text_area('content', 'Contenu', $content, true, ['id'=> 'content', 'value' => $content], 35, 100);
        echo $this->form->surround_Element('', 'div', ['id' => 'preview']);
        echo '<div class="confirm">';
        echo $this->form->submit('envoyer l\'article');
        echo '</div>';
        echo '</div>';
        echo '</div>';

        ?>
        <div class="toolbox-modal" id="toolbox-modal" style="display: none; position: fixed; top: 50%">
            <div class="toolbox-modal-content">
                <p>Ajouter un lien</p>
                <label for="link">URL</label>
                <input type="text" id="input-link" name="link">
                <button type="button" id="confirm-link">confirmer</button>
            </div>
        </div>
        <?php

        echo $this->DragNDrop($t, $photos);

            $options = [
                'home',
                'news',
                'cours',
            ];
            $attr = [
                'name' => 'category',
                'id' => 'Select-category'
            ];
            //mis a larrache
            echo $this->make_select($options, $attr);

        $this->form->close_form();
        echo '</div>';
        return ob_get_clean();
    }

    protected function AddEventsForm($path = null){

        $title = '';
        $content = '';

        if ($path !== null){

            $event = MY_SQL_PDO::start()->query("SELECT * FROM Events WHERE Articles_path='$path'")->fetchAll();
            $title = $event[0]->title ?? '';
            $content = $event[0]->content ?? '';

        }

        $this->form = new form();
        $t = $path ?? $this->RandomGet();

        ob_start();

        $phtitle = "Le titre de l'evènement";

        echo '<div class="new-article">';

        echo '<h1 class="new-article-title">Ajouter un nouvel Evènement</h1>';

        $this->form->open_form("../ajax/processing_add_events.php?ID={$t}", 'add-Eevent', 'POST', 'multipart/form-data');
        echo '<div class="text-input">';
        echo '<div class="article-meta">';
        echo $this->form->text_area('title', 'Titre', $title, true, ['placeholder' => $phtitle], 1, 100);
        echo '</div>';
        echo '<div class="article-content">';
        ?>
        <div class="toolbox">
            <?php

                echo $this->form->input('date', 'date', 'Date', 'true', ['style' => 'padding: 10px;margin: 5px;']);
                echo 'Choisissez une heure ';
                $this->make_select_hours(15);
            ?>
        </div>
        <div class="posted-on">Editer le <?= (new gestion_dates)->day_date_words(' ') ?></div>
        <?php

        echo $this->form->text_area('content', 'Contenu', $content, true, ['id'=> 'content', 'value' => $content], 35, 100);
        echo '<div class="confirm">';
        echo $this->form->submit('envoyer l\'article');
        echo '</div>';
        echo '</div>';
        echo '</div>';

        ?>
        <div class="toolbox-modal" id="toolbox-modal" style="display: none; position: fixed; top: 50%">
            <div class="toolbox-modal-content">
                <p>Ajouter un lien</p>
                <label for="link">URL</label>
                <input type="text" id="input-link" name="link">
                <button type="button" id="confirm-link">confirmer</button>
            </div>
        </div>
        <?php

        $this->form->close_form();
        echo '</div>';
        return ob_get_clean();
    }

    protected function CreateAdminTables($table): void
    {
        $x = new Create_Tables();
        try {
            $x->New_Table($table, 'name TEXT, email TEXT, password TEXT');
        } catch (CreateTablesMemoryException $e) {

        }
    }

    protected function CreateAdmin($name = 'joy', $email = 'joy@tuc.com', $password = '$argon2i$v=19$m=20480,t=8,p=3$dW8wZ2FQcDhESzZKUkxQYw$WCBfT8BF57uQsc3W0LRISBOdwXyVM9xfaK8xFgTI0m8'): void
    {
        PDO_MEMORY::start()->exec("INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$password' )");
    }

    protected function AuthAdmin($name, $email, $password){

        $auth = '';

        $pcheck = PDO_MEMORY::start()->query("SELECT password FROM admins WHERE email = '$email' ");
        $get_hash = $pcheck->fetchAll();
        $verify = password_verify($password, $get_hash[0]->password);

        if ($verify){
            $req = PDO_MEMORY::start()->query("SELECT * FROM admins WHERE name ='$name'AND email = '$email'");
            $auth = $req->fetchAll();
        }

        return $auth;
    }

    protected function RandomGet() {
        $x = null;
        try {
            $x =  bin2hex(random_bytes(16));
        } catch (\Exception $e) {
        }
        return $x;
    }

    protected function GetAllArticles(): array
    {
       return MY_SQL_PDO::start()->query("SELECT * FROM articles")->fetchAll();
    }

    protected function GetOneArticles($path): array
    {
        return MY_SQL_PDO::start()->query("SELECT * FROM articles WHERE images_path= '$path'")->fetchAll();

    }


    //-------------------------------------------------------------------



    private function DragNDrop($Get, $photos){
        ob_start();
        echo '<div class="add-pics">';
        ?>
        <div class="drag-container">

            <div class="drop_zone">
                <p class="drop-here">Déposez vos images ici</p>
                <div class="gallery">
                    <?php
                        if ($photos !== null){
                            foreach ($photos as $photo) {
                                if($photo !== '..' && $photo !== '.') {
                                    $photo_ =  explode('.', $photo);
                                    if($photo_[0] !== 'mise_en_avant') {
                                        ?>
                                        <div class="thumbnails" style="position:relative; width: 110px; height: 110px; background-color:whitesmoke;">
                                            <img src="../ajax/miniatures/<?= $Get.'/'.$photo?>" alt="">
                                            <button type="button" class="dd-del" href="../ajax/cancel_drop.php?path=miniatures/<?= $Get.'/'.$photo?>&HQ=HQ/<?= $Get.'/'.$photo?>" value="X" style="position: absolute; top: 0px; left: 0px;">X</button>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="thumbnails" style="position:relative; width: 110px; height: 110px; background-color:darkred;">
                                            <img src="../ajax/miniatures/<?= $Get.'/'.$photo?>" alt="">
                                        </div>
                                        <?php
                                    }
                                }
                            }
                        }
                    ?>
                </div>
                <input style="opacity: 0" type="file" name="drop_file" onchange="handleFiles(this.files)">
                <input style="opacity: 0" type="text" name="dir_photo_name" value="<?= $Get ?>">
                <div class="drop-footer">

                </div>
            </div>

        </div>

        <?php

        echo '</div>';
        return ob_get_clean();
    }

    private function make_select($options, $attributes){
        $this->form = new form();
        ob_start();
            echo "<select {$this->form->Set_Attributes($attributes)} >";
                foreach ($options as $option){
                    $t = ucfirst($option);
                    echo "<option value=\"$option\">$t</option>";
                }
            echo '</select>';
        return ob_get_clean();
    }

    private function make_select_hours($up = 30, $start = 8, $end = 22): void
    {
        $z = [];
        $hours = 60;

        $break = (int) round($hours / $up);

        for ($i = $start; $i <= $end; $i++){
            for ($p = 0; $p < $break; $p++){
                if ($p === 0){
                    $z []= $i .'H00';
                } else {
                    $z []= $i .'H'.($up * $p);
                }
            }
        }
        echo $this->make_select($z, []);
    }
}

