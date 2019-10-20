<?php

if (isset($var)){

    echo  '<div class="login-admin">';
    /**
     * FORMULAIRE DE CONNECTION ADMINISTRATEUR
     */
    echo $this->forms;
    ?>
    <div class="notices">
        <p>
            <?php echo (!empty($var['errors'])) ? $var['errors'] : ''; ?>
        </p>
    </div>

    <div class="login-admin-header">
        <h1>Veuillez vous identifier</h1>
        <p>ou</p>
        <a href="<?= $var['home'] ?>"><button>Retour au site</button></a>
    </div>
    <a href="<?= $var['admin'] ?>">admin</a>

    <?php

    echo '</div>';

} else {

    echo 'il y a un gros problemes ';
}

